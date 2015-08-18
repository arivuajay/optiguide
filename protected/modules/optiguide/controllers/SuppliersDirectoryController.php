<?php

class SuppliersDirectoryController extends OGController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
      
    public $lang;
    
    public function __construct($id, $module = null) {     
        
        $this->lang = Yii::app()->session['language'];      
        parent::__construct($id, $module);
    }

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
                        'actions' => array('create','index','view','category','addproducts', 'addmarques', 'getproducts' , 'listmarques' , 'payment'),
                        'users' => array('*'),
                    ),
                    array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions' => array(),
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView() {
        
        $id         = Yii::app()->request->getParam('id');
        $sectionid  = Yii::app()->request->getParam('sectionid');
        $productid  = Yii::app()->request->getParam('productid');    
        $marqueid   = Yii::app()->request->getParam('marqueid');

        //this query contains supplier informations
        $supplier_query = Yii::app()->db->createCommand() 
        ->select('f.* , af.ID_CATEGORIE , af.FICHIER , af.EXTENSION ,  TYPE_FOURNISSEUR_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft', 'archive_fichier af' ,'repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.iId_fichier=af.ID_FICHIER AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 and ID_FOURNISSEUR=".$id)
        ->queryRow();

        $sectionqry = '';
        $productqry = '';
        $marqueqry  = '';
        $searchModel = new  SuppliersDirectory();  
        
        if($sectionid !='')
        {
            $searchModel->ID_SECTION = $sectionid;
            $sectionqry = " AND rp.ID_SECTION = ".$sectionid;
        }
        if($productid!='')
        {    
           $searchModel->PROD_SERVICE = $productid;
           $productqry = " AND rp.ID_PRODUIT = ".$productid;
        } 

        if($marqueid!='')
        { 
           $marqueqry = " AND rpm.ID_MARQUE = ".$marqueid;
        }
        

        //this query contains get all products with marques list for the supplier
        $products_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('rp.ID_PRODUIT , rm.ID_MARQUE , rp.NOM_PRODUIT_'.$this->lang.' , rm.NOM_MARQUE')
        ->from(array('repertoire_fournisseur_produit rfp','repertoire_produit_marque rpm','repertoire_produit AS rp' ,  'repertoire_marque AS rm'))
        ->where("rfp.ID_LIEN_PRODUIT_MARQUE = rpm.ID_LIEN_MARQUE AND rpm.ID_PRODUIT = rp.ID_PRODUIT AND rpm.ID_MARQUE = rm.ID_MARQUE AND rfp.ID_FOURNISSEUR =".$id.$sectionqry.$productqry.$marqueqry)
        ->order('rp.NOM_PRODUIT_'.$this->lang.',rm.NOM_MARQUE')      
        ->queryAll();


        $result = array();
        foreach ($products_query as $infos) {
             $pid  = $infos['ID_PRODUIT'];
             $prod = $pid.'~'.$infos['NOM_PRODUIT_'.$this->lang.''];            
             $result[$prod][] = $infos;
        }

        $this->render('view', array(
            'model'          => $supplier_query,
            'searchModel'    => $searchModel,
            'supplierproducts' =>  $result
        ));
       
    }
    
     /**
     * Lists all products based on the section
     */
    
    public function actionGetproducts() {
        $options = '';
        $sid = isset($_POST['id']) ? $_POST['id'] : '';
        $options = "<option value=''>" . Myclass::t('OG066', '', 'og') . "</option>";
        if ($sid != '')
        {
            $criteria = new CDbCriteria;
            $criteria->order = 'NOM_PRODUIT_'.$this->lang.' ASC';
            $criteria->condition = 'ID_SECTION=:id';
            $criteria->params = array(':id' => $sid);
            $data_products = CHtml::listData(ProductDirectory::model()->findAll($criteria), 'ID_PRODUIT', 'NOM_PRODUIT_'.$this->lang);          
            foreach ($data_products as $k => $info) 
            {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    /**
     * Lists all suppliers.
     */
    public function actionIndex() {

        $searchModel = new SuppliersDirectory();      
         
        $page  = Yii::app()->request->getParam('page');
        $page  = isset($page) ? $page : 1; 
        $limit = 0;
       
        if($page>1){
         $offset = $page-1;   
         $limit  = LISTPERPAGE * $offset;
        }   
        
        $sname_qry   = '';
        $stype_qry   = '';  
        $section_product_qry = '';
        $infoarr     = array();
        $supplierids = array();
        
        // $searchModel->unsetAttributes();
         if (isset($_GET['SuppliersDirectory'])) {
             
             $searchModel->attributes = $_REQUEST['SuppliersDirectory'];
            
             $search_name    = isset($_GET['SuppliersDirectory']['COMPAGNIE'])?$_GET['SuppliersDirectory']['COMPAGNIE']:'';
             $search_type    = isset($_GET['SuppliersDirectory']['ID_TYPE_FOURNISSEUR'])?$_GET['SuppliersDirectory']['ID_TYPE_FOURNISSEUR']:'';    
             
             /* Sections and Products */
             $search_section = isset($_GET['SuppliersDirectory']['ID_SECTION'])?$_GET['SuppliersDirectory']['ID_SECTION']:''; 
             $search_product = isset($_GET['SuppliersDirectory']['PROD_SERVICE'])?$_GET['SuppliersDirectory']['PROD_SERVICE']:''; 
             
             if( $search_name != '')
             {
                $searchModel->COMPAGNIE =  $search_name;
                $sname_qry  = " AND COMPAGNIE like '%$search_name%' ";
             } 
             
             if( $search_type != '')
             {
                $searchModel->ID_TYPE_FOURNISSEUR =  $search_type;
                $stype_qry  = " AND f.ID_TYPE_FOURNISSEUR = $search_type";
             }  
             
            if($search_section!='')
            {                   
                // Get productmarques ids based on products and sections
                $criteria = new CDbCriteria;                        
                $criteria->with = array("productMarqueDirectory"=>array("select"=>"ID_LIEN_MARQUE"));
                $criteria->condition = 'ID_SECTION=:id';
                $criteria->params = array(':id' => $search_section);
                if($search_product!='')
                {    
                    $criteria->condition = 't.ID_PRODUIT=:pid';
                    $criteria->params = array(':pid' => $search_product);
                }                     
                $data_products_marques = ProductDirectory::model()->findAll($criteria);

                foreach($data_products_marques as $infos)
                {                        
                    foreach ($infos['productMarqueDirectory'] as $info2)
                    {
                        $infoarr[] = $info2['ID_LIEN_MARQUE'];
                    }                        
                } 

                if(!empty($infoarr))
                { 
                    // Get supplierids related to the productmarques   
                    $criteria = new CDbCriteria;    
                    $criteria->addInCondition('ID_LIEN_PRODUIT_MARQUE',$infoarr);
                    $criteria->group     = 'ID_FOURNISSEUR';                                         
                    $data_suppliers = SupplierProducts::model()->findAll($criteria);

                    foreach($data_suppliers as $infos3)
                    { 
                        $supplierids[] = $infos3['ID_FOURNISSEUR'];                           
                    }
                } 

                if(!empty($supplierids))
                {
                    $imp_suppids = (count($supplierids)>1)?implode(',',$supplierids):$supplierids[0];
                    $section_product_qry = " AND f.ID_FOURNISSEUR IN (".$imp_suppids.") ";
                }    
                    
            }    
            
         }
             
       // Get all records list  with limit
        $supplier_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('ID_FOURNISSEUR , COMPAGNIE , TYPE_FOURNISSEUR_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 ".$sname_qry.$stype_qry.$section_product_qry)
        ->order('ft.TYPE_FOURNISSEUR_'.$this->lang.',COMPAGNIE')
        ->limit( LISTPERPAGE , $limit) // the trick is here!
        ->queryAll();
      
       // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
        ->select('count(*) as count')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 ".$sname_qry.$stype_qry.$section_product_qry)
        ->queryScalar(); // do not LIMIT it, this must count all items!

        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(LISTPERPAGE);
        
        $result = array();
        foreach ($supplier_query as $users) {
            $supptype = $users['TYPE_FOURNISSEUR_'.$this->lang.''];            
            $result[$supptype][] = $users;
        }
        
        // render
        $this->render('index',array(
        'searchModel' => $searchModel,
        'model'=>$result,
        'item_count'=>$item_count,
        'page_size'=>LISTPERPAGE,
        'pages'=>$pages,             
       ));    
    
    }
    
    /**
     * Lists all suppliers based category.
     */
    public function actionCategory() {

        $searchModel = new SuppliersDirectory();      
         
        $page  = Yii::app()->request->getParam('page');
        $page  = isset($page) ? $page : 1; 
        $limit = 0;
       
        if($page>1){
         $offset = $page-1;   
         $limit  = LISTPERPAGE * $offset;
        }   
               
        $section_product_qry = '';
        $infoarr     = array();
        $supplierids = array();
        
        // $searchModel->unsetAttributes();
         if (isset($_GET['SuppliersDirectory'])) {
             
             $searchModel->attributes = $_REQUEST['SuppliersDirectory'];
             
             /* Sections and Products */
             $search_section = isset($_GET['SuppliersDirectory']['ID_SECTION'])?$_GET['SuppliersDirectory']['ID_SECTION']:''; 
             $search_product = isset($_GET['SuppliersDirectory']['PROD_SERVICE'])?$_GET['SuppliersDirectory']['PROD_SERVICE']:''; 
            
             
            if($search_section!='')
            {                   
                // Get productmarques ids based on products and sections
                $criteria = new CDbCriteria;                        
                $criteria->with = array("productMarqueDirectory"=>array("select"=>"ID_LIEN_MARQUE"));
                $criteria->condition = 'ID_SECTION=:id';
                $criteria->params = array(':id' => $search_section);
                if($search_product!='')
                {    
                    $criteria->condition = 't.ID_PRODUIT=:pid';
                    $criteria->params = array(':pid' => $search_product);
                }                     
                $data_products_marques = ProductDirectory::model()->findAll($criteria);

                foreach($data_products_marques as $infos)
                {                        
                    foreach ($infos['productMarqueDirectory'] as $info2)
                    {
                        $infoarr[] = $info2['ID_LIEN_MARQUE'];
                    }                        
                } 

                if(!empty($infoarr))
                { 
                    // Get supplierids related to the productmarques   
                    $criteria = new CDbCriteria;    
                    $criteria->addInCondition('ID_LIEN_PRODUIT_MARQUE',$infoarr);
                    $criteria->group     = 'ID_FOURNISSEUR';                                         
                    $data_suppliers = SupplierProducts::model()->findAll($criteria);

                    foreach($data_suppliers as $infos3)
                    { 
                        $supplierids[] = $infos3['ID_FOURNISSEUR'];                           
                    }
                } 

                if(!empty($supplierids))
                {
                    $imp_suppids = (count($supplierids)>1)?implode(',',$supplierids):$supplierids[0];
                    $section_product_qry = " AND f.ID_FOURNISSEUR IN (".$imp_suppids.") ";
                }    
                    
            }    
            
         }
             
       // Get all records list  with limit
        $supplier_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('ID_FOURNISSEUR , COMPAGNIE , TYPE_FOURNISSEUR_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 ".$section_product_qry)
        ->order('ft.TYPE_FOURNISSEUR_'.$this->lang.',COMPAGNIE')
        ->limit( LISTPERPAGE , $limit) // the trick is here!
        ->queryAll();
      
       // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
        ->select('count(*) as count')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 ".$section_product_qry)
        ->queryScalar(); // do not LIMIT it, this must count all items!

        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(LISTPERPAGE);
        
         $result = array();
        foreach ($supplier_query as $users) {
            $supptype = $users['TYPE_FOURNISSEUR_'.$this->lang.''];            
            $result[$supptype][] = $users;
        }          
    
        // render
        $this->render('index',array(
        'searchModel' => $searchModel,
        'model'=> $result,
        'item_count'=> $item_count,
        'page_size'=> LISTPERPAGE,
        'pages'=> $pages,         
       ));    
    
    }
    
     public function actionCreate() {
        
        

        $model = new SuppliersDirectory; 
        $umodel = new UserDirectory('frontend');

        if(Yii::app()->user->hasState("secondtab") || Yii::app()->user->hasState("thirdtab"))
        {    
            //check if session exists
            if (Yii::app()->user->hasState("mattributes") && Yii::app()->user->hasState("uattributes")) {
                //get session variable
                $sess_attr_m = Yii::app()->user->getState("mattributes");
                $model->attributes = $sess_attr_m;
                $sess_attr_u = Yii::app()->user->getState("uattributes");
               $umodel->attributes = $sess_attr_u;
            }
        } else {
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
        }   
        

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model,$umodel));

        if (isset($_POST['SuppliersDirectory'])) {

            $model->attributes  = $_POST['SuppliersDirectory'];                     
            $umodel->attributes = $_POST['UserDirectory'];
            $model->ID_CLIENT    = $umodel->USR;
            $model->COURRIEL    = $umodel->COURRIEL;
            $umodel->NOM_TABLE  = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
            $umodel->sGuid  = Myclass::getGuid();
            $umodel->LANGUE = Yii::app()->session['language'];
            $umodel->MUST_VALIDATE = 0;

            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
                //set session variable
                $scountry = $_POST['SuppliersDirectory']['country'];
                $sregion  = $_POST['SuppliersDirectory']['region'];
                Yii::app()->user->setState("scountry", $scountry);
                Yii::app()->user->setState("sregion", $sregion);

                $mattributes = $model->attributes;
                $uattributes = $umodel->attributes;

                Yii::app()->user->setState("mattributes", $mattributes);
                Yii::app()->user->setState("uattributes", $uattributes);
                Yii::app()->user->setState("secondtab", "2");

                $this->redirect(array('addproducts'));
            }  
        }
        $tab = 1;
        $this->render('create', compact('umodel','model', 'tab'));
    }

    //TAB 2
    public function actionAddproducts() {

        $data_products = array();
            
        // For create form
        $model  = new SuppliersDirectory;
        $umodel = new UserDirectory('frontend');
        
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
        $viewpage = '_section_products_form';
        
        $this->render($viewpage, compact('model', 'tab','data_products'));
    }

    public function actionAddmarques() {
        // Yii::app()->user->setState("marque_ids", null);
        
        
        $sess_product_ids = array();
        $data_products = array();
        
        if (Yii::app()->user->hasState("mattributes")) {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
        }
     
     
        $model = new SuppliersDirectory;
        $umodel = new UserDirectory('frontend');
              
        
        //check if session exists
        if (Yii::app()->user->hasState("mattributes")) {
            //get session variable         
            $model->attributes = $sess_attr_m;
            $sess_attr_u = Yii::app()->user->getState("uattributes");
            $umodel->attributes = $sess_attr_u;
        }
        
       

        // Delete products from session
        if (isset($_POST['yt0'])) {
            
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
      
       $viewpage = '_products_marques_form';
       
       $this->render($viewpage, compact('model', 'tab', 'data_products'));
    }
    
    public function actionPayment()
    {
        $model  = new SuppliersDirectory;
        $umodel = new UserDirectory('frontend');
        
         // Save products in to database        
        if (isset($_POST['yt2'])) 
        {          
            // Session supplier model attribute    
            $sess_attr_m = Yii::app()->user->getState("mattributes");
            // Session user model attribute
            $sess_attr_u = Yii::app()->user->getState("uattributes");
           // Session productids 
            $sess_productids = Yii::app()->user->getState("product_ids");
            // Session marqueids 
            $sess_marqueids = Yii::app()->user->getState("marque_ids");

            if (Yii::app()->user->hasState("mattributes")) {
                $model->attributes = $sess_attr_m;    
                $model->ID_CLIENT  = $sess_attr_m['ID_CLIENT'];
                $model->save(false);              
                $umodel->attributes  = $sess_attr_u;
                $umodel->ID_RELATION = $model->ID_FOURNISSEUR;
                $umodel->save(false);                
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
            // unset Session scountry  
            Yii::app()->user->setState("scountry", null);
            // unset Session sregion  
            Yii::app()->user->setState("sregion", null);

            Yii::app()->user->setFlash('success', 'Informations fournisseur ajouter / jour avec succès!!!');
            $this->redirect(array('index'));
        }
        $tab = 4;
              
       $viewpage = '_payment_form';
       
       $this->render($viewpage, compact('model', 'tab'));
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

            if (isset($_POST['yt0'])) {
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