<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $flashMessages = array();
    public $themeUrl = '';
    public $title = '';

    public function init() {
        parent::init();

        CHtml::$errorSummaryCss = 'alert alert-danger';

        $this->flashMessages = Yii::app()->user->getFlashes();
        $this->themeUrl = Yii::app()->theme->baseUrl;
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('getregions', 'getcities'),
                'users' => array('*'),
            ),
        );
    }

    public function actionGetRegions() {
        $options = '';
        $cid = isset($_POST['id']) ? $_POST['id'] : '';
        $options = "<option value=''>" . Myclass::t('APP44') . "</option>";
        if ($cid != '') {
            $data_regions = Myclass::getallregions($cid);
            foreach ($data_regions as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    public function actionGetCities() {
        $options = '';
        $cid = isset($_POST['id']) ? $_POST['id'] : '';
        $options = "<option value=''>" . Myclass::t('APP59') . "</option>";
        if ($cid != '') {
            $data_cities = Myclass::getallcities($cid);
            foreach ($data_cities as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    //Registration for Single/Admin - Opti Rep
    protected function processRegistration($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $registration = unserialize($result['rep_temp_value']);
            
            $rep_username = $registration['step2']['RepCredentials']['rep_username'];
            $rep_username_exists = RepCredentials::model()->find('rep_username=:UN', array(
                ':UN' => $rep_username,
            ));
            if(!empty($rep_username_exists)){
                $rep_username = $rep_username . "_" . time();
            }

            //Save Rep Credentials
            $model = new RepCredentials;
            $model->rep_username = $rep_username;
            $model->rep_password = $registration['step2']['RepCredentials']['rep_password'];
            if ($registration['step2']['RepCredentials']['no_of_accounts_purchase'] > 1) {
                $model->rep_role = RepCredentials::ROLE_ADMIN;
            } else {
                $model->rep_role = RepCredentials::ROLE_SINGLE;
                $model->rep_expiry_date = date('Y-m-d', strtotime('+1 month'));
            }

            if ($model->save(false)) {
                //Save Rep Profile
                $repProfile = new RepCredentialProfiles;
                $repProfile->attributes = $registration['step2']['RepCredentialProfiles'];
                $repProfile->rep_credential_id = $model->rep_credential_id;
                $repProfile->save(false);

                if ($model->rep_role == RepCredentials::ROLE_SINGLE) {
                    //Save Rep Single Subscription Details
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
                    //Save Rep Admin Subscription Details
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

                //Update Payment Transaction details
                $updateTransactionDetail = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
                if (!empty($updateTransactionDetail)) {
                    $updateTransactionDetail->user_id = $model->rep_credential_id;
                    $updateTransactionDetail->rep_temp_id = 0;
                    $updateTransactionDetail->payment_status = 'Completed';
                    if ($model->rep_role == RepCredentials::ROLE_SINGLE)
                        $updateTransactionDetail->rep_single_subscription_id = $repSingle->rep_single_subscription_id;
                    elseif ($model->rep_role == RepCredentials::ROLE_ADMIN)
                        $updateTransactionDetail->rep_admin_subscription_id = $repAdmin->rep_admin_subscription_id;
                    $updateTransactionDetail->save(false);
                }
                RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
            }
        }
    }

    //Admin Buy More Sales Rep Accounts - Opti Rep
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

            //Update Payment Transaction details
            $updateTransactionDetail = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (!empty($updateTransactionDetail)) {
                $updateTransactionDetail->user_id = $subscription->rep_credential_id;
                $updateTransactionDetail->rep_temp_id = 0;
                $updateTransactionDetail->payment_status = 'Completed';
                $updateTransactionDetail->rep_admin_subscription_id = $subscription->rep_admin_subscription_id;
                $updateTransactionDetail->save(false);
            }
            RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
        }
    }

    //Admin Renewal Sales Rep Accounts - Opti Rep
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

            //Update Payment Transaction details
            $updateTransactionDetail = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (!empty($updateTransactionDetail)) {
                $updateTransactionDetail->user_id = $repAdminSubscription->rep_credential_id;
                $updateTransactionDetail->rep_temp_id = 0;
                $updateTransactionDetail->payment_status = 'Completed';
                $updateTransactionDetail->rep_admin_subscription_id = $repAdminSubscription->rep_admin_subscription_id;
                $updateTransactionDetail->save(false);
            }
            RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
        }
    }

    //Single Renewal His account - Opti Rep
    protected function processRenewalSingleRepAccount($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $renewal_details = unserialize($result['rep_temp_value']);
            $price_list = $renewal_details['price_list'];

            $rep_account = RepCredentials::model()->findByPk($renewal_details['rep_credential_id']);
            if ($rep_account['rep_expiry_date'] > date("Y-m-d")) {
                $subscription_start = $rep_account['rep_expiry_date'];
                $time = strtotime($rep_account['rep_expiry_date']);
                $subscription_end = date("Y-m-d", strtotime("+1 month", $time));
                $rep_account->rep_expiry_date = $subscription_end;
            } else {
                $subscription_start = date('Y-m-d');
                $subscription_end = date('Y-m-d', strtotime('+1 month'));
                $rep_account->rep_expiry_date = $subscription_end;
            }
            $rep_account->save(false);

            $repSingleSubscription = new RepSingleSubscriptions;
            $repSingleSubscription->rep_credential_id = $renewal_details['rep_credential_id'];
            $repSingleSubscription->rep_subscription_type_id = $price_list['subscription_type_id'];
            $repSingleSubscription->purchase_type = RepSingleSubscriptions::PURCHASE_TYPE_RENEWAL;
            $repSingleSubscription->rep_single_price = $price_list['total_price'];
            $repSingleSubscription->rep_single_tax = $price_list['tax'];
            $repSingleSubscription->rep_single_total = $price_list['grand_total'];
            $repSingleSubscription->rep_single_subscription_start = $subscription_start;
            $repSingleSubscription->rep_single_subscription_end = $subscription_end;
            $repSingleSubscription->save(false);

            //Update Payment Transaction details
            $updateTransactionDetail = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (!empty($updateTransactionDetail)) {
                $updateTransactionDetail->rep_temp_id = 0;
                $updateTransactionDetail->payment_status = 'Completed';
                $updateTransactionDetail->rep_single_subscription_id = $repSingleSubscription->rep_single_subscription_id;
                $updateTransactionDetail->save(false);
            }
            RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
        }
    }

}
