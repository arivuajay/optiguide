<?php

class RepCredentialController extends Controller {

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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view','update','create','payment','renewpayment','get_totalamount','transaction_view'),
                'users' => array('@'),
                 'expression'=> 'AdminIdentity::checkAccess()',
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

    
    public function actionIndex() {
        $model = new RepCredentials('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RepCredentials'])) {
            $model->attributes = $_GET['RepCredentials'];
            $model->search();
        }

        $this->render('index', compact('model'));
    }
    public function actionTransaction_view($id){
        $pmodel =  PaymentTransaction::model()->findByPk($id);
        $this->render('_view', array(
            'pmodel' => $pmodel,
        ));
        
    }
    public function actionView($id){
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
            'profile' => $model->repCredentialProfiles,
        ));
    }
    
    public function actionGet_totalamount() {
        $no_of_months = isset($_POST['no_of_months']) ? $_POST['no_of_months'] : '';
        $no_of_accounts_purchased = 1;
        $offer_calculation = false;
        $price_list = Myclass::priceCalculationWithMonths($no_of_months, $no_of_accounts_purchased, $offer_calculation);
        $total_amount=$price_list['total_price'].'  CAD';
        echo $total_amount;
        exit;
        
    }
    public function actionCreate() {
        
        $model  = new RepCredentials;
        $profile  = new RepCredentialProfiles;
        $pmodel = new PaymentCheques;
        $model->scenario = 'update';
        $profile->scenario = 'update';
        
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model,$profile));
        
        if(Yii::app()->user->hasState("secondtab"))
        {    
            //check if session exists
            if (Yii::app()->user->hasState("repattributes")  && Yii::app()->user->getState("profileattributes")) {
                //get session variable
                $sess_attr_rep = Yii::app()->user->getState("repattributes");
                
                
                $model->attributes = $sess_attr_rep;
                $sess_attr_pro = Yii::app()->user->getState("profileattributes");
                $profile->attributes = $sess_attr_pro;
             //   $sess_attr_u = Yii::app()->user->getState("uattributes");
              //  $umodel->attributes = $sess_attr_u;
            }
        } else {
              // unset Session repcredential model attribute    
            Yii::app()->user->setState("repattributes", null);
            Yii::app()->user->setState("profileattributes", null);
            // unset Session user model attribute
           
            // unset Session marqueids  
            Yii::app()->user->setState("secondtab", null);
            // unset Session scountry  
            Yii::app()->user->setState("scountry", null);
            // unset Session sregion  
            Yii::app()->user->setState("sregion", null);
        }   
        

        

        
        if (isset($_POST['yt0'])) {
            
            
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];


                //set session variable
                $scountry = $_POST['RepCredentialProfiles']['country'];
                $sregion  = $_POST['RepCredentialProfiles']['region'];
                Yii::app()->user->setState("scountry", $scountry);
                Yii::app()->user->setState("sregion", $sregion);
                
             
                $repattributes = $model->attributes;
                
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
                
                $profileattributes = $profile->attributes;
              //  $uattributes = $umodel->attributes;

                Yii::app()->user->setState("repattributes", $repattributes);

                Yii::app()->user->setState("profileattributes", $profileattributes);
                
                Yii::app()->user->setState("secondtab", "2");
                
               
                $this->redirect(array('payment'));
            
        }
        $tab = 1;
        $this->render('create', compact('model', 'tab','pmodel','profile'));
    }
     public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $profile = RepCredentialProfiles::model()->findByAttributes(array('rep_credential_id' => $id));
        $model->scenario = 'update';
