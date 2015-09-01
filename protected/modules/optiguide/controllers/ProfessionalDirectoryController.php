<?php

class ProfessionalDirectoryController extends OGController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $lang;

    public function __construct($id, $module = null) {

        if (Yii::app()->session['language']) {
            $lang = Yii::app()->session['language'];
        } else {
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
                'actions' => array('index', 'view', 'update', 'mappingretailers', 'getretailers','listretailers','retailersrequest'),
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
        
        $profil_id = $id;
       
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
                ->select('rs.* , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                ->where("rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ID_SPECIALISTE=$id")
                ->queryRow();

        $this->render('view', array(
            'model' => $prof_query,
            'searchModel' => $searchModel,
            'results' => $results,
        ));
    }
    
    public function actionRetailersrequest()
    {
        $baseurl = Yii::app()->request->getBaseUrl(true); 
        $model   = new RetailersRequest();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));
      
        // Mapping the user to the current professional.
        if (isset($_POST['RetailersRequest'])) {
            
            $encryptval = Yii::app()->user->encryptval;
             
            $retailername   = $_POST['RetailersRequest']['retailername'];
            $retaileremail  = $_POST['RetailersRequest']['retaileremail'];
            $message        = $_POST['RetailersRequest']['message'];
            
            
            /* Send mail to admin for confirmation */
            $mail         = new Sendmail();
            $nextstep_url = $baseurl . '/optiguide/retailerDirectory/create/profid/' .$encryptval;           
            $subject      = Yii::app()->user->name." professional user send request to join in ". SITENAME;
            $trans_array  = array(
                "{SITENAME}" => SITENAME,
                "{NAME}"     => $retailername,
                "{MESSAGE}"  => $message,
                "{NEXTSTEPURL}" => $nextstep_url,
            );
            $message = $mail->getMessage('retailerrequest', $trans_array);
            $mail->send($retaileremail, $subject, $message);
          
          
            Yii::app()->user->setFlash('success', Myclass::t('OGO164', '', 'og'));
            $this->redirect(array('retailersrequest'));
            
        }

        $this->render('retailersrequest', array('model' => $model));
    }        

    public function actionMappingretailers() {
        
        $imp_ret = '';
        $ret_query = '';
        $model = new RetailerDirectory('mapping');
        $profil_id = Yii::app()->user->relationid;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));

        // Mapping the user to the current professional.
        if (isset($_POST['RetailerDirectory'])) {

            $retailers = $_POST['RetailerDirectory']['Retailers2'];

            if (!empty($retailers)) {
                foreach ($retailers as $info) {
                    $mr_model = new MappingRetailers();
                    $mr_model->ID_SPECIALISTE = Yii::app()->user->relationid;
                    $mr_model->ID_RETAILER = $info;
                    $mr_model->save();
                }

                Yii::app()->user->setFlash('success', Myclass::t('OGO150', '', 'og'));
                $this->redirect(array('listretailers'));
            }
        }

        // Get the existing mapping retailers for the current professional.
        $mappingresult = MappingRetailers::model()->findAll("ID_SPECIALISTE=" . $profil_id);
        if (!empty($mappingresult)) {
            foreach ($mappingresult as $info2) {
                $ret_arr[] = $info2->ID_RETAILER;
            }
            $imp_ret = (count($ret_arr) > 1) ? implode(',', $ret_arr) : $ret_arr[0];
            $ret_query = " and rs.ID_RETAILER NOT IN (" . $imp_ret . ") ";
        }

        // Get all records list  with limit
        $results = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ID_RETAILER , COMPAGNIE , NOM_TYPE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' " . $ret_query)
                ->order('COMPAGNIE ASC')
                ->queryAll();

        $this->render('mappingretailers', array('model' => $model, 'results' => $results));
    }

    public function actionListretailers() {
        
        $model = new MappingRetailers();
        $profil_id = Yii::app()->user->relationid;
        $results = array();
        
        if (isset($_POST['btnSubmit'])) 
        {    
            $retailers  = $_POST['retailerid'];
            
            $criteria = new CDbCriteria;
            $criteria->addCondition("ID_SPECIALISTE = ".$profil_id);
            $criteria->addInCondition("ID_RETAILER", $retailers);
            MappingRetailers::model()->deleteAll($criteria);
            
            Yii::app()->user->setFlash('success', Myclass::t('OGO151', '', 'og'));
            $this->redirect(array('listretailers'));
        }    

        $mappingresult = MappingRetailers::model()->findAll("ID_SPECIALISTE=" . $profil_id);

        if (!empty($mappingresult)) {
            foreach ($mappingresult as $info2) {
                $ret_arr[] = $info2->ID_RETAILER;
            }
            $imp_ret = (count($ret_arr) > 1) ? implode(',', $ret_arr) : $ret_arr[0];
            $ret_query = " and rs.ID_RETAILER IN (" . $imp_ret . ") ";

            // Get all records list  with limit
            $results = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('ID_RETAILER , COMPAGNIE , NOM_TYPE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                    ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp' ,'repertoire_utilisateurs as ru'))
                    ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' " . $ret_query)
                    ->order('COMPAGNIE ASC')
                    ->queryAll();
        }

        $this->render('listretailers', array('model' => $model, 'results' => $results));
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {


        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('index'));
        }

        $model = new ProfessionalDirectory;
        $umodel = new UserDirectory('frontend');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['ProfessionalDirectory'])) {
            $model->attributes = $_POST['ProfessionalDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            $model->ID_CLIENT = $umodel->USR;
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
                $mail = new Sendmail();
                $professional_url = ADMIN_URL.'/admin/userDirectory/update/id/'.$umodel->ID_UTILISATEUR;
                $enc_url = Myclass::refencryption($professional_url);
                $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;
                $subject = SITENAME . "- New professional registration notification - " . $model->NOM . " " . $model->PRENOM;
                $trans_array = array(
                    "{NAME}" => $model->NOM,
                    "{UTYPE}" => 'professional',
                    "{NEXTSTEPURL}" => $nextstep_url,
                );
                $message = $mail->getMessage('registration', $trans_array);
                $mail->send(ADMIN_EMAIL, $subject, $message);

                Yii::app()->user->setFlash('success', Myclass::t('OG044', '', 'og'));
                $this->redirect(array('create'));
            } else {
//                echo "<pre>";
//               print_r($model->getErrors());
//                print_r($umodel->getErrors());
//               exit;
            }
        }

        $this->render('create', compact('umodel', 'model'));
    }

    /**
     * update model.    
     */
    public function actionUpdate() {

        $profid = Yii::app()->user->relationid;
        $id = Yii::app()->user->id;
        $model = $this->loadModel($profid);
        $umodel = UserDirectory::model()->findByPk($id);
        $umodel->scenario = 'frontend';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['ProfessionalDirectory'])) {
            $model->attributes = $_POST['ProfessionalDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            $umodel->NOM_UTILISATEUR = $model->PRENOM . " " . $model->NOM;
            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
                $model->save(false);
                $umodel->ID_RELATION = $model->ID_SPECIALISTE;
                $umodel->save(false);

                Yii::app()->user->setFlash('success', Myclass::t('OG036', '', 'og'));
                $this->redirect(array('update'));
            } else {
//               echo "<pre>";
//               print_r($model->getErrors());
//               print_r($umodel->getErrors());
//               exit;
            }
        }
        $this->render('update', compact('umodel', 'model'));
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
