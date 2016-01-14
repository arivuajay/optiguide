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
                'actions' => array('step1', 'step2', 'step3', 'final', 'paypalCancel', 'paypalReturn', 'paypalNotify', 'generatelatlong', 'finaltmp', 'ppaProblem'),
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

    public function actionGeneratelatlong() {
        $geo_values = '';
        $address = $_POST['RepCredentialProfiles']['rep_address'];
        $country = $_POST['RepCredentialProfiles']['country'];
        $region = $_POST['RepCredentialProfiles']['region'];
        $cty = $_POST['RepCredentialProfiles']['ID_VILLE'];
        $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
        echo $geo_values;
        exit;
    }

    public function actionStep1() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect('/optirep/dashboard');
        }
        $this->layout = '//layouts/anonymous_page';
        $model = new RepCredentials('step1');
        if (isset($_REQUEST['sid'])) {
            $registration = Yii::app()->session['registration'];
            $registration['step1']['subscription_type_id'] = $_REQUEST['sid'];
            Yii::app()->session['registration'] = $registration;
            $this->redirect('/optirep/repCredential/step2');
        }
        $this->render('step1', array('model' => $model, 'step' => 'step1'));
    }

    public function actionStep2() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect('/optirep/dashboard');
        }
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
                // save the other city informations and get cityid
                if ($profile->ID_VILLE == "-1") {
                    $regionid = $profile->region;
                    $othercity = $profile->autre_ville;
                    $condition = "ID_REGION='$regionid' and NOM_VILLE='$othercity'";
                    $city_exist = CityDirectory::model()->find($condition);
                    if (!empty($city_exist)) {
                        $profile->ID_VILLE = $city_exist->ID_VILLE;
                    } else {
                        $cinfo = new CityDirectory;
                        $cinfo->ID_REGION = $regionid;
                        $cinfo->NOM_VILLE = $othercity;
                        $cinfo->country = $profile->country;
                        $cinfo->save(false);
                        $profile->ID_VILLE = $cinfo->ID_VILLE;
                    }
                    $_POST['RepCredentialProfiles']['ID_VILLE'] = $profile->ID_VILLE;
                    $_POST['RepCredentialProfiles']['autre_ville'] = '';
                }

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
        if (!Yii::app()->user->isGuest) {
            $this->redirect('/optirep/dashboard');
        }

        if (!isset(Yii::app()->session['registration']['step2'])) {
            $this->redirect('step2');
        }

        $this->layout = '//layouts/anonymous_page';

        $model = new RepCredentials;
        $registration = Yii::app()->session['registration'];
        $no_of_accounts_purchased = $registration['step2']['RepCredentials']['no_of_accounts_purchase'];
        $no_of_months = $registration['step2']['RepCredentials']['no_of_months'];
        $offer_calculation = true;
        if ($no_of_accounts_purchased > 1) {
            $offer_calculation = false;
        }
        $price_list = Myclass::priceCalculationWithMonths($no_of_months, $no_of_accounts_purchased, $offer_calculation);

        $registration['step1']['subscription_type_id'] = $price_list['subscription_type_id'];
        $registration['step3'] = $price_list;
        Yii::app()->session['registration'] = $registration;

        $sequrity_id = Myclass::getRandomString(8);
        //paypal advance
        $paypalAdv = new PaypalAdvance;
        $request = array(
            "PARTNER" => $paypalAdv::PARTNER,
            "VENDOR" => $paypalAdv::VENDOR,
            "USER" => $paypalAdv::USER,
            "PWD" => $paypalAdv::PWD,
            "TENDER" => "C",
            "TRXTYPE" => "S",
            "CURRENCY" => "CAD",
            "AMT" => $registration['step3']['grand_total'],
            "TAX" => $registration['step3']['tax'],
            "SUBTOTAL" => $registration['step3']['total_price'],
            "CREATESECURETOKEN" => "Y",
            "SECURETOKENID" => $sequrity_id, //Should be unique, never used before
            "RETURNURL" => Yii::app()->createAbsoluteUrl('/optirep/repCredential/final'),
            "CANCELURL" => Yii::app()->createAbsoluteUrl('/optirep/repCredential/ppaProblem'),
            "ERRORURL" => Yii::app()->createAbsoluteUrl('/optirep/repCredential/ppaProblem'),
        );

        //Run request and get the response
        $response = $paypalAdv->run_payflow_call($request);
        $response['mode'] = $paypalAdv::MODE;

        if ($response['RESULT'] != 0) {
            Yii::app()->user->setFlash('danger', "There is some problem in your payment. Please try again.");
            $this->redirect(array('step1'));
        } else {
            $repTemp = new RepTemp;
            $repTemp->rep_temp_random_id = $sequrity_id;
            $repTemp->rep_temp_key = RepTemp::REGISTRATION;
            $repTemp->rep_temp_value = serialize($registration);
            $repTemp->save();
        }

        $model_paypal = new PaymentTransaction();
        $model_paypalAdvance = new PaymentTransaction('paypal_advance');