//        $this->performAjaxValidation(array($model,$profile));
//        if (isset($_POST['client_sub'])) {
//            $model->attributes = $_POST['RepCredentials'];
//            $profile->attributes = $_POST['RepCredentialProfiles'];
//                $model->save(false);
//                $profile->save(false);
//                Yii::app()->user->setFlash('success', 'L\'accès de l\'utilisateur à jour avec succès!!!');
//                $this->redirect(array('update', "id" => $id));
//        }
//
//        $this->render('update', compact('model','profile'));
        
        
        $pmodel = new PaymentCheques;
       
        
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model,$profile));
        
        $repattributes = $model->attributes;
        $profileattributes = $profile->attributes;

        Yii::app()->user->setState("repattributes", $repattributes);

        Yii::app()->user->setState("profileattributes", $profileattributes);
     //   Yii::app()->user->setState("uattributes", $uattributes);

        // Set and intialize session from existing database records.         
         

        if ($_POST['yt0']) 
        {
             $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];
         //   $umodel->attributes = $_POST['UserDirectory'];
         //   $umodel->NOM_TABLE = $model::$NOM_TABLE;
         //   $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;

        //    $valid = $umodel->validate();
        //    $valid = $model->validate() && $valid;


                //set session variable
                $scountry = $_POST['RepCredentialProfiles']['country'];
                $sregion  = $_POST['RepCredentialProfiles']['region'];
                Yii::app()->user->setState("scountry", $scountry);
                Yii::app()->user->setState("sregion", $sregion);
                

                $repattributes = $model->attributes;
                
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
                
                $profileattributes = $profile->attributes;
                $model->modified_at = date('Y-m-d H:i:s', time());
                
                $model->save(); 
                $profile->save(); 
              //  $uattributes = $umodel->attributes;

                Yii::app()->user->setState("repattributes", $repattributes);

                Yii::app()->user->setState("profileattributes", $profileattributes);
                
                Yii::app()->user->setState("secondtab", "2");
                
               
                $this->redirect(array('payment'));
                
        }
        

        $tab = 1;
        $this->render('update', compact('model', 'tab','pmodel','profile'));
    }  
    public function actionPayment()
    {
        $tab    = 2;
        $pmodel = new PaymentCheques;
          
        if (Yii::app()->user->hasState("repattributes") && Yii::app()->user->hasState("profileattributes")){
            $sess_attr_rep = Yii::app()->user->getState("repattributes");
            $sess_attr_pro = Yii::app()->user->getState("profileattributes");
        }

        if (!empty($sess_attr_rep))
        {
            //Check for update form
            if (isset($sess_attr_rep['rep_credential_id'])) 
            {
                $fid = $sess_attr_rep['rep_credential_id'];
                $model = $this->loadModel($fid);
                $profile = RepCredentialProfiles::model()->findByAttributes(array('rep_credential_id' => $fid));
              //  $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");
                 $item_name = "SingleRenewalRepAccount";
            } else {
                $model = new RepCredentials;
                $profile = new RepCredentialProfiles;
                 $item_name = "Registration";
              //  $umodel = new UserDirectory();
            }
        } 
        

        //check if session exists
        if (Yii::app()->user->hasState("repattributes") && Yii::app()->user->hasState("profileattributes")) 
        {
            //get session variable
            $model->attributes = $sess_attr_rep;
            $profile->attributes = $sess_attr_pro;
        }    
        
                
        
         // Save products in to database        
        if (isset($_POST['PaymentCheques'])) 
        { 
            $pmodel->attributes = $_POST['PaymentCheques'];
            $pmodel->rep_expire_month    = $_POST['PaymentCheques']['rep_expire_month'];
            $pmodel->pay_type   = $_POST['PaymentCheques']['pay_type'];
            $no_of_months_db = $amount = $no_of_months = null;
            
            if($pmodel->pay_type==2)
            { 
              $pmodel->scenario = 'bycheque';
            }
           
            
            if($pmodel->validate())
            {
             
//                $sett_infos = SupplierSubscriptionPrice::model()->findByPk(1);
                $rep_subscription_type = RepSubscriptionTypes::model()->findByPk(1);
                if($_POST['PaymentCheques']['pay_type']=="2")
                {    
                    $paytype      = "Cheque";
                    $no_of_months = $pmodel->rep_expire_month;
                    $expirydate = date("Y-m-d", strtotime("+$no_of_months month", time()));
                    $payment_type = "3";   
                    $amount = $rep_subscription_type->rep_subscription_price;
                    $no_of_months_db=$no_of_months;
                
                }elseif($_POST['PaymentCheques']['pay_type']=="1")
                {
                    $paytype = "Free";  
                    $no_of_months = $pmodel->rep_expire_month;
                    $expirydate = date("Y-m-d", strtotime("+$no_of_months month", time()));
                    $payment_type = "4";
                    $no_of_months_db=$no_of_months;
                    $no_of_months="0";
                    $amount = 0;
                }  
                
               

                
                // Session supplier model attribute    
                $sess_attr_rep = Yii::app()->user->getState("repattributes");
                // Session user model attribute

                $no_of_accounts_purchased = 1;
                $offer_calculation = false;
                $price_list = Myclass::priceCalculationWithMonths($no_of_months, $no_of_accounts_purchased, $offer_calculation);
                
                if (Yii::app()->user->hasState("repattributes")) {
                   
                    $model->attributes = $sess_attr_rep; 
                    
                    $profile->attributes = $sess_attr_pro;
                 
                    $model->rep_expiry_date = $expirydate;
                    $model->created_at = date('Y-m-d H:i:s', time());
                    $model->modified_at = date('Y-m-d H:i:s', time());
                    $model->save(); 
                    $profile->rep_credential_id = $model->rep_credential_id;
                    $profile->save(); 
                    
                    
                    
                    $repSingle = new RepSingleSubscriptions;
                    $repSingle->rep_credential_id = $model->rep_credential_id;
                    $repSingle->rep_subscription_type_id = '1';
                    $repSingle->purchase_type = RepSingleSubscriptions::PURCHASE_TYPE_NEW;
                    $repSingle->rep_single_price = $amount;
                    $repSingle->rep_single_no_of_months = $no_of_months_db;
                    $repSingle->rep_single_total_month_price = $price_list['total_month_price'];
//                    $repSingle->offer_in_percentage = $registration['step3']['offer_in_percentage'];
//                    $repSingle->offer_price = $registration['step3']['offer_price'];
                    $repSingle->rep_single_total = $price_list['total_price'];
//                    $repSingle->rep_single_tax = $registration['step3']['tax'];
                    $repSingle->rep_single_grand_total = $price_list['grand_total'];
                    $repSingle->rep_single_subscription_start = date('Y-m-d');
                    $repSingle->rep_single_subscription_end = $model->rep_expiry_date;
                    $repSingle->save(false);
                 //   $umodel->attributes  = $sess_attr_u;
                 //   $umodel->ID_RELATION = $model->ID_FOURNISSEUR;
                 //   $umodel->save(false);                
                       
                    
                    // Save the payment details                                   
                    $ptmodel = new PaymentTransaction;
                    $ptmodel->user_id = $model->rep_credential_id;    // need to assign acutal user id
                    $ptmodel->total_price = $amount;
                    $ptmodel->subscription_price = $amount;
                    $ptmodel->payment_status = 'Completed';
                    $ptmodel->payer_email = '';
                    $ptmodel->verify_sign = '';
                    $ptmodel->txn_id = '';
                    $ptmodel->payment_type   = $paytype;
                    $ptmodel->receiver_email = '';
                    $ptmodel->txn_type   = '';
                    $ptmodel->item_name  = $item_name;
                    $ptmodel->NOMTABLE   = 'rep_credentials';
                    $ptmodel->expirydate = $expirydate;
                    $ptmodel->invoice_number = Myclass::getRandomString();
                    $ptmodel->pay_type   = $payment_type;
                    $ptmodel->rep_single_subscription_id=$repSingle->rep_single_subscription_id;
                    $ptmodel->save();
//                    echo 'new payment';
//                    echo '<pre>';
//                    print_r($ptmodel);
//                    exit;
//                    
                    if($_POST['PaymentCheques']['pay_type']=="2")
                    { 
                        $pmodel->payment_transaction_id = $ptmodel->id;
                        $pmodel->save();
                    }
                        
                }

                 // unset Session repcredential model attribute    
            Yii::app()->user->setState("repattributes", null);
            Yii::app()->user->setState("profileattributes", null);
            // unset Session user model attribute
           
            // unset Session marqueids  
            Yii::app()->user->setState("secondtab", null);
            // unset Session scountry  
            Yii::app()->user->setState("scountry", null);
            // unset Session sregion  
            Yii::app()->user->setState("sregion", null);
                

                Yii::app()->user->setFlash('success', 'Informations ales rep ajouter / jour avec succès!!!');
                $this->redirect(array('index'));
            }
            
        }
        
         
        
        if (isset($sess_attr_rep['rep_credential_id'])) {
            $viewpage = 'update';
        } else {
            $viewpage = 'create';
        }
        
        $this->render($viewpage, compact('model', 'tab', 'data_products','pmodel','profile'));
    }  
    
     public function actionRenewpayment()
    {
        $tab    = 2;
        $pmodel = new PaymentCheques;
          
        if (Yii::app()->user->hasState("repattributes") && Yii::app()->user->hasState("profileattributes")){
            $sess_attr_rep = Yii::app()->user->getState("repattributes");
            $sess_attr_pro = Yii::app()->user->getState("profileattributes");
            
            $fid = $sess_attr_rep['rep_credential_id'];
            $model = $this->loadModel($fid);
            $model->attributes = $sess_attr_rep;
            $profile = RepCredentialProfiles::model()->findByAttributes(array('rep_credential_id' => $fid));
            $profile->attributes = $sess_attr_pro;
             $item_name = "SingleRenewalRepAccount";
        }

        
         // Save products in to database        
        if (isset($_POST['PaymentCheques'])) 
        { 
            $pmodel->attributes = $_POST['PaymentCheques'];
            $pmodel->rep_expire_month    = $_POST['PaymentCheques']['rep_expire_month'];
            $pmodel->pay_type   = $_POST['PaymentCheques']['pay_type'];
            $pmodel->profile    = $_POST['PaymentCheques']['profile'];
            $no_of_months_db = $amount = $no_of_months = null;
            
            if($pmodel->pay_type==2)
            { 
              $pmodel->scenario = 'bycheque';
            }
           
            
            if($pmodel->validate())
            {
               
                $rep_expirydate    = $model->rep_expiry_date;
                
//                $sett_infos = SupplierSubscriptionPrice::model()->findByPk(1);
                $rep_subscription_type = RepSubscriptionTypes::model()->findByPk(1);
                if($_POST['PaymentCheques']['pay_type']=="2")
                {    
                    $paytype      = "Cheque";
                    $time = strtotime($rep_expirydate);
                    $no_of_months = $pmodel->rep_expire_month;
                    $expirydate = date("Y-m-d", strtotime("+$no_of_months month", $time));
                    $payment_type = "3";   
                    $amount = $rep_subscription_type->rep_subscription_price;
                    $no_of_months_db=$no_of_months;
                
                }elseif($_POST['PaymentCheques']['pay_type']=="1")
                {
                    $paytype = "Free";  
                    $no_of_months = $pmodel->rep_expire_month;
                    $time = strtotime($rep_expirydate);
                    $expirydate = date("Y-m-d", strtotime("+$no_of_months month", $time));
                    $payment_type = "4";
                    $no_of_months_db=$no_of_months;
                    $no_of_months="0";
                    $amount = 0;
                }  
                
                

                
                // Session supplier model attribute    
                $sess_attr_rep = Yii::app()->user->getState("repattributes");
                // Session user model attribute

                $no_of_accounts_purchased = 1;
                $offer_calculation = false;
                $price_list = Myclass::priceCalculationWithMonths($no_of_months, $no_of_accounts_purchased, $offer_calculation);
                
                if (Yii::app()->user->hasState("repattributes")) {
                   
                    $model->attributes = $sess_attr_rep; 
                    $profile->attributes = $sess_attr_pro;
                
                    $model->rep_expiry_date = $expirydate;
                    
                    $model->save(); 
                    $profile->save(); 
                    
                    
                    
                    $repSingle = new RepSingleSubscriptions;
                    $repSingle->rep_credential_id = $model->rep_credential_id;
                    $repSingle->rep_subscription_type_id = '1';
                    $repSingle->purchase_type = RepSingleSubscriptions::PURCHASE_TYPE_RENEWAL;
                    $repSingle->rep_single_price = $amount;
                    $repSingle->rep_single_no_of_months = $no_of_months_db;
                    $repSingle->rep_single_total_month_price = $price_list['total_month_price'];
//                    $repSingle->offer_in_percentage = $registration['step3']['offer_in_percentage'];
//                    $repSingle->offer_price = $registration['step3']['offer_price'];
                    $repSingle->rep_single_total = $price_list['total_price'];
//                    $repSingle->rep_single_tax = $registration['step3']['tax'];
                    $repSingle->rep_single_grand_total = $price_list['grand_total'];
                    $repSingle->rep_single_subscription_start = date('Y-m-d');
                    $repSingle->rep_single_subscription_end = $model->rep_expiry_date;
                    $repSingle->save(false);
                 //   $umodel->attributes  = $sess_attr_u;
                 //   $umodel->ID_RELATION = $model->ID_FOURNISSEUR;
                 //   $umodel->save(false);                
                       
                    
                    // Save the payment details                                   
                    $ptmodel = new PaymentTransaction;
                    $ptmodel->user_id = $model->rep_credential_id;    // need to assign acutal user id
                    $ptmodel->total_price = $price_list['total_price'];
                    $ptmodel->subscription_price = $amount;
                    $ptmodel->payment_status = 'Completed';
                    $ptmodel->payer_email = '';
                    $ptmodel->verify_sign = '';
                    $ptmodel->txn_id = '';
                    $ptmodel->payment_type   = $paytype;
                    $ptmodel->receiver_email = '';
                    $ptmodel->txn_type   = '';
                    $ptmodel->item_name  = $item_name;
                    $ptmodel->NOMTABLE   = 'rep_credentials';
                    $ptmodel->expirydate = $expirydate;
                    $ptmodel->invoice_number = Myclass::getRandomString();
                    $ptmodel->pay_type   = $payment_type;
                     $ptmodel->rep_single_subscription_id=$repSingle->rep_single_subscription_id;
                    $ptmodel->save();
//                    echo 'new payment';
//                    echo '<pre>';
//                    print_r($ptmodel);
//                    exit;
//                    
                    if($_POST['PaymentCheques']['pay_type']=="2")
                    { 
                        $pmodel->payment_transaction_id = $ptmodel->id;
                        $pmodel->save();
                    }
                        
                }

                  Yii::app()->user->setFlash('success', 'Abonnement renouveler avec succès !!!');
                $this->redirect(array('renewpayment'));
            }
            else{
                $erorr = $pmodel->getErrors();
                print_r($erorr);
                exit;
            }
            
        }
        
         
        
        $viewpage = 'update';
       
        
        $this->render($viewpage, compact('model', 'tab', 'pmodel','profile'));
    }
    
    
    public function loadModel($id) {
        $model = RepCredentials::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rep-credential-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
