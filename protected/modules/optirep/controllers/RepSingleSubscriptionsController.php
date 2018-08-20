<?php

class RepSingleSubscriptionsController extends ORController {

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
                'actions' => array('paypalRenewalCancel', 'paypalRenewalReturn', 'paypalRenewalNotify','getPrice'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'transactions', 'renewal', 'final', 'durationRenewal'),
                'users' => array('@'),
                'expression' => array('RepSingleSubscriptionsController', 'allowOnlyRepSingleWithNoParent')
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

    public static function allowOnlyRepSingleWithNoParent() {
        if (Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE && Yii::app()->user->rep_parent_id == 0) {
            return true;
        }
    }

    public function actionIndex() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("rep_credential_id = '" . Yii::app()->user->id . "'");
        $criteria->order = 'created_at DESC';

        $model = new CActiveDataProvider('RepSingleSubscriptions', array(
            'criteria' => $criteria,
        ));

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionDurationRenewal() {
        $model = RepSingleSubscriptions;

        $no_of_accounts_purchase = 1;
        $no_of_months = 1;
        $offer_calculation = false;
        $price_calculation = Myclass::priceCalculationWithMonths($no_of_months, $no_of_accounts_purchase, $offer_calculation);


        $this->render('renew', array(
            'price_calculation' => $price_calculation,
            'model' => $model,
//            'response' => $response
        ));
    }

    public function actionGetPrice() {
        $no_of_accounts_purchase = 1;
        $no_of_months = $_POST['month'];
        $offer_calculation = false;
        $price_calculation = Myclass::priceCalculationWithMonths($no_of_months, $no_of_accounts_purchase, $offer_calculation);
        $data['total_price'] = Myclass::currencyFormat($price_calculation['total_price']);
        $data['tax'] = Myclass::currencyFormat($price_calculation['tax']);
        $data['grand_total'] = Myclass::currencyFormat($price_calculation['grand_total']);
        echo json_encode($data);
        exit;
    }