//      if (isset($_POST['btnSubmit'])) {
//            $process_final = false;
//            if ($_POST['PaymentTransaction']['pay_type'] == 1) {
//                $process_final = true;
//            } elseif ($_POST['PaymentTransaction']['pay_type'] == 2) {
//                $model_paypalAdvance->attributes = $_POST['PaymentTransaction'];
//                $valid = $model_paypalAdvance->validate();
//                if ($valid) {
//                    $process_final = true;
//                }
//            }
//
//            if ($process_final) {
//                $registration = Yii::app()->session['registration'];
//                $registration['step3'] = $price_list;
//                $registration['final'] = $_POST['PaymentTransaction'];
//                Yii::app()->session['registration'] = $registration;
//                $this->redirect('final');
//            }
//        }

        $this->render('step3', array(
            'model' => $model,
            'step' => 'step3',
            'price_list' => $price_list,
            'model_paypal' => $model_paypal,
            'model_paypaladvance' => $model_paypalAdvance,
            'response' => $response
        ));
    }

    public function actionFinal() {
        Yii::app()->session->destroy();
        if (isset($_POST['RESULT']) || isset($_GET['RESULT'])) {
            $response = array_merge($_GET, $_POST);
            $rep_temp_random_id = $response['SECURETOKENID'];
            $this->processPPAPaymentTransaction($rep_temp_random_id, $response);
            $this->processRegistration($rep_temp_random_id);
            Yii::app()->session->open();
            Yii ::app()->user->setFlash('success', Myclass::t("OR605", "", "or"));
            $url = Yii::app()->createAbsoluteUrl('/optirep');
//            $this->redirect(array('/optirep/default/index'));
            echo '<script type="text/javascript">window.top.location.href = "' . $url . '";</script>';
        }
    }

    public function actionPpaProblem() {
        Yii ::app()->user->setFlash('danger', "There is some problem in your payment. Please contact admin.");
        $this->redirect(array('/optirep/repCredential/step1'));
    }

