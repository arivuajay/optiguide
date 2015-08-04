<?php

class ProfessionalDirectoryController extends OGController {
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
                'actions' => array('create'),
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
              
        $searchModel = new  ProfessionalDirectory();       
        $searchModel->unsetAttributes();
        
         // Get all records list  with limit
        $prof_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('rs.* , TYPE_SPECIALISTE_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ID_SPECIALISTE=$id")
        ->queryRow();
              
        $this->render('view', array(
            'model' => $prof_query,
            'searchModel' => $searchModel,
        ));
    }
    
    
     /**
     * Lists all models.
     */
    public function actionIndex() {

        $searchModel = new ProfessionalDirectory();                 
    
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
        $scntry_qry  = '';
        $sregion_qry = '';  
        $scity_qry   = '';      
        
        // $searchModel->unsetAttributes();
         if (isset($_GET['ProfessionalDirectory'])) {
             
             $searchModel->attributes = $_REQUEST['ProfessionalDirectory'];
            
             $search_name    = isset($_GET['ProfessionalDirectory']['NOM'])?$_GET['ProfessionalDirectory']['NOM']:'';
             $search_country = isset($_GET['ProfessionalDirectory']['country'])?$_GET['ProfessionalDirectory']['country']:'';
             $search_region  = isset($_GET['ProfessionalDirectory']['region'])?$_GET['ProfessionalDirectory']['region']:'';
             $search_ville   = isset($_GET['ProfessionalDirectory']['ID_VILLE'])?$_GET['ProfessionalDirectory']['ID_VILLE']:'';
             
             if( $search_name != '')
             {
                 $searchModel->NOM =  $search_name;
                 $sname_qry  = " AND NOM like '%$search_name%' ";
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
            
         }
       
       // Get all records list  with limit
        $prof_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('ID_SPECIALISTE , NOM , PRENOM , TYPE_SPECIALISTE_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.'')
        ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS ".$sname_qry.$scntry_qry.$sregion_qry.$scity_qry)
        ->order('rst.TYPE_SPECIALISTE_'.$this->lang.',NOM')
        ->limit( LISTPERPAGE , $limit) // the trick is here!
        ->queryAll();
      
       // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
        ->select('count(*) as count')
        ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp'))
        ->where("rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS ".$sname_qry.$scntry_qry.$sregion_qry.$scity_qry)
        ->queryScalar(); // do not LIMIT it, this must count all items!

        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(LISTPERPAGE);
        
        $result = array();
        foreach ($prof_query as $users) {
             $proftype = $users['TYPE_SPECIALISTE_'.$this->lang.''];            
             $result[$proftype][] = $users;
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ProfessionalDirectory;
        $umodel = new UserDirectory();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['ProfessionalDirectory'])) {
            $model->attributes = $_POST['ProfessionalDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            $model->ID_CLIENT = $umodel->USR;
            $model->COURRIEL  = $umodel->COURRIEL;
            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->PRENOM . " " . $model->NOM;
            $umodel->sGuid = Myclass::getGuid();
            $umodel->LANGUE = Yii::app()->session['language'];
            $umodel->MUST_VALIDATE = 0;

            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {                
                $model->save(false);
                $umodel->ID_RELATION = $model->ID_SPECIALISTE;
                $umodel->save(false);
                
                /* Send mail to admin for confirmation */
                $mail    = new Sendmail();
                $professional_url = ADMIN_URL.'/admin/professionalDirectory/update/id/'.$umodel->ID_RELATION;
                $enc_url          = Myclass::refencryption($professional_url);              
                $nextstep_url     = ADMIN_URL.'admin/default/login/str/'.$enc_url;
                $subject          = SITENAME."- New professional registration notification - ".$model->NOM." ".$model->PRENOM;
                $trans_array = array(
                    "{NAME}"    => $model->NOM,                   
                    "{UTYPE}"   => 'professional',
                    "{NEXTSTEPURL}" => $nextstep_url,
                );
                $message = $mail->getMessage('registration', $trans_array);
                $mail->send(ADMIN_EMAIL, $subject, $message);
                
                Yii::app()->user->setFlash('success', Myclass::t('OG044', '', 'og'));
                $this->redirect(array('create'));
            }else
            {
//                echo "<pre>";
//               print_r($model->getErrors());
//                print_r($umodel->getErrors());
//               exit;
            }    
        }

        $this->render('create', compact('umodel', 'model'));
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
