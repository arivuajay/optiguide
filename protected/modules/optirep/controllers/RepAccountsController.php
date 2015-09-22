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
                'actions' => array('index', 'create', 'edit', 'buyMoreAccounts', 'buyMoreAccountsPriceList', 'paypalCancel', 'paypalReturn', 'paypalNotify', 'renewalRepAccounts', 'paypalRenewalReturn', 'paypalRenewalCancel', 'paypalRenewalNotify'),
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
                $renewal['price_list'] = Myclass::priceCalculation($renewal['no_of_accounts_purchase']);
                Yii::app()->session['renewal'] = $renewal;
                $this->redirect('renewalRepAccounts');
            } else {
                Yii::app()->user->setFlash('danger', "Kindly select the rep accounts for Renewal");
            }
        }
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
            Yii::app()->user->setFlash('danger', "Sorry, you can not buy more accounts");
            $this->redirect(array('index'));
        }

        $model = new RepCredentials;
        if (isset($_POST['btnSubmit'])) {
            $new_subscription = array();
            $new_subscription['rep_credential_id'] = Yii::app()->user->id;
            $new_subscription['rep_admin_old_active_accounts'] = $model->getRepAdminActiveAccountsCount();
            $new_subscription['no_of_accounts_purchase'] = $_POST['RepCredentials']['no_of_accounts_purchase'];
            $new_subscription['total_no_of_accounts'] = $rep_admin_old_active_accounts + $no_of_accounts_purchase;
            $new_subscription['price_list'] = Myclass::repAdminBuyMoreAccountsPriceCalculation($new_subscription['total_no_of_accounts'], $new_subscription['no_of_accounts_purchase']);

            $price_list = $new_subscription['price_list'];

            $repTemp = new RepTemp;
            $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
            $repTemp->rep_temp_key = 'Buy More Accounts';
            $repTemp->rep_temp_value = serialize($new_subscription);
            if ($repTemp->save()) {
                $paypalManager = new Paypal;
                $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalReturn'));
                $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalCancel'));
                $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalNotify'));

                $paypalManager->addField('item_name', 'Rep Admin- Buy More Accounts Subscription');
                $paypalManager->addField('amount', $price_list['per_account_price']);
                $paypalManager->addField('quantity', $new_subscription['no_of_accounts_purchase']);
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
        Yii::app()->user->setFlash('danger', 'Your subscription has been cancelled. Please try again.');
        $this->redirect(array('buyMoreAccounts'));
    }

    public function actionPaypalReturn() {
        $pstatus = $_POST["payment_status"];
        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', "Your payment status is pending. Admin will verify your payment details.");
            } else {
                Yii::app()->user->setFlash('success', "Thanks for your subscription! Now you can add more rep accounts");
            }
        } else {
            Yii::app()->user->setFlash('danger', "Your subscription payment is failed. Please try again later or contact admin.");
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
        }
    }

    protected function processBuyMoreAccounts($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $subscription_details = unserialize($result['rep_temp_value']);
            $price_list = $subscription_details['price_list'];

            $subscription = new RepAdminSubscriptions;
            $subscription->rep_credential_id = $subscription_details['rep_credential_id'];
            $subscription->rep_subscription_type_id = $price_list['subscription_type_id'];
            $subscription->purchase_type = RepAdminSubscriptions::PURCHASE_TYPE_NEW;
            $subscription->no_of_accounts_purchased = $subscription_details['no_of_accounts_purchase'];
            $subscription->rep_admin_old_active_accounts = $subscription_details['rep_admin_old_active_accounts'];
            $subscription->no_of_accounts_remaining = $subscription_details['no_of_accounts_purchase'];
            $subscription->rep_admin_per_account_price = $price_list['per_account_price'];
            $subscription->rep_admin_total_price = $price_list['total_price'];
            $subscription->rep_admin_tax = $price_list['tax'];
            $subscription->rep_admin_grand_total = $price_list['grand_total'];
            $subscription->rep_admin_subscription_start = date('Y-m-d');
            $subscription->rep_admin_subscription_end = date('Y-m-d', strtotime('+1 month'));
            $subscription->save(false);
            RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
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
            $repTemp->rep_temp_key = 'Rep Admin- Renewal Rep Accounts Subscription';
            $repTemp->rep_temp_value = serialize($data);
            if ($repTemp->save()) {
                unset(Yii::app()->session['renewal']);
                $paypalManager = new Paypal;
                $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalRenewalReturn'));
                $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalRenewalCancel'));
                $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repAccounts/paypalRenewalNotify'));

                $paypalManager->addField('item_name', 'Renewal Rep Accounts');
                $paypalManager->addField('amount', $data['price_list']['per_account_price']);
                $paypalManager->addField('quantity', $data['no_of_accounts_purchase']);
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
        Yii::app()->user->setFlash('danger', 'Your renewal has been cancelled. Please try again.');
        $this->redirect(array('index'));
    }

    public function actionPaypalRenewalReturn() {
        $pstatus = $_POST["payment_status"];
        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', "Your payment status is pending. Admin will verify your payment details.");
            } else {
                Yii::app()->user->setFlash('success', "Thanks for your renewal!");
            }
        } else {
            Yii::app()->user->setFlash('danger', "Your renewal payment is failed. Please try again later or contact admin.");
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
        }
    }

    protected function processRenewalRepAccounts($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $renewal_details = unserialize($result['rep_temp_value']);
            $price_list = $renewal_details['price_list'];
            $rep_credentials = $renewal_details['rep_credentials'];

            $repAdminSubscription = new RepAdminSubscriptions;
            $repAdminSubscription->rep_credential_id = $renewal_details['rep_credential_id'];
            $repAdminSubscription->rep_subscription_type_id = $price_list['subscription_type_id'];
            $repAdminSubscription->purchase_type = RepAdminSubscriptions::PURCHASE_TYPE_RENEWAL;
            $repAdminSubscription->no_of_accounts_purchased = $renewal_details['no_of_accounts_purchase'];
            $repAdminSubscription->no_of_accounts_used = $renewal_details['no_of_accounts_purchase'];
            $repAdminSubscription->rep_admin_per_account_price = $price_list['per_account_price'];
            $repAdminSubscription->rep_admin_total_price = $price_list['total_price'];
            $repAdminSubscription->rep_admin_tax = $price_list['tax'];
            $repAdminSubscription->rep_admin_grand_total = $price_list['grand_total'];
            $repAdminSubscription->save(false);

            foreach ($rep_credentials as $rep_credential) {
                $rep_account = RepCredentials::model()->findByPk($rep_credential);
                if ($rep_account['rep_expiry_date'] > date("Y-m-d")) {
                    $time = strtotime($rep_account['rep_expiry_date']);
                    $final = date("Y-m-d", strtotime("+1 month", $time));
                    $rep_account->rep_expiry_date = $final;
                } else {
                    $rep_account->rep_expiry_date = date('Y-m-d', strtotime('+1 month'));
                }
                $rep_account->save(false);

                $repAdminSubscriber = new RepAdminSubscribers();
                $repAdminSubscriber->rep_admin_subscription_id = $repAdminSubscription->rep_admin_subscription_id;
                $repAdminSubscriber->rep_credential_id = $rep_account->rep_credential_id;
                $repAdminSubscriber->save(false);
            }
            RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
        }
    }

}
