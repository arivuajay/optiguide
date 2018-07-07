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
        $client_disp = isset($_POST['client_disp']) ? $_POST['client_disp'] : '';
        $other_disp = isset($_POST['other_disp']) ? $_POST['other_disp'] : '';
        
        $search_disp = isset($_POST['search']) ? $_POST['search'] : '';
        if($search_disp=="yes")
        {    
            $options = "<option value=''>" . Myclass::t('OG203') . "</option>";
        }else{
            $options = "<option value=''>" . Myclass::t('APP44') . "</option>";
        }
        
        if ($cid != '') {

            if(!empty($client_disp))
            {
                $data_regions = Myclass::getallregions_client($cid,$client_disp,$other_disp);
            }else {
                $data_regions = Myclass::getallregions($cid);
            }
            
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
        $client_disp = isset($_POST['client_dis']) ? $_POST['client_dis'] : '';
        $search_disp = isset($_POST['search']) ? $_POST['search'] : '';
        
        if($search_disp=="yes")
        {    
            $options = "<option value=''>" . Myclass::t('OG204') . "</option>";
        }else{
            $options = "<option value=''>" . Myclass::t('APP59') . "</option>";
        }
        
        if ($cid != '') {
            if($client_disp != '')
            {   
                $data_cities = Myclass::getallcities_other($cid);
            }  else {
                $data_cities = Myclass::getallcities($cid);
            }
            foreach ($data_cities as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }
    
    public function actionGetfichers()
    {
        $options = '';
        //fetch category id based fichers
        $cid     = isset($_POST['id'])?$_POST['id']:'';
        $options = "<option value=''>Aucune</option>";
        if($cid!='')
        {     
            $exts = array('jpg','png','gif','jpeg');
            $criteria = new CDbCriteria;
            $criteria->condition = 'ID_CATEGORIE=:id and DISPONIBLE=1';
            $criteria->params    = array(':id' => $cid); 
            $criteria->addInCondition('EXTENSION',$exts);
            $criteria->order = 'TITRE_FICHIER_FR';
            $data_fichers        = CHtml::listData(ArchiveFichier::model()->findAll($criteria), 'ID_FICHIER', 'TITRE_FICHIER_FR');  
             $options = "<option value=''>Aucune</option>";  
            foreach($data_fichers as $k => $info)
            {
                $options .= "<option value='".$k."'>".$info."</option>";  
            }    
        }        
        echo  $options;
        exit;
    }    
    
    public function actionGetficherimage()
    {
        $themeurl = $this->themeUrl;        
        $options = '';      
        $cid     = isset($_POST['id'])?$_POST['id']:'';
        $fileurl = "javascript:void(0);";
        if($cid!='')
        { 
           $fichres = ArchiveFichier::model()->find("ID_FICHIER=$cid"); 
           $categoryid  = $fichres->ID_CATEGORIE;     
           $ficherfile  = $fichres->FICHIER; 
          // $fileurl     =  $themeurl.'/img/archivage/'.$categoryid.'/'.$ficherfile;
           $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/".$categoryid."/".$ficherfile);   
           if (!file_exists(YiiBase::getPathOfAlias('webroot').'/uploads/archivage/'.$categoryid.'/'.$ficherfile))
           {
               $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/noimage.png");
           }    
        }        
        echo $fileurl;
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
            if (!empty($rep_username_exists)) {
                $rep_username = $rep_username . "_" . time();
            }

            //Save Rep Credentials
            $model = new RepCredentials;
            $model->rep_username = $rep_username;
            $model->rep_password = $registration['step2']['RepCredentials']['rep_password'];
            $no_of_months = $registration['step2']['RepCredentials']['no_of_months'];
            if ($registration['step2']['RepCredentials']['no_of_accounts_purchase'] > 1) {
                $model->rep_role = RepCredentials::ROLE_ADMIN;
            } else {
                $model->rep_role = RepCredentials::ROLE_SINGLE;
                $model->rep_expiry_date = date('Y-m-d', strtotime('+' . $no_of_months . ' month'));
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
                    $repSingle->rep_single_no_of_months = $no_of_months;
                    $repSingle->rep_single_total_month_price = $registration['step3']['total_month_price'];
                    $repSingle->offer_in_percentage = $registration['step3']['offer_in_percentage'];
                    $repSingle->offer_price = $registration['step3']['offer_price'];
                    $repSingle->rep_single_total = $registration['step3']['total_price'];
                    $repSingle->rep_single_tax = $registration['step3']['tax'];
                    $repSingle->rep_single_grand_total = $registration['step3']['grand_total'];
                    $repSingle->rep_single_subscription_start = date('Y-m-d');
                    $repSingle->rep_single_subscription_end = $model->rep_expiry_date;
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

                    $repAdmin->rep_admin_no_of_months = $no_of_months;
                    $repAdmin->rep_admin_total_month_price = $registration['step3']['total_month_price'];
                    $repAdmin->offer_in_percentage = $registration['step3']['offer_in_percentage'];
                    $repAdmin->offer_price = $registration['step3']['offer_price'];

                    $repAdmin->rep_admin_total_price = $registration['step3']['total_price'];
                    $repAdmin->rep_admin_tax = $registration['step3']['tax'];
                    $repAdmin->rep_admin_grand_total = $registration['step3']['grand_total'];
                    $repAdmin->rep_admin_subscription_start = date('Y-m-d');
                    $repAdmin->rep_admin_subscription_end = date('Y-m-d', strtotime('+' . $no_of_months . ' month'));
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
                    
                    $lang = isset(Yii::app()->session['language'])?Yii::app()->session['language']:"FR";
                    if ($repProfile->rep_profile_email) {
                        $mail = new Sendmail;
                        $trans_array = array(
                            "{USERNAME}" => $model->rep_username,
                            "{PASSWORD}" => $model->rep_password,
                            "{NEXTSTEPURL}" => REPURL,
                            "{SITENAME}" => OPTIREPSITENAME
                        );

                        $message = $mail->getMessage('rep_registration_completed_status', $trans_array);
//                        $Subject = $mail->translate('Registration Details');
                        if ($lang == 'EN') {
                            $subject = SITENAME . " - Registration Details";
                        } elseif ($lang == 'FR') {
                            $subject = " Détails d'inscription " . SITENAME;
                        }
                        $mail->send($repProfile->rep_profile_email, $subject, $message);
                    }
                    

                    //admin mail
                    $mail = new Sendmail();
                    $professional_url = ADMIN_URL . 'admin/repCredential/update/id/' . $model->rep_credential_id;
                    $enc_url = Myclass::refencryption($professional_url);
                    $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                    if ($lang == 'EN') {
                        $subject = SITENAME . " - New Opti-rep subscription notification -".$model->rep_username;
                    } elseif ($lang == 'FR') {
                        $subject = SITENAME . " New Opti -rep notification d'abonnement -".$model->rep_username;
                    }
                    $trans_array = array(
                        "{NAME}" => $model->rep_username,
                        "{UTYPE}" => $model->rep_role,
                        "{NEXTSTEPURL}" => $nextstep_url,
                        "{SITENAME}" => OPTIREPSITENAME,
                        "{STATUS}" => 'completed',
                    );
                    $message = $mail->getMessage('rep_registration_admin', $trans_array);
                    $mail->send(ADMIN_EMAIL, $subject, $message,'','','','',"payment");
                    
                    
                }
                RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
            }
        }
    }

    //Single Renewal His account - Opti Rep
    protected function processRenewalSingleRepAccount($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $renewal_details = unserialize($result['rep_temp_value']);
            $price_list = $renewal_details['price_list'];
            $month = '+'.$price_list['no_of_months'].' month';
            $rep_account = RepCredentials::model()->findByPk($renewal_details['rep_credential_id']);
            if ($rep_account['rep_expiry_date'] > date("Y-m-d")) {
                $subscription_start = $rep_account['rep_expiry_date'];
                $time = strtotime($rep_account['rep_expiry_date']);
//                $subscription_end = date("Y-m-d", strtotime("+1 month", $time));
                $subscription_end = date("Y-m-d", strtotime($month, $time));
                $rep_account->rep_expiry_date = $subscription_end;
            } else {
                $subscription_start = date('Y-m-d');
//                $subscription_end = date('Y-m-d', strtotime('+1 month'));
                $subscription_end = date('Y-m-d', strtotime($month));
                $rep_account->rep_expiry_date = $subscription_end;
            }
            $rep_account->save(false);

            $repSingleSubscription = new RepSingleSubscriptions;
            $repSingleSubscription->rep_credential_id = $renewal_details['rep_credential_id'];
            $repSingleSubscription->rep_subscription_type_id = $price_list['subscription_type_id'];
            $repSingleSubscription->purchase_type = RepSingleSubscriptions::PURCHASE_TYPE_RENEWAL;
            $repSingleSubscription->rep_single_price = $price_list['per_account_price'];
            $repSingleSubscription->rep_single_no_of_months = $price_list['no_of_months'];
            $repSingleSubscription->rep_single_total_month_price = $price_list['total_month_price'];
            $repSingleSubscription->offer_in_percentage = $price_list['offer_in_percentage'];
            $repSingleSubscription->offer_price = $price_list['offer_price'];
            $repSingleSubscription->rep_single_total = $price_list['total_price'];
            $repSingleSubscription->rep_single_tax = $price_list['tax'];
            $repSingleSubscription->rep_single_grand_total = $price_list['grand_total'];
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

                $rep_profile = $rep_account->repCredentialProfiles;
                $rep_email = $rep_profile['rep_profile_email'];
                if ($rep_email) {
                    $mail = new Sendmail;
                    $trans_array = array(
                        "{USERNAME}" => $rep_account['rep_username'],
                        "{SITENAME}" => OPTIREPSITENAME,
                        "{EXPIRYDATE}" => $rep_account->rep_expiry_date
                    );

                    $message = $mail->getMessage('rep_renewal_completed_status', $trans_array);
                    if (Yii::app()->session['language'] == 'EN') {
                        $subject = SITENAME . " - Renewal Details ";
                    } elseif (Yii::app()->session['language'] == 'FR') {
                        $subject = SITENAME . " - Détails Renouvellement ";
                    }
//                    $Subject = $mail->translate('Renewal Details');
                    $mail->send($rep_email, $subject, $message);
                }
                
                //admin mail
                    $mail = new Sendmail();
                    $professional_url = ADMIN_URL . 'admin/repCredential/update/id/' . $rep_account->rep_credential_id;
                    $enc_url = Myclass::refencryption($professional_url);
                    $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                    if (Yii::app()->session['language'] == 'EN') {
                        $subject = SITENAME . " - Renewal single repaccount details -".$rep_account['rep_username'];
                    } elseif (Yii::app()->session['language'] == 'FR') {
                        $subject = SITENAME . " - Renouvellement détails unique de repaccount -". $rep_account['rep_username'];
                    }
                    $trans_array = array(
                        "{NAME}" => $rep_account->rep_username,
                        "{UTYPE}" => $rep_account->rep_role,
                        "{NEXTSTEPURL}" => $nextstep_url,
                        "{SITENAME}" => OPTIREPSITENAME,
                        
                    );
                    $message = $mail->getMessage('rep_renewal_admin', $trans_array);
                    $mail->send(ADMIN_EMAIL, $subject, $message,'','','','',"payment");
            }
            RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
        }
    }

    //Admin Buy More Sales Rep Accounts - Opti Rep
    protected function processBuyMoreAccounts($rep_temp_random_id) {
        $temp_random_id = $rep_temp_random_id;
        $result = RepTemp::model()->find("rep_temp_random_id='$temp_random_id'");
        if (!empty($result)) {
            $subscription_details = unserialize($result['rep_temp_value']);
            $price_list = $subscription_details['price_list'];
            $rep_credential = RepCredentials::model()->findByPk($subscription_details['rep_credential_id']);
                        
            $subscription = new RepAdminSubscriptions;
            $subscription->rep_credential_id = $subscription_details['rep_credential_id'];
            $subscription->rep_subscription_type_id = $price_list['subscription_type_id'];
            $subscription->purchase_type = RepAdminSubscriptions::PURCHASE_TYPE_NEW;
            $subscription->no_of_accounts_purchased = $subscription_details['no_of_accounts_purchase'];
            $subscription->rep_admin_old_active_accounts = $subscription_details['rep_admin_old_active_accounts'];
            $subscription->no_of_accounts_remaining = $subscription_details['no_of_accounts_purchase'];
            $subscription->rep_admin_per_account_price = $price_list['per_account_price'];

            $subscription->rep_admin_no_of_months = $price_list['no_of_months'];
            $subscription->rep_admin_total_month_price = $price_list['total_month_price'];

            $subscription->rep_admin_total_price = $price_list['total_price'];
            $subscription->rep_admin_tax = $price_list['tax'];
            $subscription->rep_admin_grand_total = $price_list['grand_total'];
            $subscription->rep_admin_subscription_start = date('Y-m-d');
            if($rep_credential->rep_role == 'single'){
                $subscription->rep_admin_subscription_end = date('Y-m-d', strtotime('+' . $price_list['no_of_months'] . ' month'));
            }else{
                $subscription->rep_admin_subscription_end = date('Y-m-d', strtotime('+1 month'));
            }
            
            $subscription->save(false);
            
            if($rep_credential->rep_role == 'single'){
                $rep_credential->rep_role = 'admin';
                $rep_credential->rep_expiry_date ='0000-00-00 00:00:00';
                $rep_credential->save();
                Yii::app()->user->setState('rep_role', 'admin');
                
                //Current Plan - New Subscriber Insert
                $repAdminSubscriber = new RepAdminSubscribers();
                $repAdminSubscriber->rep_admin_subscription_id = $subscription->rep_admin_subscription_id;
                $repAdminSubscriber->rep_credential_id = $rep_credential->rep_credential_id;
                $repAdminSubscriber->save(false);
            }

            //Update Payment Transaction details
            $updateTransactionDetail = PaymentTransaction::model()->find("rep_temp_id = '" . $result['rep_temp_id'] . "'");
            if (!empty($updateTransactionDetail)) {
                $updateTransactionDetail->user_id = $subscription->rep_credential_id;
                $updateTransactionDetail->rep_temp_id = 0;
                $updateTransactionDetail->payment_status = 'Completed';
                $updateTransactionDetail->rep_admin_subscription_id = $subscription->rep_admin_subscription_id;
                $updateTransactionDetail->save(false);

                $rep_account = RepCredentials::model()->findByPk($subscription_details['rep_credential_id']);
                $rep_profile = $rep_account->repCredentialProfiles;
                $rep_email = $rep_profile['rep_profile_email'];
                if ($rep_email) {
                    $mail = new Sendmail;
                    $trans_array = array(
                        "{USERNAME}" => $rep_account['rep_username'],
                        "{SITENAME}" => OPTIREPSITENAME,
                    );

                    $message = $mail->getMessage('rep_admin_buymoreaccounts_completed_status', $trans_array);
                    if (Yii::app()->session['language'] == 'EN') {
                        $subject = SITENAME . " - Buy More Rep Accounts - Payment Status Completed";
                    } elseif (Yii::app()->session['language'] == 'FR') {
                        $subject = SITENAME . "- Acheter des comptes Rep - Paiement Statut Terminé ";
                    }
//                    $Subject = $mail->translate('Buy More Rep Accounts - Payment Status Completed');
                    $mail->send($rep_email, $subject, $message);
                }
                
                $mail = new Sendmail();
                    $professional_url = ADMIN_URL . 'admin/repCredential/update/id/' . $rep_account->rep_credential_id;
                    $enc_url = Myclass::refencryption($professional_url);
                    $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                    if (Yii::app()->session['language'] == 'EN') {
                        $subject = SITENAME . " - Buy More Rep Accounts -".$rep_account['rep_username'];
                    } elseif (Yii::app()->session['language'] == 'FR') {
                        $subject = SITENAME . " - Acheter des comptes Rep -".$rep_account['rep_username'];
                    }
                    $trans_array = array(
                        "{NAME}" => $rep_account->rep_username,
                        "{UTYPE}" => $rep_account->rep_role,
                        "{NEXTSTEPURL}" => $nextstep_url,
                        "{SITENAME}" => OPTIREPSITENAME,
                        
                    );
                    $message = $mail->getMessage('rep_admin_buymoreaccounts_admin', $trans_array);
                    $mail->send(ADMIN_EMAIL, $subject, $message,'','','','',"payment");
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

            $repAdminSubscription->rep_admin_no_of_months = $price_list['no_of_months'];
            $repAdminSubscription->rep_admin_total_month_price = $price_list['total_month_price'];

            $repAdminSubscription->rep_admin_total_price = $price_list['total_price'];
            $repAdminSubscription->rep_admin_tax = $price_list['tax'];
            $repAdminSubscription->rep_admin_grand_total = $price_list['grand_total'];
            $repAdminSubscription->save(false);
            
            $month = '+'.$renewal_details['no_of_months'].' month';
            foreach ($rep_credentials as $rep_credential) {
                $rep_account = RepCredentials::model()->findByPk($rep_credential);
                if ($rep_account['rep_expiry_date'] > date("Y-m-d")) {
                    $time = strtotime($rep_account['rep_expiry_date']);
//                    $final = date("Y-m-d", strtotime("+1 month", $time));
                    $final = date("Y-m-d", strtotime($month, $time));
                    $rep_account->rep_expiry_date = $final;
                } else {
                    $rep_account->rep_expiry_date = date('Y-m-d', strtotime($month));
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

                $rep_admin_account = RepCredentials::model()->findByPk($renewal_details['rep_credential_id']);
                $rep_admin_profile = $rep_admin_account->repCredentialProfiles;
                $rep_admin_email = $rep_admin_profile['rep_profile_email'];
                if ($rep_admin_email) {
                    $mail = new Sendmail;
                    $trans_array = array(
                        "{USERNAME}" => $rep_admin_account['rep_username'],
                        "{SITENAME}" => OPTIREPSITENAME,
                    );

                    $message = $mail->getMessage('rep_admin_renewal_completed_status', $trans_array);
//                    $Subject = $mail->translate('Rep Accounts Renewal - Payment Status Completed');
                    if (Yii::app()->session['language'] == 'EN') {
                        $subject = SITENAME . " - Rep Accounts Renewal ";
                    } elseif (Yii::app()->session['language'] == 'FR') {
                        $subject = SITENAME . " Rep Accounts Renewal " ;
                    }
                    $mail->send($rep_admin_email, $subject, $message);
                }
                $mail = new Sendmail();
                    $professional_url = ADMIN_URL . 'admin/repCredential/update/id/' . $rep_admin_account->rep_credential_id;
                    $enc_url = Myclass::refencryption($professional_url);
                    $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                    if (Yii::app()->session['language'] == 'EN') {
                        $subject = SITENAME . " - Rep Accounts Renewal -".$rep_admin_account->rep_username;
                    } elseif (Yii::app()->session['language'] == 'FR') {
                        $subject = SITENAME . " Rep Accounts Renewal -".$rep_admin_account->rep_username ;
                    }
                    $trans_array = array(
                        "{NAME}" => $rep_admin_account->rep_username,
                        "{UTYPE}" => $rep_admin_account->rep_role,
                        "{NEXTSTEPURL}" => $nextstep_url,
                        "{SITENAME}" => OPTIREPSITENAME,
                        
                    );
                    $message = $mail->getMessage('rep_renewal_admin', $trans_array);
                    $mail->send(ADMIN_EMAIL, $subject, $message,'','','','',"payment");
            }
            RepTemp::model()->deleteAll("rep_temp_random_id = '" . $temp_random_id . "'");
        }
    }

}