    public function actionRenewal() {
        $no_of_accounts_purchase = 1;
        $flag = '0';
        if($_POST['RepSingleSubscriptions']){
            $no_of_months = $_POST['RepSingleSubscriptions'];
            Yii::app()->session['no_of_months'] = $no_of_months;
        }else if(isset(Yii::app()->session['no_of_months'])){
            $no_of_months = Yii::app()->session['no_of_months'];
        }else{
            $no_of_months = 1;
        }
        
        $model = new RepCredentials('payment');
        $this->performAjaxValidation(array($model));
        
        $offer_calculation = false;
        $price_calculation = Myclass::priceCalculationWithMonths($no_of_months, $no_of_accounts_purchase, $offer_calculation);
        
        $model_paypal = new PaymentTransaction();
        $model_paypalAdvance = new PaymentTransaction('paypal_advance');
        
        if(isset($_POST['renewal_btnSubmit'])){            
            $payment_type = $_POST['RepCredentials']['payment_type'];

            if ($payment_type != '') {
                
                $sequrity_id = Myclass::getRandomString(8);
                $data = array();
                $data['pay_type'] = $payment_type;
                $data['price_list'] = $price_calculation;
                $data['rep_credential_id'] = Yii::app()->user->id;
                $data['purchase_type'] = RepSingleSubscriptions::PURCHASE_TYPE_RENEWAL;
                        
                 if($payment_type == '1'){
                     
                    $repTemp = new RepTemp;
                    $repTemp->rep_temp_random_id = $sequrity_id;
                    $repTemp->rep_temp_key = RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT;
                    $repTemp->rep_temp_value = serialize($data);
                    $repTemp->save();
                    $this->paypaltest($price_calculation, $sequrity_id);    
                        
                }else{
                    $response  = $this->pay_with_creditcard($sequrity_id,$price_calculation);
                    
                    if ($response['RESULT'] != 0) {
                        Yii::app()->user->setFlash('danger', "There is some problem in your payment. Please try again.");
                        $this->redirect(array('/optirep/repSingleSubscriptions/index'));                   
                    } else {

                        $repTemp = new RepTemp;
                        $repTemp->rep_temp_random_id = $sequrity_id;
                        $repTemp->rep_temp_key = RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT;
                        $repTemp->rep_temp_value = serialize($data);
                        $repTemp->save();
                        
                        $paypalAdv = new PaypalAdvance;
                        $securetoken   = $response['SECURETOKEN'];
                        $securetokenid = $response['SECURETOKENID'];
                        $mode = $paypalAdv::$MODE;
                        $this->finalstep($securetoken,$securetokenid,$mode);
                        $flag = 1;
                    }
                }
                
            }
        }     
//        if (isset($_POST['btnSubmit'])) {
//            if ($_POST['PaymentTransaction']['pay_type'] == 1) {
//                //paypal
//                $data = array();
//                $data['pay_type'] = $_POST['PaymentTransaction']['pay_type'];
//                $data['price_list'] = $price_calculation;
//                $data['rep_credential_id'] = Yii::app()->user->id;
//                $data['purchase_type'] = RepSingleSubscriptions::PURCHASE_TYPE_RENEWAL;
//
//                $repTemp = new RepTemp;
//                $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
//                $repTemp->rep_temp_key = RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT;
//                $repTemp->rep_temp_value = serialize($data);
//
//                if ($repTemp->save()) {
//                    $paypalManager = new Paypal;
//                    $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalReturn'));
//                    $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalCancel'));
//                    $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalNotify'));
//
//                    $paypalManager->addField('item_name', RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT);
//                    $paypalManager->addField('amount', $data['price_list']['total_price']);
////                $paypalManager->addField('quantity', $no_of_accounts_purchase);
//                    $paypalManager->addField('tax', $data['price_list']['tax']);
//                    $paypalManager->addField('custom', $repTemp->rep_temp_random_id);
//                    $paypalManager->addField('return', $returnUrl);
//                    $paypalManager->addField('cancel_return', $cancelUrl);
//                    $paypalManager->addField('notify_url', $notifyUrl);
//
//                    $paypalManager->submitPaypalPost();
//                }
//            } elseif ($_POST['PaymentTransaction']['pay_type'] == 2) {
//                $model_paypalAdvance->attributes = $_POST['PaymentTransaction'];
//                $valid = $model_paypalAdvance->validate();
//                if ($valid) {
//                    $data = array();
//                    $data['pay_type'] = $_POST['PaymentTransaction']['pay_type'];
//                    $data['price_list'] = $price_calculation;
//                    $data['rep_credential_id'] = Yii::app()->user->id;
//                    $data['purchase_type'] = RepSingleSubscriptions::PURCHASE_TYPE_RENEWAL;
//
//                    $repTemp = new RepTemp;
//                    $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
//                    $repTemp->rep_temp_key = RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT;
//                    $repTemp->rep_temp_value = serialize($data);
//
//                    if ($repTemp->save()) {
//                        $paypalAdv = new PaypalAdvance;
//                        $request = array(
//                            "PARTNER" => $paypalAdv::$PARTNER,
//                            "VENDOR" => $paypalAdv::$VENDOR,
//                            "USER" => $paypalAdv::$USER,
//                            "PWD" => $paypalAdv::$PWD,
//                            "TENDER" => "C",
//                            "TRXTYPE" => "S",
//                            "CURRENCY" => "CAD",
//                            "AMT" => $data['price_list']['grand_total'],
//                            "ACCT" => $model_paypalAdvance->credit_card,
//                            "EXPDATE" => $model_paypalAdvance->exp_month . $model_paypalAdvance->exp_year,
//                            "CVV2" => $model_paypalAdvance->cvv2,
//                        );
//
//                        //Run request and get the response
//                        $response = $paypalAdv->run_payflow_call($request);
//                        if ($response['RESULT'] == 0 && $response['RESPMSG'] == 'Approved') {
//                            $this->processPPARenewalPaymentTransaction($repTemp->rep_temp_random_id, $response);
//                            $this->processRenewalSingleRepAccount($repTemp->rep_temp_random_id);
//                            Yii::app()->user->setFlash('success', Myclass::t('OR648', '', 'or'));
//                            $this->redirect(array('renewal'));
//                        } else {
//                            Yii::app()->user->setFlash('danger', Myclass::t('OR649', '', 'or'));
//                            $this->redirect(array('renewal'));
//                        }
//                    }
//                }
//            }
//        }

        if($flag !='1'){ 
            $this->render('renewal', array(
                'model' => $model,
                'price_calculation' => $price_calculation,
                'model_paypal' => $model_paypal,
                'model_paypaladvance' => $model_paypalAdvance,
                'response' => $response,
                'duration' => $no_of_months,
            ));
        }
    }
     public function finalstep($securetoken,$securetokenid,$mode,$step='step3')
    {
        $viewpage = '_paymentfinal_form';
        $this->render($viewpage, compact('securetoken', 'securetokenid','mode','step'));
    }
    protected function pay_with_creditcard($sequrity_id, $price_calculation) {
        $paypalAdv = new PaypalAdvance;
        $request = array(
            "PARTNER" => $paypalAdv::$PARTNER,
            "VENDOR" => $paypalAdv::$VENDOR,
            "USER" => $paypalAdv::$USER,
            "PWD" => $paypalAdv::$PWD,
            "TENDER" => "C",
            "TRXTYPE" => "S",
            "CURRENCY" => "CAD",
            "AMT" => $price_calculation['grand_total'],
            "TAX" => $price_calculation['tax'],
            "SUBTOTAL" => $price_calculation['total_price'],
            "CREATESECURETOKEN" => "Y",
            "SECURETOKENID" => $sequrity_id, //Should be unique, never used before
            "RETURNURL" => Yii::app()->createAbsoluteUrl('/optirep/repSingleSubscriptions/final'),
            "CANCELURL" => Yii::app()->createAbsoluteUrl('/optirep/repSingleSubscriptions/index'),
            "ERRORURL" => Yii::app()->createAbsoluteUrl('/optirep/repSingleSubscriptions/index'),
        );
        //Run request and get the response
        $response = $paypalAdv->run_payflow_call($request);
        return $response;
    }