//    public function actionFinal() {
//        if (!Yii::app()->user->isGuest) {
//            $this->redirect('/optirep/dashboard');
//        }
//
//        if (!isset(Yii::app()->session['registration']['step3'])) {
//            $this->redirect('step3');
//        }
//
//        $this->layout = '//layouts/anonymous_page';
//
//        $registration = Yii::app()->session['registration'];
//        $payment = $registration['final'];
//
//        //Remove CC details from registration array
//        unset($registration['final']);
//
//        $repTemp = new RepTemp;
//        $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
//        $repTemp->rep_temp_key = RepTemp::REGISTRATION;
//        $repTemp->rep_temp_value = serialize($registration);
//        if ($repTemp->save()) {
//            Yii::app()->session->destroy();
//
//            if ($payment['pay_type'] == 1) {
//                //paypal
//                $paypalManager = new Paypal;
//                $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repCredential/paypalReturn'));
//                $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repCredential/paypalCancel'));
//                $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repCredential/paypalNotify'));
//
//                $paypalManager->addField('item_name', RepTemp::REGISTRATION);
//                $paypalManager->addField('amount', $registration['step3']['total_price']);
////            $paypalManager->addField('quantity', $registration['step2']['RepCredentials']['no_of_accounts_purchase']);
//                $paypalManager->addField('tax', $registration['step3']['tax']);
//                $paypalManager->addField('custom', $repTemp->rep_temp_random_id);
//                $paypalManager->addField('return', $returnUrl);
//                $paypalManager->addField('cancel_return', $cancelUrl);
//                $paypalManager->addField('notify_url', $notifyUrl);
//
//                //$paypalManager->dumpFields();   // for printing paypal form fields
//                $paypalManager->submitPaypalPost();
//            } elseif ($payment['pay_type'] == 2) {
//                //paypal advance
//                $paypalAdv = new PaypalAdvance;
//                $request = array(
//                    "PARTNER" => $paypalAdv::PARTNER,
//                    "VENDOR" => $paypalAdv::VENDOR,
//                    "USER" => $paypalAdv::USER,
//                    "PWD" => $paypalAdv::PWD,
//                    "TENDER" => "C",
//                    "TRXTYPE" => "S",
//                    "CURRENCY" => "CAD",
//                    "AMT" => $registration['step3']['grand_total'],
//                    "ACCT" => $payment['credit_card'],
//                    "EXPDATE" => $payment['exp_month'] . $payment['exp_year'],
//                    "CVV2" => $payment['cvv2'],
//                );
//
//                //Run request and get the response
//                $response = $paypalAdv->run_payflow_call($request);
//                if ($response['RESULT'] == 0 && $response['RESPMSG'] == 'Approved') {
//                    $this->processPPAPaymentTransaction($repTemp->rep_temp_random_id, $response);
//                    $this->processRegistration($repTemp->rep_temp_random_id);
//                    Yii::app()->session->open();
//                    Yii::app()->user->setFlash('success', Myclass::t("OR605", "", "or"));
//                    $this->redirect(array('/optirep/default/index'));
//                } else {
//                    Yii::app()->user->setFlash('danger', Myclass::t("OR606", "", "or"));
//                    $this->redirect(array('step1'));
//                }
//            }
//        }
//    }

    /* ------------ PAYPAL ADVANCE START----------------------------------------- */

    public function processPPAPaymentTransaction($rep_temp_random_id, $response) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $registration = unserialize($result['rep_temp_value']);
            $checkTransactionExists = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (empty($checkTransactionExists)) {
                // Save the payment details                                   
                $ptmodel = new PaymentTransaction;
                $ptmodel->total_price = $registration['step3']['grand_total'];
                $ptmodel->subscription_price = $registration['step3']['total_price'];
                $ptmodel->tax = $registration['step3']['tax'];
                $ptmodel->payment_status = 'Completed';
//                $ptmodel->payer_email = $_POST['payer_email'];
//                $ptmodel->verify_sign = $_POST['verify_sign'];
                $ptmodel->txn_id = $response['PNREF'];
                $ptmodel->payment_type = 'ppa';
//                $ptmodel->receiver_email = $_POST['receiver_email'];
//                $ptmodel->txn_type = $_POST['txn_type'];
                $ptmodel->item_name = $result['rep_temp_key'];
                $ptmodel->NOMTABLE = RepCredentials::NAME_TABLE;
                $ptmodel->invoice_number = $result['rep_temp_random_id'];
                $ptmodel->pay_type = '2';
                $ptmodel->rep_temp_id = $result['rep_temp_id'];
                $ptmodel->save(false);
            }
        }
    }

    /* ------------ PAYPAL ADVANCE END----------------------------------------- */

    /* ------------ PAYPAL START----------------------------------------- */

    public function actionPaypalCancel() {
        Yii :: app()->user->setFlash('danger', Myclass::t("OR603", "", "or"));
        $this->redirect(array
            ('step1'));
    }

    public function actionPaypalReturn() {
        $pstatus = $_POST["payment_status"];
        if (isset($_POST["txn_id"]) && isset($_POST ["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii:: app()->user->setFlash('info', Myclass::t("OR604", "", "or"));
            } else {
                Yii ::app()->user->setFlash('success', Myclass::t("OR605", "", "or"));
            }
        } else {
            Yii :: app()->user->setFlash('danger', Myclass::t("OR606", "", "or"));
        }
        $this->redirect(array
            ('/optirep/default/index'));
    }

    public function actionPaypalNotify() {
        $paypalManager = new Paypal;
        if ($paypalManager->notify()) {
            $this->processPaymentTransaction($_POST['custom']);
            if ($_POST['payment_status'] == "Completed") {
                $this->processRegistration(
                        $_POST['custom']);
            }
        }
    }

    protected function processPaymentTransaction($rep_temp_random_id) {
        $baseurl = Yii::app()->request->getBaseUrl(true);
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

            if ($_POST['payment_status'] == "Pending") {
                $rep_email = $registration['step2']['RepCredentialProfiles']['rep_profile_email'];
                if (!empty($rep_email)) {
                    $rep_username = $registration['step2']['RepCredentials']['rep_username'];
                    $mail = new Sendmail;
                    $this->lang = Yii::app()->session['language'];
                    $contact_url = $baseurl . '/optirep/default/contactus';
                    $trans_array = array(
                        "{USERNAME}" => $rep_username,
                        "{NEXTSTEPURL}" => $contact_url,);
                    if ($this->lang == 'EN') {
                        $subject = SITENAME . " - Registration - Payment Status Pending ";
                    } elseif ($this->lang == 'FR') {
                        $subject = " Abonnement à " . SITENAME;
                    }
                    $message = $mail->getMessage('rep_registration_pending_status', $trans_array);
//                    $Subject = $mail->translate('Registration - Payment Status Pending');
                    $mail->send($rep_email, $subject, $message);
                }
            }
        }
    }

    /* ------------ PAYPAL END----------------------------------------- */

    public function actionEditProfile() {
        $model = RepCredentials::model()->findByAttributes(array('rep_credential_id' => Yii::app()->user->id));
        $model->scenario = 'update';

        $profile = RepCredentialProfiles::model()->findByAttributes(array('rep_credential_id' => Yii::app()->user->id));
        $profile->scenario = 'update';

        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];

            $profile->image = CUploadedFile::getInstance($profile, 'image');
            $valid = $model->validate();
            $valid = $profile->validate() && $valid;

            if ($valid) {
                // save the other city informations and get cityid
                if ($profile->ID_VILLE == "-1") {
                    $regionid = $profile->region;
                    $othercity = $profile->autre_ville;
                    $condition = "ID_REGION='$regionid' and NOM_VILLE='$othercity'";
                    $city_exist = CityDirectory::model()->find($condition);
                    if (!empty($city_exist)) {
                        $profile->ID_VILLE = $city_exist->ID_VILLE;
                    } else {
                        $cinfo = new CityDirectory;
                        $cinfo->ID_REGION = $regionid;
                        $cinfo->NOM_VILLE = $othercity;
                        $cinfo->country = $profile->country;
                        $cinfo->save(false);
                        $profile->ID_VILLE = $cinfo->ID_VILLE;
                    }
                }

                $address = $profile->rep_address;
                $country = $profile->country;
                $region = $profile->region;
                $cty = $profile->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);

                // save profile
                if ($profile->image) {
                    $imgname = time() . '_' . $profile->image->name;
                    $profile->rep_profile_picture = $imgname;
                    $rep_img_path = Yii::getPathOfAlias('webroot') . '/' . REP_PROFILE_PICTURE;
                    if (!is_dir($rep_img_path)) {
                        mkdir($rep_img_path, 0777, true);
                    }
                    $profile->image->saveAs($rep_img_path . $imgname);
                }

                if ($geo_values != '') {
                    $exp_latlong = explode('~', $geo_values);
                    $profile->rep_lat = $exp_latlong[0];
                    $profile->rep_long = $exp_latlong[1];
                }

                if ($_POST['marqueid']) {
                    $profile->rep_brands = implode(',', $_POST['marqueid']);
                }

                $model->save(false);
                $profile->save(false);
                Yii ::app()->user->setFlash('success', Myclass::t("OR607", "", "or"));
                $this->redirect(array('editprofile'));
            }
        }

        $this->render('editprofile', array('model' => $model, 'profile' =>
            $profile));
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
                    Yii ::app()->user->setFlash('success', Myclass::t("OR608", "", "or"));
                    $this->redirect(array('changepassword'));
                } else {
                    Yii :: app()->user->setFlash('danger', Myclass::t("OR609", "", "or"));
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
