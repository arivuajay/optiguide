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
                'actions' => array('paypalRenewalCancel', 'paypalRenewalReturn', 'paypalRenewalNotify'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'transactions'),
                'users' => array('@'),
                'expression' => array('RepSingleSubscriptionsController','allowOnlyRepSingleWithNoParent')
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

        $no_of_accounts_purchase = 1;
        $price_calculation = Myclass::priceCalculation($no_of_accounts_purchase);

        if (isset($_POST['btnSubmit'])) {
            $data = array();
            $data['price_list'] = $price_calculation;
            $data['rep_credential_id'] = Yii::app()->user->id;
            $data['purchase_type'] = RepSingleSubscriptions::PURCHASE_TYPE_RENEWAL;

            $repTemp = new RepTemp;
            $repTemp->rep_temp_random_id = Myclass::getRandomString(8);
            $repTemp->rep_temp_key = RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT;
            $repTemp->rep_temp_value = serialize($data);

            if ($repTemp->save()) {
                $paypalManager = new Paypal;
                $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalReturn'));
                $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalCancel'));
                $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repSingleSubscriptions/paypalRenewalNotify'));

                $paypalManager->addField('item_name', RepTemp::REP_SINGLE_RENEWAL_REP_ACCOUNT);
                $paypalManager->addField('amount', $data['price_list']['per_account_price']);
                $paypalManager->addField('quantity', $no_of_accounts_purchase);
                $paypalManager->addField('tax', $data['price_list']['tax']);
                $paypalManager->addField('custom', $repTemp->rep_temp_random_id);
                $paypalManager->addField('return', $returnUrl);
                $paypalManager->addField('cancel_return', $cancelUrl);
                $paypalManager->addField('notify_url', $notifyUrl);

                $paypalManager->submitPaypalPost();
            }
        }

        $this->render('index', array(
            'model' => $model,
            'price_calculation' => $price_calculation,
        ));
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
                $this->processRenewalSingleRepAccount($_POST['custom']);
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
        }
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
