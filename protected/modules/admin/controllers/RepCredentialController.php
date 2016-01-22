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
                'actions' => array('index', 'view','update','create','payment','renewpayment'),
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

    public function actionIndex() {
        $model = new RepCredentials('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RepCredentials'])) {
            $model->attributes = $_GET['RepCredentials'];
            $model->search();
        }

        $this->render('index', compact('model'));
    }
    
    public function actionView($id){
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
            'profile' => $model->repCredentialProfiles,
        ));
    }
    public function actionCreate() {
        
        $model  = new RepCredentials;
        $profile  = new RepCredentialProfiles;
        $pmodel = new PaymentCheques;
        $model->scenario = 'update';
        $profile->scenario = 'update';
        
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model,$profile));
        
        if(Yii::app()->user->hasState("secondtab") || Yii::app()->user->hasState("thirdtab"))
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
            Yii::app()->user->setState("thirdtab", null);
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
            $pmodel->profile    = $_POST['PaymentCheques']['profile'];
            $pmodel->pay_type   = $_POST['PaymentCheques']['pay_type'];
            
           
            if($pmodel->pay_type==2)
            { 
              $pmodel->scenario = 'bycheque';
            }
           
            
            if($pmodel->validate())
            {
             
                $sett_infos = SupplierSubscriptionPrice::model()->findByPk(1);
                $rep_subscription_type = RepSubscriptionTypes::model()->findByPk(1);
                if($_POST['PaymentCheques']['pay_type']=="2")
                {    
                    $paytype      = "Cheque";
                    $expirydate   = date("Y-m-d", strtotime('+1 year'));
                    $payment_type = "3";   

                }elseif($_POST['PaymentCheques']['pay_type']=="1")
                {
                    $paytype = "Free";  
                    $expdays = $sett_infos->rep_expire_days;
                    $expirydate = date("Y-m-d", strtotime("+$expdays days"));
                    $payment_type = "4";
                }  
                
                $profile_price = $rep_subscription_type->rep_subscription_price;
                $amount = $profile_price;
//                $profile_logo_price = $sett_infos->profile_logo_price;
//                $logo_price = ( $profile_logo_price - $profile_price );

//                $sub_type_profile = $_POST['PaymentCheques']['profile'];
//                $sub_type_logo    = $_POST['PaymentCheques']['logo'];
                
                // Session supplier model attribute    
                $sess_attr_rep = Yii::app()->user->getState("repattributes");
                // Session user model attribute

                if (Yii::app()->user->hasState("repattributes")) {
                   
                    $model->attributes = $sess_attr_rep; 
                    
                    $profile->attributes = $sess_attr_pro;
                  //  $model->ID_CLIENT  = $sess_attr_rep['ID_CLIENT'];
                    
//                    if($sub_type_profile==1)
//                    {
//                        $subscriptiontype = "1";
//                        $amount = $profile_price;
//                        $model->rep_expiry_date = $expirydate;
//                        $item_name = "Statistics Subscription";
//
//                    }
                    $model->rep_expiry_date = $expirydate;
                    $model->created_at = date("Y-m-d h:i:s",time());
                    $model->modified_at = date("Y-m-d h:i:s",time());
                    $model->save(); 
                    $profile->rep_credential_id = $model->rep_credential_id;
                    $profile->save(); 
                    
                    $repSingle = new RepSingleSubscriptions;
                    $repSingle->rep_credential_id = $model->rep_credential_id;
                    $repSingle->rep_subscription_type_id = '1';
                    $repSingle->purchase_type = RepSingleSubscriptions::PURCHASE_TYPE_NEW;
                    $repSingle->rep_single_price = $amount;
                    $repSingle->rep_single_no_of_months = $no_of_months;
                    $repSingle->rep_single_total_month_price = $amount;
//                    $repSingle->offer_in_percentage = $registration['step3']['offer_in_percentage'];
//                    $repSingle->offer_price = $registration['step3']['offer_price'];
                    $repSingle->rep_single_total = $amount;
//                    $repSingle->rep_single_tax = $registration['step3']['tax'];
                    $repSingle->rep_single_grand_total = $amount;
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

                // unset Session supplier model attribute    
                Yii::app()->user->setState("repattributes", null);
                // unset Session user model attribute
                //  Yii::app()->user->setState("uattributes", null);
                
                // unset Session marqueids  
                Yii::app()->user->setState("secondtab", null);
                // unset Session scountry  
                Yii::app()->user->setState("scountry", null);
                // unset Session sregion  
                Yii::app()->user->setState("sregion", null);

                Yii::app()->user->setFlash('success', 'Informations ales rep ajouter / jour avec succès!!!');
                $this->redirect(array('index'));
            }else
            {
                $errores = $pmodel->getErrors();
                print_r($errores);
               exit;
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
          
        if (Yii::app()->user->hasState("mattributes")) 
        {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
            $fid = $sess_attr_m['ID_FOURNISSEUR'];
            $model = $this->loadModel($fid); 
            $model->attributes = $sess_attr_m;
        }     
       
         // Save products in to database        
        if (isset($_POST['PaymentCheques'])) 
        { 
            $pmodel->attributes = $_POST['PaymentCheques'];
            $pmodel->profile    = $_POST['PaymentCheques']['profile'];
            $pmodel->logo       = $_POST['PaymentCheques']['logo'];
            $pmodel->pay_type   = $_POST['PaymentCheques']['pay_type'];
            
            if($pmodel->pay_type==2)
            {    
              $pmodel->scenario = 'bycheque';
            }
            
            if($pmodel->validate())
            {
                
                $sett_infos = SupplierSubscriptionPrice::model()->findByPk(1);
                if($_POST['PaymentCheques']['pay_type']=="2")
                {    
                    $paytype      = "Cheque";
                    $payment_type = "3";   
                    $expirydate   = date("Y-m-d", strtotime('+1 year'));                    
                   
                    // get existing profile expiry date
                    $profile_expirydate = $model->profile_expirydate;
                    $logo_expirydate    = $model->logo_expirydate;

                    $p_expdate = date("Y-m-d", strtotime($profile_expirydate));
                    if ($p_expdate > date("Y-m-d")) {
                         $time = strtotime($profile_expirydate);
                         $profile_expirydate = date("Y-m-d", strtotime("+1 year", $time));
                    } else {
                         $profile_expirydate = date('Y-m-d', strtotime('+1 year'));
                    }

                     $l_expdate = date("Y-m-d", strtotime($logo_expirydate));
                    if ($l_expdate > date("Y-m-d")) {
                        $time = strtotime($logo_expirydate);
                        $logo_expirydate = date("Y-m-d", strtotime("+1 year", $time));
                    } else {
                        $logo_expirydate = date('Y-m-d', strtotime('+1 year'));
                    }

                }elseif($_POST['PaymentCheques']['pay_type']=="1")
                {
                    $paytype = "Free";  
                    $expdays = $sett_infos->expire_days;
                    $expirydate = date("Y-m-d", strtotime("+$expdays days"));
                    $payment_type = "4";
                    
                    // get existing profile expiry date
                    $profile_expirydate = $model->profile_expirydate;
                    $logo_expirydate    = $model->logo_expirydate;

                    $p_expdate = date("Y-m-d", strtotime($profile_expirydate));
                    if ($p_expdate > date("Y-m-d")) {
                         $time = strtotime($profile_expirydate);
                         $profile_expirydate = date("Y-m-d", strtotime("+$expdays days", $time));
                    } else {
                         $profile_expirydate = date('Y-m-d', strtotime("+$expdays days"));
                    }

                     $l_expdate = date("Y-m-d", strtotime($logo_expirydate));
                    if ($l_expdate > date("Y-m-d")) {
                        $time = strtotime($logo_expirydate);
                        $logo_expirydate = date("Y-m-d", strtotime("+$expdays days", $time));
                    } else {
                        $logo_expirydate = date('Y-m-d', strtotime("+$expdays days"));
                    }            
                    
                }  
                
                $profile_price = $sett_infos->profile_price;
                $profile_logo_price = $sett_infos->profile_logo_price;
                $logo_price = ( $profile_logo_price - $profile_price );

                $sub_type_profile = $_POST['PaymentCheques']['profile'];
                $sub_type_logo    = $_POST['PaymentCheques']['logo'];
                
                // Session supplier model attribute    
                $sess_attr_m = Yii::app()->user->getState("mattributes");
    
                if (Yii::app()->user->hasState("mattributes")) {
                                    
                    if($sub_type_profile==1 && $sub_type_logo==1)
                    {
                        $subscriptiontype = "2";
                        $amount = $profile_logo_price;    
                        $model->profile_expirydate = $profile_expirydate;
                        $model->logo_expirydate = $logo_expirydate;
                        $item_name = "Suppliers Subscription - Profile & logo";

                    }else if($sub_type_profile==1 && $sub_type_logo==0)
                    {
                        $subscriptiontype = "1";
                        $amount = $profile_price;
                        $model->profile_expirydate = $profile_expirydate;
                        $item_name = "Suppliers Subscription - Profile only";

                    }else if($sub_type_profile==0 && $sub_type_logo==1)
                    {
                        $subscriptiontype = "3";
                        $amount = $logo_price;
                        $model->logo_expirydate = $logo_expirydate;
                        $item_name = "Suppliers Subscription - Logo only";
                    }   
                    
                    $model->save(false);
                                
                    $supplierid = $model->ID_FOURNISSEUR;
                    
                    // Save the payment details                                   
                    $ptmodel = new PaymentTransaction;
                    $ptmodel->user_id = $supplierid;    // need to assign acutal user id
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
                    $ptmodel->NOMTABLE   = 'suppliers';
                    $ptmodel->expirydate = $expirydate;
                    $ptmodel->invoice_number = Myclass::getRandomString();
                    $ptmodel->pay_type   = $payment_type;
                    
                    //UserDirectory model
                    $criteria = new CDbCriteria;
                    $criteria->condition = "ID_RELATION = :id AND NOM_TABLE = :nom_table";
                    $criteria->params=(array(':id'=>$supplierid,':nom_table'=>'Fournisseurs'));
                    $row = UserDirectory::model()->find($criteria);
                    $somevariable = $row->COURRIEL;
                    
                    //SuppliersDirectory model
                    $suppmodel = SuppliersDirectory::model()->findByPk($supplierid);
                    
                    if (isset($sess_attr_m['ID_FOURNISSEUR'])) 
                    {
                       $ptmodel->supp_renew_status = "1";
                    }
                    $ptmodel->subscription_type = $subscriptiontype;
                    $ptmodel->save();
                    
                    if($_POST['PaymentCheques']['pay_type']=="2")
                    { 
                        $pmodel->payment_transaction_id = $ptmodel->id;
                        $pmodel->save();
                    }
                    $mail = new Sendmail();
//                    $this->lang = Yii::app()->session['language'];
                    if($this->lang=='EN' ){
                            $subject = 'OptiGuide - Renewed your account';
                    }elseif($this->lang=='FR'){
                            $subject = 'Bienvenu sur notre site OptiGuide';
                    }
                    
                    $nextstep_url = GUIDEURL . 'optiguide/';
                    $trans_array = array(
                        "{NAME}" => $suppmodel->COMPAGNIE,
                        "{NEXTSTEPURL}" => $nextstep_url,
                        "{expirydate}" => $suppmodel->profile_expirydate,
                    );
                    $message = $mail->getMessage('supplier_backend_renew_account', $trans_array);
                    if($somevariable!=''){
                        $mail->send($somevariable, $subject, $message);
                    }
                        
                }
 
               Yii::app()->user->setFlash('success', 'Abonnement renouveler avec succès !!!');
                $this->redirect(array('renewpayment'));
            }    
            
        }
        
         if (Yii::app()->user->hasState("product_ids")) 
        {
            $sess_product_ids = Yii::app()->user->getState("product_ids");
            $data_products   = SuppliersDirectory::getproducts($sess_product_ids);
            
            if(empty($sess_product_ids))
            {
                Yii::app()->user->setState("marque_ids", null); 
            }    
        }
      
       $viewpage = 'update';
       
        $this->render($viewpage, compact('model', 'tab', 'data_products','pmodel','profile'));
    }
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $profile = RepCredentialProfiles::model()->findByAttributes(array('rep_credential_id' => $id));
        $profile->scenario = 'update';
        $this->performAjaxValidation(array($model,$profile));
        if (isset($_POST['client_sub'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];
//            $valid = $model->validate();
//            $valid = $profile->validate() && $valid;
//            echo '<pre>';
//            print_r($model->attributes);
//            print_r($profile->attributes);
//            exit;
                $model->save(false);
                $profile->save(false);
                Yii::app()->user->setFlash('success', 'L\'accès de l\'utilisateur à jour avec succès!!!');
                //$this->redirect(array('index'));
//                $edituserlink =  '/admin/userDirectory/update';
//                $uid =  $model->ID_UTILISATEUR; 
//                $this->redirect(array($edituserlink,"id"=>$uid));
                $this->redirect(array('update', "id" => $id));
        }

        $this->render('update', compact('model','profile'));
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
