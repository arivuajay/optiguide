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
                'actions' => array('paypalCancel', 'paypalReturn', 'paypalNotify', 'paypalRenewalCancel', 'paypalRenewalReturn', 'paypalRenewalNotify'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'create', 'edit', 'delete', 'buyMoreAccounts', 'buyMoreAccountsPriceList', 'renewalRepAccounts', 'subscriptions', 'transactions'),
                'users' => array('@'),
                'expression' => 'Yii::app()->user->rep_role=="admin"'
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
        if (isset($_POST['renewalSubmit'])) {
            if (isset($_POST['rep_credentials'])) {
                $renewal = Yii::app()->session['renewal'];
                $renewal['rep_credential_id'] = Yii::app()->user->id;
                $renewal['no_of_accounts_purchase'] = count($_POST['rep_credentials']);
                $renewal['rep_credentials'] = $_POST['rep_credentials'];
                $renewal['price_list'] = Myclass::priceCalculationWithMonths(1, $renewal['no_of_accounts_purchase'], false);
                Yii::app()->session['renewal'] = $renewal;
                $this->redirect('renewalRepAccounts');
            } else {
                Yii::app()->user->setFlash('danger', Myclass::t("OR589", "", "or"));
            }
        }
        $this->render('index');
    }

    public function actionCreate() {
        $current_plan = RepAdminSubscriptions::model()->getCurrentPlan();
        if (empty($current_plan)) {
            Yii::app()->user->setFlash('danger', Myclass::t("OR590", "", "or"));
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

                    Yii::app()->user->setFlash('success', Myclass::t("OR591", "", "or"));
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
            Yii::app()->user->setFlash('danger', Myclass::t("OR592", "", "or"));
            $this->redirect(array('index'));
        }

        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];

            $valid = $model->validate();
            $valid = $profile->validate() && $valid;

            if ($valid) {
                if ($model->save(false)) {

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

                    $profile->save(false);
                    Yii::app()->user->setFlash('success', Myclass::t("OR593", "", "or"));
                    $this->redirect(array('edit', 'id' => $id));
                }
            }
        }

        $this->render('edit', array(
            'model' => $model,
            'profile' => $profile
        ));
    }

    public function actionDelete($id) {
        $rep = RepCredentials::model()->findByPk($id);
        if ($rep === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $rep_profile = $rep->repCredentialProfiles;
        $rep_admin_subscribers = $rep->repAdminSubscribers;

        //Rep Account - Delete
        RepCredentials::model()->deleteByPk($rep['rep_credential_id']);

        //Check what plan this rep entered, Once find then increase count in the "rep_admin_subscriptions" Table 
        $entry_plan = '';
        foreach ($rep_admin_subscribers as $rep_admin_subscriber) {
            $rep_admin_subscription_id = $rep_admin_subscriber['rep_admin_subscription_id'];

            $find_entry_plan = RepAdminSubscriptions::model()->find(
                    "rep_admin_subscription_id = :RASID AND purchase_type = :PT", array(
                ':RASID' => $rep_admin_subscription_id,
                ':PT' => RepAdminSubscriptions::PURCHASE_TYPE_NEW
                    )
            );

            if ($find_entry_plan) {
                $entry_plan = $find_entry_plan;
                break;
            }
        }

        //Update count
        if ($entry_plan) {
            $entry_plan->no_of_accounts_used = $entry_plan->no_of_accounts_used - 1;
            $entry_plan->no_of_accounts_remaining = $entry_plan->no_of_accounts_remaining + 1;
            $entry_plan->save(false);
        }

        //rep_favourites - Delete
        RepFavourites::model()->deleteAll("rep_credential_id ='" . $rep['rep_credential_id'] . "'");

        //rep_loggedin_activities - Delete 
        RepLoggedinActivities::model()->deleteAll("rep_credential_id ='" . $rep['rep_credential_id'] . "'");

        //rep_notes - Delete
        RepNotes::model()->deleteAll("rep_credential_id ='" . $rep['rep_credential_id'] . "'");

        //rep_view_counts - Delete
        RepViewCounts::model()->deleteAll("rep_credential_id ='" . $rep['rep_credential_id'] . "'");

        Yii::app()->user->setFlash('success', Myclass::t("OR594", "", "or"));
        $this->redirect(array('index'));
    }

    /* ----------------------- Buy More Accounts Section ---------------------------------------------- */

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

    public function actionBuyMoreAccounts() {
        $can_buy = RepAdminSubscriptions::model()->canBuyMoreAccounts();
        if (!$can_buy) {
            Yii::app()->user->setFlash('danger', Myclass::t("OR595", "", "or"));
            $this->redirect(array('index'));
        }

        $model = new RepCredentials;
        if (isset($_POST['btnSubmit'])) {
            $rep_admin_old_active_accounts = $model->getRepAdminActiveAccountsCount();
            $no_of_accounts_purchase = $_POST['RepCredentials']['no_of_accounts_purchase'];

            $new_subscription = array();
            $new_subscription['rep_credential_id'] = Yii::app()->user->id;
            $new_subscription['rep_admin_old_active_accounts'] = $rep_admin_old_active_accounts;
            $new_subscription['no_of_accounts_purchase'] = $no_of_accounts_purchase;
            $new_subscription['total_no_of_accounts'] = $rep_admin_old_active_accounts + $no_of_accounts_purchase;
            $new_subscription['price_list'] = Myclass::repAdminBuyMoreAccountsPriceCalculation($new_subscription['total_no_of_accounts'], $no_of_accounts_purchase);

            $price_list = $new_subscription['price_list'];

            $repTemp = new RepTemp;
            $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
            $repTemp->rep_temp_key = RepTemp::REP_ADMIN_BUY_MORE_ACCOUNTS;
            $repTemp->rep_temp_value = serialize($new_subscription);
            if ($repTemp->save()) {
                $paypalManager = new Paypal;
                $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalReturn'));
                $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalCancel'));
                $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalNotify'));

                $paypalManager->addField('item_name', RepTemp::REP_ADMIN_BUY_MORE_ACCOUNTS);
                $paypalManager->addField('amount', $price_list['total_price']);
//                $paypalManager->addField('quantity', $new_subscription['no_of_accounts_purchase']);
                $paypalManager->addField('tax', $price_list['tax']);
                $paypalManager->addField('custom', $repTemp->rep_temp_random_id);
                $paypalManager->addField('return', $returnUrl);
                $paypalManager->addField('cancel_return', $cancelUrl);
                $paypalManager->addField('notify_url', $notifyUrl);

                //$paypalManager->dumpFields();   // for printing paypal form fields
                $paypalManager->submitPaypalPost();
            }
        }

        $this->render('buyMoreAccounts', array(
            'model' => $model
        ));
    }

    public function actionPaypalCancel() {
        Yii::app()->user->setFlash('danger', Myclass::t("OR596", "", "or"));
        $this->redirect(array('buyMoreAccounts'));
    }

    public function actionPaypalReturn() {
        $pstatus = $_POST["payment_status"];
        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', Myclass::t("OR597", "", "or"));
            } else {
                Yii::app()->user->setFlash('success', Myclass::t("OR598", "", "or"));
            }
        } else {
            Yii::app()->user->setFlash('danger', Myclass::t("OR599", "", "or"));
        }
        $this->redirect(array('buyMoreAccounts'));
    }

    public function actionPaypalNotify() {
        $paypalManager = new Paypal;
        if ($paypalManager->notify()) {
            $this->processPaymentTransaction($_POST['custom']);
            if ($_POST['payment_status'] == "Completed") {
                $this->processBuyMoreAccounts($_POST['custom']);
            }
        }
    }

    protected function processPaymentTransaction($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $checkTransactionExists = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (empty($checkTransactionExists)) {
                $subscription_details = unserialize($result['rep_temp_value']);
                $price_list = $subscription_details['price_list'];

                $ptmodel = new PaymentTransaction;
                $ptmodel->user_id = $subscription_details['rep_credential_id'];
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
                $rep_account = RepCredentials::model()->findByPk($subscription_details['rep_credential_id']);
                $rep_profile = $rep_account->repCredentialProfiles;
                $rep_email = $rep_profile['rep_profile_email'];
                if (!empty($rep_email)) {
                    $rep_username = $rep_account['rep_username'];
                    $mail = new Sendmail;
                    $trans_array = array(
                        "{USERNAME}" => $rep_username,
                    );
                    $message = $mail->getMessage('rep_admin_buymoreaccounts_pending_status', $trans_array);
                    $Subject = $mail->translate('Buy More Rep Accounts - Payment Status Pending');
                    $mail->send($rep_email, $Subject, $message);
                }
            }
        }
    }

    /* ----------------------- Renewal Rep Accounts Section ---------------------------------------------- */

    public function actionRenewalRepAccounts() {
        if (!isset(Yii::app()->session['renewal'])) {
            $this->redirect('index');
        }

        if (isset($_POST['btnSubmit'])) {
            $data = Yii::app()->session['renewal'];
            $repTemp = new RepTemp;
            $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
            $repTemp->rep_temp_key = RepTemp::REP_ADMIN_RENEWAL_REP_ACCOUNTS;
            $repTemp->rep_temp_value = serialize($data);
            if ($repTemp->save()) {
                unset(Yii::app()->session['renewal']);
                $paypalManager = new Paypal;
                $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalRenewalReturn'));
                $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalRenewalCancel'));
                $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalRenewalNotify'));

                $paypalManager->addField('item_name', RepTemp::REP_ADMIN_RENEWAL_REP_ACCOUNTS);
                $paypalManager->addField('amount', $data['price_list']['total_price']);
//                $paypalManager->addField('quantity', $data['no_of_accounts_purchase']);
                $paypalManager->addField('tax', $data['price_list']['tax']);
                $paypalManager->addField('custom', $repTemp->rep_temp_random_id);
                $paypalManager->addField('return', $returnUrl);
                $paypalManager->addField('cancel_return', $cancelUrl);
                $paypalManager->addField('notify_url', $notifyUrl);

                //$paypalManager->dumpFields();   // for printing paypal form fields
                $paypalManager->submitPaypalPost();
            }
        }
        $this->render('renewalRepAccounts');
    }

    public function actionPaypalRenewalCancel() {
        Yii::app()->user->setFlash('danger', Myclass::t("OR600", "", "or"));
        $this->redirect(array('index'));
    }

    public function actionPaypalRenewalReturn() {
        $pstatus = $_POST["payment_status"];
        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
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
                $this->processRenewalRepAccounts($_POST['custom']);
            }
        }
    }

    protected function processRenewalPaymentTransaction($rep_temp_random_id) {
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
                    $trans_array = array(
                        "{USERNAME}" => $rep_username,
                    );
                    $message = $mail->getMessage('rep_admin_renewal_pending_status', $trans_array);
                    $Subject = $mail->translate('Rep Accounts Renewal - Payment Status Pending');
                    $mail->send($rep_email, $Subject, $message);
                }
            }
        }
    }

    /* ---------------------------- Rep Admin Subscriptions and Transactions ------------------ */

    public function actionSubscriptions() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("rep_credential_id = '" . Yii::app()->user->id . "'");
        $criteria->order = 'created_at DESC';

        $model = new CActiveDataProvider('RepAdminSubscriptions', array(
            'criteria' => $criteria,
        ));

        $this->render('subscriptions', array(
            'model' => $model,
        ));
    }

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

}
