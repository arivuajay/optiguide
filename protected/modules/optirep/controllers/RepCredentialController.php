<?php

class RepCredentialController extends ORController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('step1', 'step2', 'step3', 'final'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('changePassword', 'editProfile', 'changeStatus'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionStep1() {
        $this->layout = '//layouts/anonymous_page';
        $model = new RepCredentials('step1');
        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $valid = $model->validate();
            if ($valid) {
                $registration = Yii::app()->session['registration'];
                $registration['step1'] = $_POST['RepCredentials'];
                Yii::app()->session['registration'] = $registration;
                $this->redirect('step2');
            }
        }
        $this->render('step1', array('model' => $model, 'step' => 'step1'));
    }

    public function actionStep2() {
        $this->layout = '//layouts/anonymous_page';
        if (!isset(Yii::app()->session['registration']['step1'])) {
            $this->redirect('step1');
        }

        $model = new RepCredentials('step2');
        $profile = new RepCredentialProfiles('step2');

        if (isset(Yii::app()->session['registration']['step2'])) {
            $model->attributes = Yii::app()->session['registration']['step2']['RepCredentials'];
            $profile->attributes = Yii::app()->session['registration']['step2']['RepCredentialProfiles'];
        }
        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];
            $valid = $model->validate();
            $valid = $profile->validate() && $valid;
            if ($valid) {
                $registration = Yii::app()->session['registration'];
                $registration['step2']['RepCredentials'] = $_POST['RepCredentials'];
                $registration['step2']['RepCredentialProfiles'] = $_POST['RepCredentialProfiles'];
                Yii::app()->session['registration'] = $registration;
                $this->redirect('step3');
            }
        }
        $this->render('step2', array('model' => $model, 'profile' => $profile, 'step' => 'step2'));
    }

    public function actionStep3() {
        $this->layout = '//layouts/anonymous_page';
        if (!isset(Yii::app()->session['registration']['step2'])) {
            $this->redirect('step2');
        }

        $model = new RepCredentials;
        $registration = Yii::app()->session['registration'];
        $no_of_accounts_purchased = $registration['step2']['RepCredentials']['no_of_accounts_purchase'];
        $price_list = Myclass::priceCalculation($no_of_accounts_purchased);

        $registration['step1']['subscription_type_id'] = $price_list['subscription_type_id'];
        Yii::app()->session['registration'] = $registration;

        if (isset($_POST['btnSubmit'])) {
            $registration = Yii::app()->session['registration'];
            $registration['step3'] = $price_list;
            Yii::app()->session['registration'] = $registration;
            $this->redirect('final');
        }
        $this->render('step3', array('model' => $model, 'step' => 'step3', 'price_list' => $price_list));
    }

    public function actionFinal() {
        $this->layout = '//layouts/anonymous_page';
        if (!isset(Yii::app()->session['registration']['step3'])) {
            $this->redirect('step3');
        }

        if ($this->payment()) {
            $registration = Yii::app()->session['registration'];
            $model = new RepCredentials;
            $model->rep_username = $registration['step2']['RepCredentials']['rep_username'];
            $model->rep_password = $registration['step2']['RepCredentials']['rep_password'];
            if ($registration['step2']['RepCredentials']['no_of_accounts_purchase'] > 1) {
                $model->rep_role = RepCredentials::ROLE_ADMIN;
            } else {
                $model->rep_role = RepCredentials::ROLE_SINGLE;
                $model->rep_expiry_date = date('Y-m-d', strtotime('+1 month'));
            }

            if ($model->save(false)) {
                $repProfile = new RepCredentialProfiles;
                $repProfile->attributes = $registration['step2']['RepCredentialProfiles'];
                $repProfile->rep_credential_id = $model->rep_credential_id;
                $repProfile->save(false);

                if ($model->rep_role == RepCredentials::ROLE_SINGLE) {
                    $repSingle = new RepSingleSubscriptions;
                    $repSingle->rep_credential_id = $model->rep_credential_id;
                    $repSingle->rep_subscription_type_id = $registration['step1']['subscription_type_id'];
                    $repSingle->purchase_type = RepSingleSubscriptions::PURCHASE_TYPE_NEW;
                    $repSingle->rep_single_price = $registration['step3']['per_account_price'];
                    $repSingle->rep_single_tax = $registration['step3']['tax'];
                    $repSingle->rep_single_total = $registration['step3']['grand_total'];
                    $repSingle->rep_single_subscription_start = date('Y-m-d');
                    $repSingle->rep_single_subscription_end = date('Y-m-d', strtotime('+1 month'));
                    $repSingle->save(false);
                } elseif ($model->rep_role == RepCredentials::ROLE_ADMIN) {
                    $repAdmin = new RepAdminSubscriptions;
                    $repAdmin->rep_credential_id = $model->rep_credential_id;
                    $repAdmin->rep_subscription_type_id = $registration['step1']['subscription_type_id'];
                    $repAdmin->purchase_type = RepAdminSubscriptions::PURCHASE_TYPE_NEW;
                    $repAdmin->no_of_accounts_purchased = $registration['step2']['RepCredentials']['no_of_accounts_purchase'];
                    $repAdmin->no_of_accounts_remaining = $registration['step2']['RepCredentials']['no_of_accounts_purchase'];
                    $repAdmin->rep_admin_per_account_price = $registration['step3']['per_account_price'];
                    $repAdmin->rep_admin_total_price = $registration['step3']['total_price'];
                    $repAdmin->rep_admin_tax = $registration['step3']['tax'];
                    $repAdmin->rep_admin_grand_total = $registration['step3']['grand_total'];
                    $repAdmin->rep_admin_subscription_start = date('Y-m-d');
                    $repAdmin->rep_admin_subscription_end = date('Y-m-d', strtotime('+1 month'));
                    $repAdmin->save(false);
                }
                Yii::app()->session->destroy();
                $this->redirect(array('/optirep/default/index'));
            }
        }
    }

    public function actionEditProfile() {

        $model = RepCredentials::model()->findByAttributes(array('rep_credential_id' => Yii::app()->user->id));
        $model->scenario = 'update';

        $profile = RepCredentialProfiles::model()->findByAttributes(array('rep_credential_id' => Yii::app()->user->id));
        $profile->scenario = 'update';

        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];
            $valid = $model->validate();
            $valid = $profile->validate() && $valid;

            if ($valid) {
                $model->save(false);
                $profile->save(false);

                Yii::app()->user->setFlash('success', "Profile updated successfully!!!");
                $this->redirect(array('editprofile'));
            }
        }

        $this->render('editprofile', array('model' => $model, 'profile' => $profile,));
    }

    public function actionChangePassword() {
        $model = new RepCredentials;
        $model = RepCredentials::model()->findByAttributes(array('rep_credential_id' => Yii::app()->user->id));
        $model->setScenario('changePwd');

        if (isset($_POST['RepCredentials'])) {
            $model->attributes = $_POST['RepCredentials'];
            $valid = $model->validate();

            if ($valid) {
                $model->rep_password = $model->new_password;
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "successfully changed password");
                    $this->redirect(array('changepassword'));
                } else {
                    Yii::app()->user->setFlash('danger', "password not changed");
                    $this->redirect(array('changepassword'));
                }
            }
        }

        $this->render('changePassword', array('model' => $model));
    }
    
    public function actionChangeStatus(){
        if(Yii::app()->request->isAjaxRequest){
              $rep_credential_id = $_POST['id'];
              $repCredential = RepCredentials::model()->findByPk($rep_credential_id);
              $repCredential->rep_status = 1 - $repCredential->rep_status;
              $repCredential->save(false);
        } else {
            $this->redirect(array('dashboard/index'));
        }
    }

    protected function payment() {
        return true;
    }

    /**
     * Performs the AJAX validation.
     * @param ArchiveCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rep-credential-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