    public function actionFinal() {
        if (isset($_POST['RESULT']) || isset($_GET['RESULT'])) {
            $response = array_merge($_GET, $_POST);
            $rep_temp_random_id = $response['SECURETOKENID'];
            $this->processPPARenewalPaymentTransaction($rep_temp_random_id, $response);
            $this->processRenewalSingleRepAccount($rep_temp_random_id);
            Yii::app()->user->setFlash('success', Myclass::t('OR648', '', 'or'));
            $url = Yii::app()->createAbsoluteUrl('/optirep/repSingleSubscriptions/index');
            echo '<script type="text/javascript">window.top.location.href = "' . $url . '";</script>';
        }
    }

    /* --------- PAYPAL ADVANCE START-------------------------------- */

    protected function processPPARenewalPaymentTransaction($rep_temp_random_id, $response) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $checkTransactionExists = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (empty($checkTransactionExists)) {
                $renewal_details = unserialize($result['rep_temp_value']);
                $price_list = $renewal_details['price_list'];

                $ptmodel = new PaymentTransaction;
                $ptmodel->user_id = $renewal_details['rep_credential_id'];
                $ptmodel->total_price = $price_list['grand_total'];
                $ptmodel->subscription_price = $price_list['total_price'];
                $ptmodel->tax = $price_list['tax'];
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

    /* --------- PAYPAL ADVANCE END-------------------------------- */

    /* --------- PAYPAL START-------------------------------- */
    
    public function paypaltest($price_calculation, $sequrity_id) {
        $paypalManager = new Paypal;
        
        $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalReturn'));
        $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalCancel'));
        $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalNotify'));

        $paypalManager->addField('item_name', RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT);
        $paypalManager->addField('amount', $price_calculation['grand_total']);
        $paypalManager->addField('custom', $sequrity_id);
        $paypalManager->addField('return', $returnUrl);
        $paypalManager->addField('cancel_return', $cancelUrl);
        $paypalManager->addField('notify_url', $notifyUrl);
        $paypalManager->addField('no_shipping', 1);
        

        //$paypalManager->dumpFields();   // for printing paypal form fields
        $paypalManager->submitPaypalPost();
    }
    public function actionPaypalRenewalCancel() {
        Yii::app()->user->setFlash('danger', Myclass::t("OR613", "", "or"));
        $this->redirect(array('index'));
    }

    public function actionPaypalRenewalReturn() {
        
        if(isset($_GET)){
            $pstatus = $_GET["st"];
            $txn_id = $_GET["tx"];
        } else if(isset ($_POST)) {
            $pstatus = $_POST["payment_status"];
            $txn_id = $_POST["txn_id"];
        }  
        if (isset($txn_id) && isset($pstatus)) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', Myclass::t("OR597", "", "or"));
            } else {
                Yii::app()->user->setFlash('success', Myclass::t("OR601", "", "or"));
            }
        } else {
            Yii::app()->user->setFlash('danger', Myclass::t("OR602", "", "or"));
        }
        $this->redirect(array('index'));
    }

    public function actionPaypalRenewalNotify() {
        $paypalManager = new Paypal;
        if ($paypalManager->notify()) {
            $this->processRenewalPaymentTransaction($_POST['custom']);
            if ($_POST['payment_status'] == "Completed") {
                $this->processRenewalSingleRepAccount($_POST['custom']);
            }
//            $message .= "Invoice Number: ".$_POST['custom'];
//            $message .= "\nName : ".$_POST['first_name'].$_POST['last_name'];
//            $message .= "\nPayer Status: ".$_POST['payer_status'];
//            $message .= "\nPayment Status: ".$_POST['payment_status'];
//
//
//            $to = "nachiyappan.arumugam@arkinfotec.com";
//            $subject = 'The subject';
//
//            $headers = 'From: webmaster@example.com' . "\r\n" .
//                'Reply-To: webmaster@example.com' . "\r\n" .
//                'X-Mailer: PHP/' . phpversion();
//
//            mail($to, $subject, $message, $headers);
        }
    }

    protected function processRenewalPaymentTransaction($rep_temp_random_id) {
        $baseurl = Yii::app()->request->getBaseUrl(true);
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $checkTransactionExists = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (empty($checkTransactionExists)) {
                $renewal_details = unserialize($result['rep_temp_value']);
                $price_list = $renewal_details['price_list'];

                $ptmodel = new PaymentTransaction;
                $ptmodel->user_id = $renewal_details['rep_credential_id'];
                $ptmodel->total_price = $_POST['mc_gross'];
                $ptmodel->subscription_price = $price_list['total_price'];
                $ptmodel->tax = $price_list['tax'];
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
                $rep_account = RepCredentials::model()->findByPk($renewal_details['rep_credential_id']);
                $rep_profile = $rep_account->repCredentialProfiles;
                $rep_email = $rep_profile['rep_profile_email'];
                if (!empty($rep_email)) {
                    $rep_username = $rep_account['rep_username'];
                    $mail = new Sendmail;
                    $this->lang = Yii::app()->session['language'];
                    $contact_url = $baseurl . '/optirep/default/contactus';
                    $trans_array = array(
                        "{USERNAME}" => $rep_username,
                        "{NEXTSTEPURL}" => $contact_url,
                    );
                    if ($this->lang == 'EN') {
                        $subject = SITENAME . " - Renewal - Payment Status Pending";
                    } elseif ($this->lang == 'FR') {
                        $subject = " Renouvellement à " . SITENAME;
                    }
                    $message = $mail->getMessage('rep_renewal_pending_status', $trans_array);
                    $mail->send($rep_email, $subject, $message);
                }
            }
        }
    }

    /* --------- PAYPAL END-------------------------------- */

    public function actionTransactions() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("user_id = '" . Yii::app()->user->id . "'");
        $criteria->addCondition("NOMTABLE = '" . RepCredentials::NAME_TABLE . "'");
        $criteria->order = 'created_at DESC';

        $model = new CActiveDataProvider('PaymentTransaction', array(
            'criteria' => $criteria,
        ));

        $this->render('transactions', array(
            'model' => $model
        ));
    }
    
    /**
     * Performs the AJAX validation.
     * @param SuppliersDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rep-singlesubscriptions-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
