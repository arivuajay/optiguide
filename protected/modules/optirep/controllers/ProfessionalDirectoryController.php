<?php

class ProfessionalDirectoryController extends ORController {
  
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
                'actions' => array(),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view'),
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

        $searchModel = new ProfessionalDirectory();
        $searchModel->unsetAttributes();
        $results    = array();
        
        $rep_id    = Yii::app()->user->id;
        $profil_id = $id;
        $today  = date('Y-m-d');

        // Check the professional view today
        $condition2 = " DATE(view_date) ='$today' and rep_credential_id=".$rep_id." and ID_SPECIALISTE=".$profil_id;
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
            $vmodel->ID_SPECIALISTE    = $profil_id;
             $vmodel->ID_RETAILER      = 0;
            $vmodel->view_date = $today;
            $vmodel->save();
        }    
        
        $mappingresult = MappingRetailers::model()->findAll("ID_SPECIALISTE=" . $profil_id);

        if (!empty($mappingresult)) 
        {
            foreach ($mappingresult as $info2) 
            {
                $ret_arr[] = $info2->ID_RETAILER;
            }
            $imp_ret = (count($ret_arr) > 1) ? implode(',', $ret_arr) : $ret_arr[0];
            $ret_query = " and rs.ID_RETAILER IN (" . $imp_ret . ") ";

            // Get retailers records for this professional
            $results = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('ID_RETAILER , COMPAGNIE , NOM_TYPE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                    ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                    ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' " . $ret_query)
                    ->order('COMPAGNIE ASC')
                    ->queryAll();
        }

        // Get professional detail
        $prof_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rs.* , ru.ID_UTILISATEUR , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Professionnels' AND ID_SPECIALISTE=$id")
                ->queryRow();

        $this->render('view', array(
            'model' => $prof_query,
            'searchModel' => $searchModel,
            'results' => $results,
        ));
    }    
   
    /**
     * Lists all models.
     */
    public function actionIndex() {

        $searchModel = new ProfessionalDirectory();

        $searchModel->country = isset($searchModel->country) ? $searchModel->country : DEFAULTPAYS;

        //$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query        
        $page = Yii::app()->request->getParam('page');
        $page = isset($page) ? $page : 1;
        $limit = 0;

        if ($page > 1) {
            $offset = $page - 1;
            $limit = LISTPERPAGE * $offset;
        }

        $sname_qry = '';
        $scntry_qry = '';
        $sregion_qry = '';
        $scity_qry = '';

        // $searchModel->unsetAttributes();
        if (isset($_GET['ProfessionalDirectory'])) {

            $searchModel->attributes = $_REQUEST['ProfessionalDirectory'];

            $search_name = isset($_GET['ProfessionalDirectory']['NOM']) ? $_GET['ProfessionalDirectory']['NOM'] : '';
            $search_country = isset($_GET['ProfessionalDirectory']['country']) ? $_GET['ProfessionalDirectory']['country'] : '';
            $search_region = isset($_GET['ProfessionalDirectory']['region']) ? $_GET['ProfessionalDirectory']['region'] : '';
            $search_ville = isset($_GET['ProfessionalDirectory']['ID_VILLE']) ? $_GET['ProfessionalDirectory']['ID_VILLE'] : '';

            if ($search_name != '') {
                $searchModel->NOM = $search_name;
                $sname_qry = " AND NOM like '%$search_name%' ";
            }

            if ($search_country != '') {
                $searchModel->country = $search_country;
                $scntry_qry = " AND rp.ID_PAYS = " . $search_country;
            }

            if ($search_region != '') {
                $searchModel->region = $search_region;
                $sregion_qry = " AND rr.ID_REGION = " . $search_region;
            }

            if ($search_ville != '') {
                $searchModel->ID_VILLE = $search_ville;
                $scity_qry = " AND rs.ID_VILLE = " . $search_ville;
            }
        }

        // Get all records list  with limit
        $prof_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ID_SPECIALISTE , NOM , PRENOM , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' " . $sname_qry . $scntry_qry . $sregion_qry . $scity_qry)
                ->order('rst.TYPE_SPECIALISTE_' . $this->lang . ',NOM')
                ->limit(LISTPERPAGE, $limit) // the trick is here!
                ->queryAll();

        // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' " . $sname_qry . $scntry_qry . $sregion_qry . $scity_qry)
                ->queryScalar(); // do not LIMIT it, this must count all items!
        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(LISTPERPAGE);

        $result = array();
        foreach ($prof_query as $users) {
            $proftype = $users['TYPE_SPECIALISTE_' . $this->lang . ''];
            $result[$proftype][] = $users;
        }

        // render
        $this->render('index', array(
            'searchModel' => $searchModel,
            'model' => $result,
            'item_count' => $item_count,
            'page_size' => LISTPERPAGE,
            'pages' => $pages,
        ));
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProfessionalDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProfessionalDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProfessionalDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'professional-directory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
