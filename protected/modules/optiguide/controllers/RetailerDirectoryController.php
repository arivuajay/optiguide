<?php

class RetailerDirectoryController extends OGController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    
    public $lang;
    
    public function __construct($id, $module = null) {     
        
         if(Yii::app()->session['language'])
        {
            $lang = Yii::app()->session['language'];
        }else
        {
            $lang = "EN";
        }
        
        $this->lang = $lang;
      
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
                parent::accessRules(), array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('create', 'getgroups'),
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
    public function actionView($id) {
              
        $searchModel = new  RetailerDirectory();       
        $searchModel->unsetAttributes();
        
         // Get all records list  with limit
        $retail_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('rs.* ,  NOM_TYPE_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ID_RETAILER=$id")
        ->queryRow();
              
        $this->render('view', array(
            'model' => $retail_query,
            'searchModel' => $searchModel,
        ));
    }
    
    
     /**
     * Lists all models.
     */
    public function actionIndex() {

        $searchModel = new RetailerDirectory();                 
    
        $searchModel->country = isset($searchModel->country)?$searchModel->country: DEFAULTPAYS;
        
        //$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query        
        $page  = Yii::app()->request->getParam('page');
        $page  = isset($page) ? $page : 1; 
        $limit = 0;
       
        if($page>1){
         $offset = $page-1;   
         $limit  = LISTPERPAGE * $offset;
        }   
        
        $sname_qry   = '';
        $scat_query  = '';
        $scntry_qry  = '';
        $sregion_qry = '';  
        $scity_qry   = ''; 
        $spostal_qry = '';
        
        
        // $searchModel->unsetAttributes();
         if (isset($_GET['RetailerDirectory'])) {
             
             $searchModel->attributes = $_REQUEST['RetailerDirectory'];
            
             $search_name    = isset($_GET['RetailerDirectory']['COMPAGNIE'])?$_GET['RetailerDirectory']['COMPAGNIE']:'';
             $search_cat     = isset($_GET['RetailerDirectory']['searchcat'])?$_GET['RetailerDirectory']['searchcat']:'';
             $search_country = isset($_GET['RetailerDirectory']['country'])?$_GET['RetailerDirectory']['country']:'';
             $search_region  = isset($_GET['RetailerDirectory']['region'])?$_GET['RetailerDirectory']['region']:'';
             $search_ville   = isset($_GET['RetailerDirectory']['ID_VILLE'])?$_GET['RetailerDirectory']['ID_VILLE']:'';
             $search_postal  = isset($_GET['RetailerDirectory']['CODE_POSTAL'])?$_GET['RetailerDirectory']['CODE_POSTAL']:'';
            
             
             
             if( $search_name != '')
             {
                 $searchModel->COMPAGNIE =  $search_name;
                 $sname_qry  = " AND COMPAGNIE like '%$search_name%' ";
             }  
             
             if( $search_cat != '')
             {    
                $searchModel->searchcat =  $search_cat;
                $scat_query = " AND CATEGORY_$search_cat ";              
             }
             
             if( $search_country != '')
             {
                 $searchModel->country =  $search_country;
                 $scntry_qry  = " AND rp.ID_PAYS = ". $search_country;
             } 
             
              if( $search_region != '')
             {
                 $searchModel->region =  $search_region;
                 $sregion_qry  = " AND rr.ID_REGION = ". $search_region;
             } 
             
             if( $search_ville != '')
             {
                 $searchModel->ID_VILLE =  $search_ville;
                 $scity_qry    = " AND rs.ID_VILLE = ". $search_ville;
             } 
             
             if( $search_postal != '')
             {
                 $searchModel->CODE_POSTAL =  $search_postal;
                 $spostal_qry    = " AND CODE_POSTAL = ". $search_postal;
             }
            
         }
       
       // Get all records list  with limit
        $retail_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('ID_RETAILER , COMPAGNIE , NOM_TYPE_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS ".$sname_qry.$scntry_qry.$sregion_qry.$scity_qry.$scat_query.$spostal_qry)
        ->order('COMPAGNIE')
        ->limit( LISTPERPAGE , $limit) // the trick is here!
        ->queryAll();
      
       // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
        ->select('count(*) as count')
        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS ".$sname_qry.$scntry_qry.$sregion_qry.$scity_qry.$scat_query.$spostal_qry)
        ->queryScalar(); // do not LIMIT it, this must count all items!

        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(LISTPERPAGE);
       
        // render
        $this->render('index',array(
            'searchModel' => $searchModel,
            'model'=>$retail_query,
            'item_count'=>$item_count,
            'page_size'=>LISTPERPAGE,
            'pages'=>$pages,           
           ));
     
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new RetailerDirectory;
        $umodel = new UserDirectory();

        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['RetailerDirectory'])) {
            $model->attributes = $_POST['RetailerDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];

            $model->ID_CLIENT = $umodel->USR;
            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
            $umodel->sGuid = Myclass::getGuid();
            $umodel->LANGUE = Yii::app()->session['language'];
            $umodel->MUST_VALIDATE = 0;

            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
                $model->save(false);
                $umodel->ID_RELATION = $model->ID_RETAILER;
                $umodel->save(false);

                Yii::app()->user->setFlash('success', Myclass::t('OG044', '', 'og'));
                $this->redirect(array('create'));
            } 
        }

        $this->render('create', compact('umodel', 'model'));
    }

    public function actionGetGroups() {
        $options = '';
        $cid = isset($_POST['id']) ? $_POST['id'] : '';
        $options = "<option value=''>".Myclass::t('OG119')."</option>";
        if ($cid != '') {
            $criteria = new CDbCriteria;
            $criteria->order = 'NOM_GROUPE ASC';
            $criteria->condition = 'ID_RETAILER_TYPE=:id';
            $criteria->params = array(':id' => $cid);
            $data_groups = CHtml::listData(RetailerGroup::model()->findAll($criteria), 'ID_GROUPE', 'NOM_GROUPE');
            foreach ($data_groups as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RetailerDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RetailerDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RetailerDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'retailer-directory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
