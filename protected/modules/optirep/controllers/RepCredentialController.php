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
        return array_merge(
                parent::accessRules(), array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('step1', 'step2', 'step3', 'final', 'paypalCancel', 'paypalReturn', 'paypalNotify'),
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
                )
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
        
        $rep_subscription_type = RepSubscriptionTypes::model()->findByPk(Yii::app()->session['registration']['step1']['subscription_type_id']);

        $model = new RepCredentials('step2');
        $profile = new RepCredentialProfiles('step2');

        $model->no_of_accounts_purchase = $rep_subscription_type['rep_subscription_min'];
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
                $address = $profile->rep_address;
                $country = $profile->country;
                $region = $profile->region;
                $cty = $profile->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if ($geo_values != '') {
                    $exp_latlong = explode('~', $geo_values);
                    $_POST['RepCredentialProfiles']['rep_lat'] = $exp_latlong[0];
                    $_POST['RepCredentialProfiles']['rep_long'] = $exp_latlong[1];
                }
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

        $registration = Yii::app()->session['registration'];

        $repTemp = new RepTemp;
        $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
        $repTemp->rep_temp_key = RepTemp::REGISTRATION;
        $repTemp->rep_temp_value = serialize($registration);
        if ($repTemp->save()) {
            Yii::app()->session->destroy();
            $paypalManager = new Paypal;
            $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repCredential/paypalReturn'));
            $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repCredential/paypalCancel'));
            $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repCredential/paypalNotify'));

            $paypalManager->addField('item_name', RepTemp::REGISTRATION);
            $paypalManager->addField('amount', $registration['step3']['per_account_price']);
            $paypalManager->addField('quantity', $registration['step2']['RepCredentials']['no_of_accounts_purchase']);
            $paypalManager->addField('tax', $registration['step3']['tax']);
            $paypalManager->addField('custom', $repTemp->rep_temp_random_id);
            $paypalManager->addField('return', $returnUrl);
            $paypalManager->addField('cancel_return', $cancelUrl);
            $paypalManager->addField('notify_url', $notifyUrl);

            //$paypalManager->dumpFields();   // for printing paypal form fields
            $paypalManager->submitPaypalPost();
        }
    }

    public function actionPaypalCancel() {
        Yii::app()->user->setFlash('danger', 'Your registration has been cancelled. Please try again.');
        $this->redirect(array('step1'));
    }

    public function actionPaypalReturn() {
        $pstatus = $_POST["payment_status"];
        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', "Your payment status is pending. Please contact Admin.");
            } else {
                Yii::app()->user->setFlash('success', "Thanks for your registration!.");
            }
        } else {
            Yii::app()->user->setFlash('danger', "Your registration payment is failed. Please try again later or contact admin.");
        }
        $this->redirect(array('/optirep/default/index'));
    }

    public function actionPaypalNotify() {
        $paypalManager = new Paypal;
        if ($paypalManager->notify()) {
            $this->processPaymentTransaction($_POST['custom']);
            if ($_POST['payment_status'] == "Completed") {
                $this->processRegistration($_POST['custom']);
            }
        }
    }

    protected function processPaymentTransaction($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $registration = unserialize($result['rep_temp_value']);
            $checkTransactionExists = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (empty($checkTransactionExists)) {
                // Save the payment details                                   
                $ptmodel = new PaymentTransaction;
                $ptmodel->total_price = $_POST['mc_gross'];
                $ptmodel->subscription_price = $registration['step3']['total_price'];
                $ptmodel->tax = $registration['step3']['tax'];
                $ptmodel->payment_status = $_POST['payment_status'];
                $ptmodel->payer_email = $_POST['payer_email'];
                $ptmodel->verify_sign = $_POST['verify_sign'];
                $ptmodel->txn_id = $_POST['txn_id'];
                $ptmodel->payment_type = $_POST['payment_type'];
                $ptmodel->receiver_email = $_POST['receiver_email'];
                $ptmodel->txn_type = $_POST['txn_type'];
                $ptmodel->item_name = $_POST['item_name'];
                $ptmodel->NOMTABLE = RepCredentials::NAME_TABLE;
                $ptmodel->invoice_number = $_POST['custom'];
                $ptmodel->pay_type = '1';
                $ptmodel->rep_temp_id = $result['rep_temp_id'];
                $ptmodel->save(false);
            } else {
                $checkTransactionExists->payment_status = $_POST['payment_status'];
                $checkTransactionExists->save(false);
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
                $address = $profile->rep_address;
                $country = $profile->country;
                $region = $profile->region;
                $cty = $profile->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if ($geo_values != '') {
                    $exp_latlong = explode('~', $geo_values);
                    $profile->rep_lat = $exp_latlong[0];
                    $profile->rep_long = $exp_latlong[1];
                }

                $model->save(false);
                $profile->save(false);

                Yii::app()->user->setFlash('success', "Profile updated successfully!!!");
                $this->redirect(array('editprofile'));
            }
        }

        $this->render('editprofile', array('model' => $model, 'profile' => $profile));
    }

    //Change Password for Opti-Rep
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

    //Rep Admin - Accounts change status.
    public function actionChangeStatus() {
        if (Yii::app()->request->isAjaxRequest) {
            $rep_credential_id = $_POST['id'];
            $repCredential = RepCredentials::model()->findByPk($rep_credential_id);
            $repCredential->rep_status = 1 - $repCredential->rep_status;
            $repCredential->save(false);
        } else {
            $this->redirect(array('dashboard/index'));
        }
    }

}
