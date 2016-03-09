<?php

class MarqueDirectoryController extends ORController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
  
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
                        'actions' => array('index','view','suppliers'),
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

        //this query contains supplier informations
        $supplier_query = Yii::app()->db->createCommand() 
        ->select('f.* , af.ID_CATEGORIE , af.FICHIER , af.EXTENSION ,  TYPE_FOURNISSEUR_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft', 'archive_fichier af' ,'repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.iId_fichier=af.ID_FICHIER AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 and ID_FOURNISSEUR=".$id)
        ->queryRow();

        $sectionqry = '';
        $productqry = '';
        $searchModel = new  SuppliersDirectory();  
        if($sectionid !='')
        {
            $searchModel->ID_SECTION = $sectionid;
            $sectionqry = " AND rp.ID_SECTION = ".$sectionid;
            if($productid!='')
            {    
               $searchModel->PROD_SERVICE = $productid;
               $productqry = " AND rp.ID_PRODUIT = ".$productid;
            }                     
        }  

        //this query contains get all products with marques list for the supplier
        $products_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('rp.ID_PRODUIT , rm.ID_MARQUE , rp.NOM_PRODUIT_'.$this->lang.' , rm.NOM_MARQUE')
        ->from(array('repertoire_fournisseur_produit rfp','repertoire_produit_marque rpm','repertoire_produit AS rp' ,  'repertoire_marque AS rm'))
        ->where("rfp.ID_LIEN_PRODUIT_MARQUE = rpm.ID_LIEN_MARQUE AND rpm.ID_PRODUIT = rp.ID_PRODUIT AND rpm.ID_MARQUE = rm.ID_MARQUE AND rfp.ID_FOURNISSEUR =".$id.$sectionqry.$productqry)
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
     * Lists all brands.
     */
    public function actionIndex() {

        $searchModel = new MarqueDirectory();      
         
        $page  = Yii::app()->request->getParam('page');
        $page  = isset($page) ? $page : 1; 
        $limit = 0;
       
        if($page>1){
         $offset = $page-1;   
         $limit  = LISTPERPAGE * $offset;
        }   
        
               
        $infoarr      = array();
        $supplierids  = array();
         $sname_qry   = '';
        $section_qry  = '';
        $products_qry = '';
        
        // $searchModel->unsetAttributes();
         if (isset($_GET['MarqueDirectory'])) {
             
            $searchModel->attributes = $_REQUEST['MarqueDirectory'];

            $search_name    = isset($_GET['MarqueDirectory']['NOM_MARQUE'])?$_GET['MarqueDirectory']['NOM_MARQUE']:'';

            /* Sections and Products */
            $search_section = isset($_GET['MarqueDirectory']['ID_SECTION'])?$_GET['MarqueDirectory']['ID_SECTION']:''; 
            $search_product = isset($_GET['MarqueDirectory']['PROD_SERVICE'])?$_GET['MarqueDirectory']['PROD_SERVICE']:''; 

            if( $search_name != '')
            {
               $searchModel->NOM_MARQUE =  $search_name;
               $_findword = addslashes($search_name);
               $sname_qry  = " AND NOM_MARQUE like '%$_findword%' ";
            } 
             
            if($search_section!='')
            {                   
                $section_qry = " AND rp.ID_SECTION = ".$search_section;
                if($search_product!='')
                {
                   $products_qry = " AND rp.ID_PRODUIT = ".$search_product;
                }  
            }    
            
         }
       
       // Get all records list  with limit
        $marque_result = Yii::app()->db->createCommand() //this query contains all the data
        ->select('rm.ID_MARQUE,NOM_MARQUE')
        ->from(array('repertoire_marque rm', 'repertoire_produit rp', 'repertoire_produit_marque rpm' , 'repertoire_fournisseur_produit rfp' , 'repertoire_fournisseurs f'))
        ->where("rpm.ID_PRODUIT=rp.ID_PRODUIT AND rpm.ID_MARQUE=rm.ID_MARQUE AND rfp.ID_LIEN_PRODUIT_MARQUE=rpm.ID_LIEN_MARQUE AND rfp.ID_FOURNISSEUR=f.ID_FOURNISSEUR AND f.bAfficher_site=1".$sname_qry.$section_qry.$products_qry)
        ->group("rpm.ID_MARQUE")        
        ->order('NOM_MARQUE')                
        ->limit( LISTPERPAGE , $limit) // the trick is here!
        ->queryAll();
         
      //Get total counts
        $connection = Yii::app()->db;
        $qry_total_marques = $connection->createCommand("SELECT COUNT(ID_MARQUE) as marcnt FROM  `repertoire_marque` a , (SELECT rpm.ID_MARQUE AS marid
        FROM  `repertoire_marque` `rm`, `repertoire_produit` `rp`, `repertoire_produit_marque` `rpm` , repertoire_fournisseur_produit AS rfp , repertoire_fournisseurs AS f
        WHERE rpm.ID_PRODUIT=rp.ID_PRODUIT AND rpm.ID_MARQUE=rm.ID_MARQUE AND rfp.ID_LIEN_PRODUIT_MARQUE=rpm.ID_LIEN_MARQUE AND rfp.ID_FOURNISSEUR=f.ID_FOURNISSEUR AND f.bAfficher_site=1 ".$sname_qry.$section_qry.$products_qry."
        GROUP BY rpm.ID_MARQUE) AS ab WHERE ab.marid=a.ID_MARQUE");
        $res_marqs  = $qry_total_marques->queryRow();
        $item_count = $res_marqs['marcnt'];      
        
        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(LISTPERPAGE);
         
        // render
        $this->render('index',array(
            'searchModel' => $searchModel,
            'model'=>$marque_result,
            'item_count'=>$item_count,
            'page_size'=>LISTPERPAGE,
            'pages'=>$pages,             
       ));    
    
    }
    
     /**
     * Lists all suppliers for the brand.
     */
    public function actionSuppliers() {

        $searchModel = new MarqueDirectory();      
         
        $page  = Yii::app()->request->getParam('page');
        $page  = isset($page) ? $page : 1; 
        $limit = 0;
       
        if($page>1){
         $offset = $page-1;   
         $limit  = LISTPERPAGE * $offset;
        }  
        
        $search_marque   = Yii::app()->request->getParam('marqueid');
        $search_section  = Yii::app()->request->getParam('sectionid');
        $search_product  = Yii::app()->request->getParam('productid');        
    
        
                         
            // Get productmarques ids based on products and sections
            $criteria = new CDbCriteria;                        
            $criteria->with = array("productMarqueDirectory"=>array("select"=>"ID_LIEN_MARQUE"));
            if($search_section!='')
            {  
                $criteria->condition = 'ID_SECTION=:sid';
                $criteria->params = array(':sid' => $search_section);
                $searchModel->ID_SECTION = $search_section;
            }    
            if($search_product!='')
            {    
                $criteria->condition = 't.ID_PRODUIT=:pid';
                $criteria->params = array(':pid' => $search_product);
                $searchModel->PROD_SERVICE = $search_product;
            }  
            if($search_marque!='')
            {    
                $criteria->condition = 'productMarqueDirectory.ID_MARQUE=:mid';
                $criteria->params = array(':mid' => $search_marque);
                $searchModel->ID_MARQUE = $search_marque;
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

        
        // Get all records list  with limit
        $supplier_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('ID_FOURNISSEUR , COMPAGNIE , TYPE_FOURNISSEUR_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 ".$sname_qry.$section_product_qry)
        ->order('ft.TYPE_FOURNISSEUR_'.$this->lang.',COMPAGNIE')
        ->limit( LISTPERPAGE , $limit) // the trick is here!
        ->queryAll();
      
       // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
        ->select('count(*) as count')
        ->from(array('repertoire_fournisseurs f','repertoire_fournisseur_type ft','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 ".$sname_qry.$section_product_qry)
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
        $this->render('suppliers',array(
            'searchModel' => $searchModel,
            'model'=>$result,
            'item_count'=>$item_count,
            'page_size'=>LISTPERPAGE,
            'pages'=>$pages,             
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