<?php

class SuppliersDirectoryController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $lang='EN';
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
               parent::accessRules(), 
                array(
                    array('allow', // allow all users to perform 'index' and 'view' actions
                        'actions' => array(''),
                        'users' => array('*'),
                    ),
                    array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'getproducts', 'addproducts', 'addmarques', 'listmarques', 'payment', 'renewpayment', 'getfichers','getficherimage', 'deleteProof','generateclients'),
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
       

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        
        $pmodel =  PaymentTransaction::model()->findByPk($id);
        $this->render('view', array(
            'pmodel' => $pmodel,
        ));
    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        
        $data_products = array();

        $model = $this->loadModel($id);
        $model->scenario = 'backend';
        
        $pmodel = new PaymentCheques;
       // $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));        
        
        $mattributes = $model->attributes;
      //  $uattributes = $umodel->attributes;

        Yii::app()->user->setState("mattributes", $mattributes);
     //   Yii::app()->user->setState("uattributes", $uattributes);

        // Set and intialize session from existing database records.         
        if (Yii::app()->user->hasState("product_ids") == FALSE) 
        {     
            $fid = $id;
            $criteria1 = new CDbCriteria();
            $criteria1->condition = 'ID_FOURNISSEUR=:id';
            $criteria1->params = array(':id' => $fid);
            $criteria1->group = 'productMarqueDirectory.ID_PRODUIT';
            $get_selected_products = CHtml::listData(SupplierProducts::model()->with("productMarqueDirectory")->findAll($criteria1), 'ID_LIEN_REPERTOIRE_PRODUIT', 'productMarqueDirectory.ID_PRODUIT');

            /* Set products in session */
            if (!empty($get_selected_products)) 
            {
                foreach ($get_selected_products as $pinfo) {
                    $result[] = $pinfo;
                }
                Yii::app()->user->setState("product_ids", $result);                
                $data_products = SuppliersDirectory::getproducts($result);

                /* Set marques in session */
                foreach ($result as $pid) {
                    $prodid = $pid;
                    $criteria1 = new CDbCriteria();
                    $criteria1->condition = "ID_FOURNISSEUR=:fid AND productMarqueDirectory.ID_PRODUIT=:pid";
                    $criteria1->params = array(":fid" => $fid, ":pid" => $prodid);
                    $get_selected_marques = CHtml::listData(SupplierProducts::model()->with("productMarqueDirectory")->findAll($criteria1), 'ID_LIEN_REPERTOIRE_PRODUIT', 'productMarqueDirectory.ID_MARQUE');

                    if (!empty($get_selected_marques)) 
                    {
                        $ma_ids = array();
                        foreach ($get_selected_marques as $minfo) {
                            $ma_ids[] = $minfo;
                        }
                        if (!empty($ma_ids)) {
                            $imp_mids = implode(',', $ma_ids);
                            $marque_ids[$pid] = $imp_mids;
                        }
                    }
                }

                if (!empty($marque_ids)) {
                    Yii::app()->user->setState("marque_ids", $marque_ids);
                }
            }
        }
         

        if (isset($_POST['SuppliersDirectory'])) 
        {
            $model->attributes = $_POST['SuppliersDirectory'];
            $model->pfile = CUploadedFile::getInstance($model,'pfile');
         //   $umodel->attributes = $_POST['UserDirectory'];
         //   $umodel->NOM_TABLE = $model::$NOM_TABLE;
         //   $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;

        //    $valid = $umodel->validate();
        //    $valid = $model->validate() && $valid;

            if ($model->validate()) {

                //set session variable
                $scountry = $_POST['SuppliersDirectory']['country'];
                $sregion  = $_POST['SuppliersDirectory']['region'];
                Yii::app()->user->setState("scountry", $scountry);
                Yii::app()->user->setState("sregion", $sregion);
                
                  // save proof file
                if($model->pfile)
                {   
                    $filename = time() . '_' . $model->pfile->name;                    
                    $model->proof_file = $filename;
                    $proof_path = Yii::getPathOfAlias('webroot').'/'.PROOF_PATH.'/';                    
                    if (!is_dir($proof_path)) {
                        mkdir($proof_path, 0777, true);
                    }
                    $model->pfile->saveAs($proof_path . $filename);
                }   

                $mattributes = $model->attributes;
                if ($model->ID_VILLE == "-1") {
                    $regionid = $model->region;
                    $othercity = $model->autre_ville;
                    $condition = "ID_REGION='$regionid' and NOM_VILLE='$othercity'";
                    $city_exist = CityDirectory::model()->find($condition);
                    if (!empty($city_exist)) {
                        $model->ID_VILLE = $city_exist->ID_VILLE;
                    } else {
                        $cinfo = new CityDirectory;
                        $cinfo->ID_REGION = $regionid;
                        $cinfo->NOM_VILLE = $othercity;
                        $cinfo->country = $model->country;
                        $cinfo->save(false);
                        $model->ID_VILLE = $cinfo->ID_VILLE;
                    }
                }
              //  $uattributes = $umodel->attributes;
                $model->DATE_MODIFICATION = date('Y-m-d H:i:s', time());
                $model->save(false);  
             //   $umodel->save(false);

                Yii::app()->user->setState("mattributes", $mattributes);
             //   Yii::app()->user->setState("uattributes", $uattributes);
                Yii::app()->user->setState("secondtab", "2");

                $this->redirect(array('addproducts'));
            }
        }
        
        if(Yii::app()->user->hasState("product_ids"))
        {    
            $proids = Yii::app()->user->getState("product_ids");
            $data_products = SuppliersDirectory::getproducts($proids);
        }   

        $tab = 1;
        $this->render('update', compact('model', 'tab','data_products','pmodel'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    
    /*
      // unset Session supplier model attribute    
            Yii::app()->user->setState("mattributes", null);
            // unset Session user model attribute
            Yii::app()->user->setState("uattributes", null);
            // unset Session productids 
            Yii::app()->user->setState("product_ids", null);
            // unset Session marqueids 
            Yii::app()->user->setState("marque_ids", null);
            // unset Session marqueids 
            Yii::app()->user->setState("thirdtab", null);
            // unset Session marqueids  
            Yii::app()->user->setState("secondtab", null);
            // unset Session scountry  
            Yii::app()->user->setState("scountry", null);
            // unset Session sregion  
            Yii::app()->user->setState("sregion", null);
     *      */
    public function actionCreate() {
        
        

        $model  = new SuppliersDirectory('backend');
        $pmodel = new PaymentCheques;
   //     $umodel = new UserDirectory();
        
        if(Yii::app()->user->hasState("secondtab") || Yii::app()->user->hasState("thirdtab") || Yii::app()->user->hasState("fourthtab"))
        {    
            //check if session exists
            if (Yii::app()->user->hasState("mattributes")) {
                //get session variable
                $sess_attr_m = Yii::app()->user->getState("mattributes");
                $model->attributes = $sess_attr_m;
             //   $sess_attr_u = Yii::app()->user->getState("uattributes");
              //  $umodel->attributes = $sess_attr_u;
            }
        } else {
              // unset Session supplier model attribute    
            Yii::app()->user->setState("mattributes", null);
            // unset Session user model attribute
           // Yii::app()->user->setState("uattributes", null);
            // unset Session productids 
            Yii::app()->user->setState("product_ids", null);
            // unset Session marqueids 
            Yii::app()->user->setState("marque_ids", null);
            // unset Session marqueids 
            Yii::app()->user->setState("thirdtab", null);
            Yii::app()->user->setState("fourthtab", null);
            // unset Session marqueids  
            Yii::app()->user->setState("secondtab", null);
            // unset Session scountry  
            Yii::app()->user->setState("scountry", null);
            // unset Session sregion  
            Yii::app()->user->setState("sregion", null);
        }   
        

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));

        if (isset($_POST['SuppliersDirectory'])) {

            $model->attributes = $_POST['SuppliersDirectory'];
            $model->pfile = CUploadedFile::getInstance($model,'pfile');
          //  $umodel->attributes = $_POST['UserDirectory'];

          //  $model->ID_CLIENT = $umodel->USR;

         //   $umodel->NOM_TABLE = $model::$NOM_TABLE;
//            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
//            $umodel->PWD = Myclass::getRandomString(5);
//            $umodel->sGuid = Myclass::getGuid();
//            $umodel->LANGUE  = "FR";

          //  $valid = $umodel->validate();
          //  $valid = $model->validate() && $valid;

            if ( $model->validate()) {
                //set session variable
                $scountry = $_POST['SuppliersDirectory']['country'];
                $sregion  = $_POST['SuppliersDirectory']['region'];
                Yii::app()->user->setState("scountry", $scountry);
                Yii::app()->user->setState("sregion", $sregion);
                
                  // save proof file
                if($model->pfile)
                {   
                    $filename = time() . '_' . $model->pfile->name;                    
                    $model->proof_file = $filename;
                    $proof_path = Yii::getPathOfAlias('webroot').'/'.PROOF_PATH.'/';                    
                    if (!is_dir($proof_path)) {
                        mkdir($proof_path, 0777, true);
                    }
                    $model->pfile->saveAs($proof_path . $filename);
                }   
                if ($model->ID_VILLE == "-1") {
                    $regionid = $model->region;
                    $othercity = $model->autre_ville;
                    $condition = "ID_REGION='$regionid' and NOM_VILLE='$othercity'";
                    $city_exist = CityDirectory::model()->find($condition);
                    if (!empty($city_exist)) {
                        $model->ID_VILLE = $city_exist->ID_VILLE;
                    } else {
                        $cinfo = new CityDirectory;
                        $cinfo->ID_REGION = $regionid;
                        $cinfo->NOM_VILLE = $othercity;
                        $cinfo->country = $model->country;
                        $cinfo->save(false);
                        $model->ID_VILLE = $cinfo->ID_VILLE;
                    }
                }
                
                $mattributes = $model->attributes;
              //  $uattributes = $umodel->attributes;

                Yii::app()->user->setState("mattributes", $mattributes);

             //   Yii::app()->user->setState("uattributes", $uattributes);
                Yii::app()->user->setState("secondtab", "2");

                $this->redirect(array('addproducts'));
            }
//            else
//            {
//                //$errores = $model->getErrors();
//                //print_r($errores);
//               
//            }    
        }
        $tab = 1;
        $this->render('create', compact('model', 'tab','pmodel'));
    }

    //TAB 2
    public function actionAddproducts() {

        $data_products = array();
        $pmodel = new PaymentCheques;
        
        
        if (Yii::app()->user->hasState("mattributes")) {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
        }       
         
        /* Set session value for edit form */
        if (!empty($sess_attr_m)) 
        {
            //Check for update form
            if (isset($sess_attr_m['ID_FOURNISSEUR'])) 
             {
                $result = array();
                $fid = $sess_attr_m['ID_FOURNISSEUR'];
                $model = $this->loadModel($fid);
              //  $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");               
            } else {
                // For create form
                $model  = new SuppliersDirectory;
             //   $umodel = new UserDirectory();
            }
        }
        //check if session exists
        if (Yii::app()->user->hasState("mattributes")) 
        {
            //get session variable
            $model->attributes = $sess_attr_m;
           // $sess_attr_u = Yii::app()->user->getState("uattributes");
           // $umodel->attributes = $sess_attr_u;
        }

        if ($_POST['SuppliersDirectory']) {
            $product_ids = $_POST['SuppliersDirectory']['Products2'];

            if (!empty($product_ids)) {
                $result = $product_ids;

                if (Yii::app()->user->hasState("product_ids")) {
                    $sess_product_ids = Yii::app()->user->getState("product_ids");
                    $result = array_merge($product_ids, $sess_product_ids);
                    array_unique($result);
                }

                // Set default 0 (All brands) value to marques for newly added products only
                foreach ($product_ids as $key => $info) {
                    $marque_ids[$info] = 0;
                }

                $marque_result = $marque_ids;

                if (Yii::app()->user->hasState("marque_ids")) 
                {
                    $sess_marque_ids = Yii::app()->user->getState("marque_ids");
                    $marque_result = $marque_ids + $sess_marque_ids;
                    array_unique($marque_result);
                }

                Yii::app()->user->setState("marque_ids", $marque_result);
                Yii::app()->user->setState("product_ids", $result);
                Yii::app()->user->setState("thirdtab", "3");
            }else
            {
                 Yii::app()->user->setState("thirdtab", "3");
            }    

            $this->redirect(array('addmarques'));
        }
        
        if(Yii::app()->user->hasState("product_ids"))
        {    
            $proids        = Yii::app()->user->getState("product_ids");
            $data_products = SuppliersDirectory::getproducts($proids);
        }   
        
        $tab = 2;
        if (isset($sess_attr_m['ID_FOURNISSEUR'])) {
            $viewpage = 'update';
        } else {
            $viewpage = 'create';
        }
        $this->render($viewpage, compact('model', 'tab','data_products','pmodel'));
    }

    public function actionAddmarques() {
        // Yii::app()->user->setState("marque_ids", null);
        
        $sess_product_ids = array();
        $data_products = array();
        
        $pmodel = new PaymentCheques;
        
        if (Yii::app()->user->hasState("mattributes")) {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
        }
     
        if (!empty($sess_attr_m))
        {
            //Check for update form
            if (isset($sess_attr_m['ID_FOURNISSEUR'])) 
            {
                $fid = $sess_attr_m['ID_FOURNISSEUR'];
                $model = $this->loadModel($fid);
              //  $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");
            } else {
                $model = new SuppliersDirectory;
              //  $umodel = new UserDirectory();
            }
        }       
        
        //check if session exists
        if (Yii::app()->user->hasState("mattributes")) {
            //get session variable         
            $model->attributes = $sess_attr_m;
          //  $sess_attr_u = Yii::app()->user->getState("uattributes");
          //  $umodel->attributes = $sess_attr_u;
        }
        
          // Save products in to database        
        if (isset($_POST['yt2'])) 
        {   
           Yii::app()->user->setState("fourthtab", "4");
           
           // Update products and marques
            if (isset($sess_attr_m['ID_FOURNISSEUR'])) {
                
                $supplierid = $sess_attr_m['ID_FOURNISSEUR'];
                // Session productids 
                $sess_productids = Yii::app()->user->getState("product_ids");
                // Session marqueids 
                $sess_marqueids = Yii::app()->user->getState("marque_ids");

                SupplierProducts::model()->deleteAll("ID_FOURNISSEUR ='" . $supplierid . "'");

                if (Yii::app()->user->hasState("product_ids")) {
                    foreach ($sess_productids as $pids) {
                        $productid = $pids;
                        if (array_key_exists($productid, $sess_marqueids)) {
                            $allmarqid = $sess_marqueids[$productid];
                            $exp_marid = explode(',', $allmarqid);

                            foreach ($exp_marid as $mid) {
                                $marqid = $mid;

                                $criteria1 = new CDbCriteria();
                                $criteria1->condition = 'ID_PRODUIT=:pid and ID_MARQUE=:mid';
                                $criteria1->params = array(':pid' => $productid, ':mid' => $marqid);
                                $get_product_marques = ProductMarqueDirectory::model()->find($criteria1);

                                if ($get_product_marques->ID_LIEN_MARQUE) {
                                    $prd_mar_id = $get_product_marques->ID_LIEN_MARQUE;
                                    $spmodel = new SupplierProducts();
                                    $spmodel->ID_FOURNISSEUR = $supplierid;
                                    $spmodel->ID_LIEN_PRODUIT_MARQUE = $prd_mar_id;
                                    $spmodel->save(false);
                                }
                            }
                        }
                    }
                }
                
                Yii::app()->user->setFlash('success', 'Informations fournisseur ajouter / jour avec succès!!!');
                $this->redirect(array('update',"id"=>$sess_attr_m['ID_FOURNISSEUR']));
            }else
            {
             // redirect to payment page on regsitration time
                $this->redirect(array('payment'));
            }
        
        }

        // Delete products from session
        if (isset($_POST['yt3'])) {
            
            $sess_product_ids = Yii::app()->user->getState("product_ids");
           
            $pids = isset($_POST['productid']) ? $_POST['productid'] : '';
            if ($pids != '') {          
                foreach ($pids as $pid) {
                    if (($key = array_search($pid, $sess_product_ids)) !== FALSE) {
                        // Remove from array
                        unset($sess_product_ids[$key]);
                    }

                    if (Yii::app()->user->hasState("marque_ids")) {
                        // UNset marque ids for the product                   
                        $sess_marque_ids = Yii::app()->user->getState("marque_ids");
                        if (array_key_exists($pid, $sess_marque_ids)) {
                            // Remove from array                      
                            unset($sess_marque_ids[$pid]);
                        }
                    }
                }
                Yii::app()->user->setState("product_ids", $sess_product_ids);
                Yii::app()->user->setState("marque_ids", $sess_marque_ids);
            } else {
                Yii::app()->user->setFlash('danger', 'S\'il vous plaît sélectionner tous les produits à supprimer!!!');
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

        $tab = 3;
     
        if (isset($sess_attr_m['ID_FOURNISSEUR'])) {
            $viewpage = 'update';
        } else {
            $viewpage = 'create';
        }
       
        $this->render($viewpage, compact('model', 'tab', 'data_products','pmodel'));
    }
    
    public function actionPayment()
    {
        $tab    = 4;
        $pmodel = new PaymentCheques;
          
        if (Yii::app()->user->hasState("mattributes")) {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
        }
     
        if (!empty($sess_attr_m))
        {
            //Check for update form
            if (isset($sess_attr_m['ID_FOURNISSEUR'])) 
            {
                $fid = $sess_attr_m['ID_FOURNISSEUR'];
                $model = $this->loadModel($fid);
              //  $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");
            } else {
                $model = new SuppliersDirectory;              
              //  $umodel = new UserDirectory();
            }
        }   
        
        //check if session exists
        if (Yii::app()->user->hasState("mattributes")) 
        {
            //get session variable
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
                    $expirydate   = date("Y-m-d", strtotime('+1 year'));
                    $payment_type = "3";   
                    $profile_price = $sett_infos->profile_price;
                    $profile_logo_price = $sett_infos->profile_logo_price;
                    $logo_price = ( $profile_logo_price - $profile_price );
                    
                }elseif($_POST['PaymentCheques']['pay_type']=="1")
                {
                    $paytype = "Free";  
                    $expdays = $sett_infos->expire_days;
                    $expirydate = date("Y-m-d", strtotime("+$expdays days"));
                    $payment_type = "4";
                    $profile_price = '0';
                    $profile_logo_price = '0';
                    $logo_price = ( $profile_logo_price - $profile_price );
                }  
                
                

                $sub_type_profile = $_POST['PaymentCheques']['profile'];
                $sub_type_logo    = $_POST['PaymentCheques']['logo'];
                
                // Session supplier model attribute    
                $sess_attr_m = Yii::app()->user->getState("mattributes");
                // Session user model attribute
                // $sess_attr_u = Yii::app()->user->getState("uattributes");
                // Session productids 
                $sess_productids = Yii::app()->user->getState("product_ids");
                // Session marqueids 
                $sess_marqueids = Yii::app()->user->getState("marque_ids");

                if (Yii::app()->user->hasState("mattributes")) {
                    $model->attributes = $sess_attr_m;    
                  //  $model->ID_CLIENT  = $sess_attr_m['ID_CLIENT'];
                    
                    if($sub_type_profile==1 && $sub_type_logo==1)
                    {
                        $subscriptiontype = "2";
                        $amount = $profile_logo_price;    
                        $model->profile_expirydate = $expirydate;
                        $model->logo_expirydate = $expirydate;
                        $item_name = "Suppliers Subscription - Profile & logo";

                    }else if($sub_type_profile==1 && $sub_type_logo==0)
                    {
                        $subscriptiontype = "1";
                        $amount = $profile_price;
                        $model->profile_expirydate = $expirydate;
                        $item_name = "Suppliers Subscription - Profile only";

                    }else if($sub_type_profile==0 && $sub_type_logo==1)
                    {
                        $subscriptiontype = "3";
                        $amount = $logo_price;
                        $model->logo_expirydate = $expirydate;
                        $item_name = "Suppliers Subscription - Logo only";
                    }  
                    
                    $model->CREATED_DATE = date('Y-m-d H:i:s', time());
                    $model->DATE_MODIFICATION = date('Y-m-d H:i:s', time());
                    $model->save(false);              
                 //   $umodel->attributes  = $sess_attr_u;
                 //   $umodel->ID_RELATION = $model->ID_FOURNISSEUR;
                 //   $umodel->save(false);                
                    $supplierid = $model->ID_FOURNISSEUR;

                    SupplierProducts::model()->deleteAll("ID_FOURNISSEUR ='" . $supplierid . "'");

                    if (Yii::app()->user->hasState("product_ids")) {
                        foreach ($sess_productids as $pids) {
                            $productid = $pids;
                            if (array_key_exists($productid, $sess_marqueids)) {
                                $allmarqid = $sess_marqueids[$productid];
                                $exp_marid = explode(',', $allmarqid);

                                foreach ($exp_marid as $mid) {
                                    $marqid = $mid;

                                    $criteria1 = new CDbCriteria();
                                    $criteria1->condition = 'ID_PRODUIT=:pid and ID_MARQUE=:mid';
                                    $criteria1->params = array(':pid' => $productid, ':mid' => $marqid);
                                    $get_product_marques = ProductMarqueDirectory::model()->find($criteria1);

                                    if ($get_product_marques->ID_LIEN_MARQUE) {
                                        $prd_mar_id = $get_product_marques->ID_LIEN_MARQUE;
                                        $spmodel = new SupplierProducts();
                                        $spmodel->ID_FOURNISSEUR = $supplierid;
                                        $spmodel->ID_LIEN_PRODUIT_MARQUE = $prd_mar_id;
                                        $spmodel->save(false);
                                    }
                                }
                            }
                        }
                    }         
                    
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
                    $ptmodel->subscription_type = $subscriptiontype;
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
                Yii::app()->user->setState("mattributes", null);
                // unset Session user model attribute
                //  Yii::app()->user->setState("uattributes", null);
                // unset Session productids 
                Yii::app()->user->setState("product_ids", null);
                // unset Session marqueids 
                Yii::app()->user->setState("marque_ids", null);
                // unset Session marqueids 
                Yii::app()->user->setState("thirdtab", null);
                // unset Session marqueids  
                Yii::app()->user->setState("secondtab", null);
                // unset Session 
                Yii::app()->user->setState("fourthtab", null);
                // unset Session scountry  
                Yii::app()->user->setState("scountry", null);
                // unset Session sregion  
                Yii::app()->user->setState("sregion", null);

                Yii::app()->user->setFlash('success', 'Informations fournisseur ajouter / jour avec succès!!!');
                $this->redirect(array('index'));
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
        
        if (isset($sess_attr_m['ID_FOURNISSEUR'])) {
            $viewpage = 'update';
        } else {
            $viewpage = 'create';
        }
        
        $this->render($viewpage, compact('model', 'tab', 'data_products','pmodel'));
    }  
    
    
    public function actionRenewpayment()
    {
        $tab    = 4;
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
                    
                    $profile_price = $sett_infos->profile_price;
                $profile_logo_price = $sett_infos->profile_logo_price;
                $logo_price = ( $profile_logo_price - $profile_price );

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
                    $profile_price = '0';
                $profile_logo_price = '0';
                $logo_price = ( $profile_logo_price - $profile_price );
                    
                }  
                
                

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
                    $lang = 'FR';
                    if($lang=='EN' ){
                            $subject = 'OptiGuide - Renewed your account';
                    }elseif($lang=='FR'){
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
       
        $this->render($viewpage, compact('model', 'tab', 'data_products','pmodel'));
    }  

    public function actionListmarques() {
        $pid = Yii::app()->getRequest()->getQuery('id');
        $get_selected_marques = '';
        if (is_numeric($pid) && $pid != '') {

            /* Get the marques of the product */
            $criteria1 = new CDbCriteria();
            $criteria1->order = "NOM_MARQUE";
            $criteria1->condition = 'ID_PRODUIT=:id';
            $criteria1->params = array(':id' => $pid);
            $get_selected_marques = CHtml::listData(MarqueDirectory::model()->with("productMarqueDirectory")->isActive()->findAll($criteria1), 'ID_MARQUE', 'NOM_MARQUE');

            if (isset($_POST) && $_POST['yt0'] == "Associer ces marques") {
                $marque_ids = array();
                if (isset($_POST['marqueid'])) {
                    $imp_vals = implode(',', $_POST['marqueid']);
                    $marque_ids[$pid] = $imp_vals;
                    $result = $marque_ids;

                    // Check the exist session marque products and append it
                    if (Yii::app()->user->hasState("marque_ids")) {
                        $sess_marque_ids = Yii::app()->user->getState("marque_ids");
                        $result = $marque_ids + $sess_marque_ids;
                        array_unique($result);
                    }
                    Yii::app()->user->setState("marque_ids", $result);
                } else {
                    // unset product id
                    if (Yii::app()->user->hasState("product_ids")) {
                        $sess_product_ids = Yii::app()->user->getState("product_ids");
                        if (($key = array_search($pid, $sess_product_ids)) !== FALSE) {
                            // Remove from array
                            unset($sess_product_ids[$key]);
                        }
                        Yii::app()->user->setState("product_ids", $sess_product_ids);

                        // UNset marque ids for the product                   
                        $sess_marque_ids = Yii::app()->user->getState("marque_ids");
                        if (array_key_exists($pid, $sess_marque_ids)) {
                            // Remove from array                      
                            unset($sess_marque_ids[$pid]);
                        }
                        Yii::app()->user->setState("marque_ids", $sess_marque_ids);
                    }
                }
                $this->redirect(array('addmarques'));
            }
        } else {
            $this->redirect(array('addmarques'));
        }

        $this->render('listmarques', compact('get_selected_marques'));
    }

    public function actionGetproducts() {
        $options = '';
        $sid = isset($_POST['id']) ? $_POST['id'] : '';
        if ($sid != '') {
            $criteria = new CDbCriteria;
            $criteria->order = 'NOM_PRODUIT_FR ASC';
            $criteria->condition = 'ID_SECTION=:id';
            $criteria->params = array(':id' => $sid);
            $data_products = CHtml::listData(ProductDirectory::model()->findAll($criteria), 'ID_PRODUIT', 'NOM_PRODUIT_FR');
            foreach ($data_products as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        
        $user=UserDirectory::model()->find('ID_RELATION=:id_relation AND NOM_TABLE=:nom_table',array(':id_relation'=>$id,'nom_table'=>'Fournisseurs') ); 
        $user->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'SuppliersDirectory Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
       
           // unset Session supplier model attribute    
            Yii::app()->user->setState("mattributes", null);
            // unset Session user model attribute
          //  Yii::app()->user->setState("uattributes", null);
            // unset Session productids 
            Yii::app()->user->setState("product_ids", null);
            // unset Session marqueids 
            Yii::app()->user->setState("marque_ids", null);
            // unset Session marqueids 
            Yii::app()->user->setState("thirdtab", null);
            // unset Session marqueids  
            Yii::app()->user->setState("secondtab", null);
            // unset Session scountry  
            Yii::app()->user->setState("scountry", null);
            // unset Session sregion  
            Yii::app()->user->setState("sregion", null);
       
        $model = new SuppliersDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SuppliersDirectory']))
            $model->attributes = $_GET['SuppliersDirectory'];

        $this->render('index', array(
            'model' => $model,
        ));
    }
    
    public function actionDeleteProof($id, $file_name) {
        if (Yii::app()->user->role == 'admin') {
            $model = $this->loadModel($id);
            $file_url = dirname(Yii::app()->request->scriptFile) . '/uploads/user_proofs/' . $file_name;
            if (file_exists($file_url)) {
                unlink($file_url);
                $model->proof_file = '';
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Proof file deleted successfully!!!');
                $this->redirect(array('update', 'id' => $id));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SuppliersDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SuppliersDirectory']))
            $model->attributes = $_GET['SuppliersDirectory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SuppliersDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SuppliersDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SuppliersDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'suppliers-directory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
