<?php

class RepAccountsController extends ORController {

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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'create', 'edit', 'buyMoreAccounts', 'buyMoreAccountsPriceList'),
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

    public function actionIndex() {
        $this->render('index');
    }

    public function actionCreate() {
        $current_plan = RepAdminSubscriptions::model()->getCurrentPlan();
        if (empty($current_plan)) {
            Yii::app()->user->setFlash('danger', "Sorry, you can't create new rep account");
            $this->redirect(array('index'));
        }

        $model = new RepCredentials('create_new_rep_account');
        $profile = new RepCredentialProfiles('step2');

        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];
            $valid = $model->validate();
            $valid = $profile->validate() && $valid;
            if ($valid) {
                $model->rep_role = RepCredentials::ROLE_SINGLE;
                $model->rep_parent_id = Yii::app()->user->id;
                $model->rep_expiry_date = $current_plan['rep_admin_subscription_end'];

                if ($model->save(false)) {
                    //Rep Profile Insert
                    $profile->rep_credential_id = $model->rep_credential_id;
                    $profile->save(false);

                    //Current Plan - Upadate the used and remaining accounts count
                    $current_plan->no_of_accounts_used = $current_plan->no_of_accounts_used + 1;
                    $current_plan->no_of_accounts_remaining = $current_plan->no_of_accounts_remaining - 1;
                    $current_plan->save(false);

                    //Current Plan - New Subscriber Insert
                    $subscriber = new RepAdminSubscribers();
                    $subscriber->rep_admin_subscription_id = $current_plan->rep_admin_subscription_id;
                    $subscriber->rep_credential_id = $model->rep_credential_id;
                    $subscriber->save(false);

                    Yii::app()->user->setFlash('success', "Rep account created successfully!!!");
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create', array('model' => $model, 'profile' => $profile));
    }

    public function actionEdit($id) {
        $model = RepCredentials::model()->findByPk($id);
        $profile = RepCredentialProfiles::model()->findByAttributes(array('rep_credential_id' => $model->rep_credential_id));

        if ($model->rep_parent_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('danger', "Sorry, you don't have access to edit this account");
            $this->redirect(array('index'));
        }

        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];

            $valid = $model->validate();
            $valid = $profile->validate() && $valid;

            if ($valid) {
                if ($model->save(false)) {
                    $profile->save(false);
                    Yii::app()->user->setFlash('success', "Rep account edited successfully!!!");
                    $this->redirect(array('edit', 'id' => $id));
                }
            }
        }

        $this->render('edit', array(
            'model' => $model,
            'profile' => $profile
        ));
    }

    public function actionBuyMoreAccounts() {
        $can_buy = RepAdminSubscriptions::model()->canBuyMoreAccounts();
        if (!$can_buy) {
            Yii::app()->user->setFlash('danger', "Sorry, you can not buy more accounts");
            $this->redirect(array('index'));
        }

        $model = new RepCredentials;
        if (isset($_POST['btnSubmit'])) {
            $subscription = new RepAdminSubscriptions;

            $rep_admin_old_active_accounts = $model->getRepAdminActiveAccountsCount();
            $no_of_accounts_purchase = $_POST['RepCredentials']['no_of_accounts_purchase'];
            $total_no_of_accounts = $rep_admin_old_active_accounts + $no_of_accounts_purchase;
            $price_list = Myclass::repAdminBuyMoreAccountsPriceCalculation($total_no_of_accounts, $no_of_accounts_purchase);

            if ($this->payment()) {
                $subscription->rep_credential_id = Yii::app()->user->id;
                $subscription->rep_subscription_type_id = $price_list['subscription_type_id'];
                $subscription->purchase_type = RepAdminSubscriptions::PURCHASE_TYPE_NEW;
                $subscription->no_of_accounts_purchased = $no_of_accounts_purchase;
                $subscription->rep_admin_old_active_accounts = $rep_admin_old_active_accounts;
                $subscription->no_of_accounts_remaining = $no_of_accounts_purchase;
                $subscription->rep_admin_per_account_price = $price_list['per_account_price'];
                $subscription->rep_admin_total_price = $price_list['total_price'];
                $subscription->rep_admin_tax = $price_list['tax'];
                $subscription->rep_admin_grand_total = $price_list['grand_total'];
                $subscription->rep_admin_subscription_start = date('Y-m-d');
                $subscription->rep_admin_subscription_end = date('Y-m-d', strtotime('+1 month'));

                if ($subscription->save(false)) {
                    Yii::app()->user->setFlash('success', "Thank you for purchase more rep accounts");
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('buyMoreAccounts', array(
            'model' => $model
        ));
    }

    public function actionBuyMoreAccountsPriceList() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RepCredentials;
            $rep_admin_old_active_accounts = $model->getRepAdminActiveAccountsCount();
            $no_of_accounts_purchase = $_POST['no_of_accounts'];
            $total_no_of_accounts = $rep_admin_old_active_accounts + $no_of_accounts_purchase;
            $price_list = Myclass::repAdminBuyMoreAccountsPriceCalculation($total_no_of_accounts, $no_of_accounts_purchase);
            $return = array();
            $return['per_account_price'] = Myclass::currencyFormat($price_list['per_account_price']);
            $return['total_price'] = Myclass::currencyFormat($price_list['total_price']);
            $return['tax'] = Myclass::currencyFormat($price_list['tax']);
            $return['grand_total'] = Myclass::currencyFormat($price_list['grand_total']);
            echo json_encode($return);
        } else {
            $this->redirect(array('dashboard/index'));
        }
    }

    protected function payment() {
        return true;
    }

}
