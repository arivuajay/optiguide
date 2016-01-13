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
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view'),   
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

        $searchModel = new ProfessionalDirectory();
        $searchModel->unsetAttributes();
        $results    = array();
        
        $internalmodel = new InternalMessage;
        
        $rep_id    = Yii::app()->user->id;
        $profil_id = $id;
        $today  = date('Y-m-d');
        
        // Get rep detail
        $rep_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rs.rep_address , NOM_VILLE ,  NOM_REGION_EN , ABREVIATION_EN ,  NOM_PAYS_EN')
                ->from(array('rep_credential_profiles rs', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                ->where("rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND rep_credential_id=$rep_id")
                ->queryRow();

        // Check the professional view today
        $condition2 = " DATE(view_date) ='$today' and rep_credential_id=".$rep_id." and ID_SPECIALISTE=".$profil_id;
        $check_view = RepViewCounts::model()->count($condition2);

        // Get total view counts
        $condition1 = " DATE(view_date) ='$today' and rep_credential_id=".$rep_id;
        $viewcounts = RepViewCounts::model()->count($condition1);

        if($check_view==1)
        {  

        }else  if($viewcounts>=30)
        {
            Yii::app()->user->setFlash('info', Myclass::t("OR618", "", "or"));
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
                ->select('rs.* , ru.ID_UTILISATEUR , ru.NOM_UTILISATEUR , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND  ru.NOM_TABLE ='Professionnels' AND ru.status=1 AND ID_SPECIALISTE=$id")
                ->queryRow();
        
        // Send report change to admin
        if(isset($_POST['ReportSubmit']))
        {
            // Reported by
            $rep_name    = Yii::app()->user->rep_username;
            
            $uname   = $prof_query['PRENOM'].' '.$prof_query['NOM'];
            $reason  =   $_POST['report_reason'];
            $message =  $_POST['report_message'];
            $this->lang = Yii::app()->session['language'];
             /* Send notification mail to admin */
            $mail         = new Sendmail();
            $user_url = ADMIN_URL.'admin/professionalDirectory/update/id/' .$prof_query['ID_SPECIALISTE'];            
            $enc_url = Myclass::refencryption($user_url);
            $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;
            if($this->lang=='EN' ){
                $subject = SITENAME." - ".$rep_name." representative report the user ( ".$uname." )";
            }elseif($this->lang=='FR'){
                $subject =  "Un profil signalé sur le site ".SITENAME;
            }
            $trans_array  = array(
                "{SITENAME}" => SITENAME,
                "{NAME}"     => $uname,
                "{MESSAGE}"  => $message,
                "{REASON}"   => $reason,
                "{NEXTSTEPURL}" => $nextstep_url,
            );
            $message = $mail->getMessage('report_change', $trans_array);
            $mail->send(ADMIN_EMAIL, $subject, $message);
                    
            Yii::app()->user->setFlash('success', Myclass::t("OR619", "", "or"));    
            $this->redirect(array('view', 'id'=>$id));
        }
        
        // Send report change to admin
        if(isset($_POST['NoteSubmit']))
        {
            $message =  nl2br($_POST['message']);
            $alert_date = $_POST['alert_date'];
            
            $notemodel = new RepNotes;
            $notemodel->message = $message;
            $notemodel->alert_date = $alert_date;
            $notemodel->rep_credential_id = $rep_id;
            $notemodel->created_at =  date('Y-m-d H:i');
            $notemodel->ID_UTILISATEUR = $prof_query['ID_UTILISATEUR'];
            $notemodel->save(false);
             
            Yii::app()->user->setFlash('success', Myclass::t("OR620", "", "or"));    
            $this->redirect(array('view', 'id'=>$id));
             
        }

        $this->render('view', array(
            'model' => $prof_query,
            'searchModel' => $searchModel,
            'results' => $results,
            'internalmodel' => $internalmodel,
            'repModel'  => $rep_query  
        ));
    }    
   
    /**
     * Lists all models.
     */
    public function actionIndex() {
        
        $sname_qry = '';
        $scntry_qry = '';
        $sregion_qry = '';
        $scity_qry = '';

        $searchModel = new ProfessionalDirectory();
        $searchModel->unsetAttributes();

        $searchModel->country = isset($searchModel->country) ? $searchModel->country : DEFAULTPAYS;
        $search_country = isset($_GET['ProfessionalDirectory']['country']) ? $_GET['ProfessionalDirectory']['country'] : '';
        if($search_country=='')
        {    
            $scntry_qry = " AND rp.ID_PAYS = " . $searchModel->country; 
        }
        
        if(isset($_GET['listperpage']) && $_GET['listperpage']!='')
        {
          $listperpage = $_GET['listperpage'];
        }else{    
          $listperpage = LISTPERPAGE;
        }        
         
        $searchModel->listperpage = $listperpage;
               
        //$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query        
        $page = Yii::app()->request->getParam('page');
        $page = isset($page) ? $page : 1;
        $limit = 0;

        if ($page > 1) {            
            $offset = $page - 1;
            $limit = $searchModel->listperpage * $offset;
        }

        // $searchModel->unsetAttributes();
        if (isset($_GET['ProfessionalDirectory'])) {

            $searchModel->attributes = $_REQUEST['ProfessionalDirectory'];

            $search_name = isset($_GET['ProfessionalDirectory']['NOM']) ? $_GET['ProfessionalDirectory']['NOM'] : '';
            $search_country = isset($_GET['ProfessionalDirectory']['country']) ? $_GET['ProfessionalDirectory']['country'] : '';
            $search_region = isset($_GET['ProfessionalDirectory']['region']) ? $_GET['ProfessionalDirectory']['region'] : '';
            $search_ville = isset($_GET['ProfessionalDirectory']['ID_VILLE']) ? $_GET['ProfessionalDirectory']['ID_VILLE'] : '';
            $search_type   = isset($_GET['ProfessionalDirectory']['ID_TYPE_SPECIALISTE']) ? $_GET['ProfessionalDirectory']['ID_TYPE_SPECIALISTE'] : '';
            $search_postal   = isset($_GET['ProfessionalDirectory']['CODE_POSTAL'])?$_GET['ProfessionalDirectory']['CODE_POSTAL']:'';

            if ($search_name != '') {
                $searchModel->NOM = $search_name;
                $sname_qry = " AND NOM like '%$search_name%' ";
            }

            $searchModel->country = $search_country;
            if ($search_country != '') {
                $scntry_qry = " AND rp.ID_PAYS = " . $search_country;
            }else
            {
                 $scntry_qry = "";
            }    

                 $searchModel->region = $search_region;
            if ($search_region != '') {               
                $sregion_qry = " AND rr.ID_REGION = " . $search_region;
            }

                $searchModel->ID_VILLE = $search_ville;
            if ($search_ville != '') {                
                $scity_qry = " AND rs.ID_VILLE = " . $search_ville;
            }
            
            if( $search_postal != '')
             {
                 $searchModel->CODE_POSTAL =  $search_postal;
                 $spostal_qry    = " AND rs.CODE_POSTAL = '".$search_postal."'";
             }
            
             if ($search_type != '') {
                $searchModel->ID_TYPE_SPECIALISTE = $search_type;
                $stype_qry = " AND rs.ID_TYPE_SPECIALISTE = " . $search_type;
            }
        }
        
        // Get all records list  with limit
        $prof_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ID_SPECIALISTE , NOM , PRENOM , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' " . $sname_qry . $scntry_qry . $sregion_qry . $scity_qry.$spostal_qry.$stype_qry)
                ->order('rst.TYPE_SPECIALISTE_' . $this->lang . ',NOM')
                ->limit($searchModel->listperpage, $limit) // the trick is here!
                ->queryAll();

        // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' " . $sname_qry . $scntry_qry . $sregion_qry . $scity_qry.$spostal_qry.$stype_qry)
                ->queryScalar(); // do not LIMIT it, this must count all items!
        // the pagination itself
        $pages = new CPagination($item_count);
        $pages->setPageSize($searchModel->listperpage);

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
