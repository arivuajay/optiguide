<?php

class RetailerDirectoryController extends ORController {
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
                parent::accessRules(), array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view','getgroups'),  
                'users' => array('@'),
                'expression' => 'Yii::app()->user->rep_role!="admin"'
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
                        
        $rep_id    = Yii::app()->user->id;
        $retail_id = $id;
        $today  = date('Y-m-d');

        // Check the professional view today
        $condition2 = " DATE(view_date) ='$today' and rep_credential_id=".$rep_id." and ID_RETAILER=".$retail_id;
        $check_view = RepViewCounts::model()->count($condition2);

        // Get total view counts
        $condition1 = " DATE(view_date) ='$today' and rep_credential_id=".$rep_id;
        $viewcounts = RepViewCounts::model()->count($condition1);

        if($check_view==1)
        {  

        }else  if($viewcounts>=50)
        {
            Yii::app()->user->setFlash('info', 'Maximum 50 users ( professionals / retailers ) only able to view per day. Your limits are reached today!!');
            $this->redirect(array('index'));
        }         
        // Add the view count
        if($check_view==0)
        {    
            $vmodel=new RepViewCounts;
            $vmodel->rep_credential_id = Yii::app()->user->id;
            $vmodel->ID_SPECIALISTE    = 0;
             $vmodel->ID_RETAILER      = $retail_id;
            $vmodel->view_date = $today;
            $vmodel->save();
        }    
        
        
        $mappingresult = MappingRetailers::model()->findAll("ID_RETAILER=" . $retail_id);

        if (!empty($mappingresult)) 
        {
            foreach ($mappingresult as $info2) 
            {
                $prof_arr[] = $info2->ID_SPECIALISTE;
            }
            $imp_prof = (count($prof_arr) > 1) ? implode(',', $prof_arr) : $prof_arr[0];
            $prof_query = " and rs.ID_SPECIALISTE IN (" . $imp_prof . ") ";

            // Get all records list  with limit
            $results = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ID_SPECIALISTE , NOM , PRENOM , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp' ,'repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' " .$prof_query)
                ->order('rst.TYPE_SPECIALISTE_' . $this->lang . ',NOM')
                ->limit(LISTPERPAGE, $limit) // the trick is here!
                ->queryAll();
        }
        
         // Get all records list  with limit
        $retail_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('rs.* , ru.ID_UTILISATEUR  ,  NOM_TYPE_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp','repertoire_utilisateurs as ru'))
        ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ID_RETAILER=$id")
        ->queryRow();
              
        $this->render('view', array(
            'model' => $retail_query,
            'searchModel' => $searchModel,
            'results' => $results
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
        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp','repertoire_utilisateurs as ru'))
        ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' ".$sname_qry.$scntry_qry.$sregion_qry.$scity_qry.$scat_query.$spostal_qry)
        ->order('COMPAGNIE')
        ->limit( LISTPERPAGE , $limit) // the trick is here!
        ->queryAll();
      
       // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
        ->select('count(*) as count')
        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp','repertoire_utilisateurs as ru'))
        ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' ".$sname_qry.$scntry_qry.$sregion_qry.$scity_qry.$scat_query.$spostal_qry)
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
    
    public function actionupdatefav()
    {
        $rep_id     = Yii::app()->user->id;
        $retailerid = isset($_POST['id']) ? $_POST['id'] : '';        
        $favstatus  = isset($_POST['favstatus']) ? $_POST['favstatus'] : '';
        
        if($favstatus!='' && $retailerid!='' && $rep_id!='')
        {
            if($favstatus=="removefav")
            {
                $criteria = new CDbCriteria;
                $criteria->condition = 'rep_credential_id=:repid and ID_RETAILER= :retid'; 
                $criteria->params = array(":repid" => $rep_id, ":retid" => $retailerid);
                $favourites = RepFavourites::model()->find($criteria);
                $favourites->delete();
            }  else {
               $favourites = new RepFavourites;
               $favourites->rep_credential_id = $rep_id;
               $favourites->ID_RETAILER  = $retailerid;
               $favourites->save();
            }    
        }    
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
