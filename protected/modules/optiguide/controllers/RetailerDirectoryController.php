<?php

class RetailerDirectoryController extends OGController {

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
                'actions' => array('create', 'getgroups', 'generatelatlong'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'index', 'view'),
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

    public function actionGeneratelatlong() {
        $geo_values = '';
        $address = $_POST['RetailerDirectory']['ADRESSE'];
        $country = $_POST['RetailerDirectory']['country'];
        $region = $_POST['RetailerDirectory']['region'];
        $cty = $_POST['RetailerDirectory']['ID_VILLE'];
        $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
        echo $geo_values;
        exit;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $searchModel = new RetailerDirectory();
        $searchModel->unsetAttributes();

        $retail_id = $id;
        $mappingresult = MappingRetailers::model()->findAll("ID_RETAILER=" . $retail_id);

        if (!empty($mappingresult)) {
            foreach ($mappingresult as $info2) {
                $prof_arr[] = $info2->ID_SPECIALISTE;
            }
            $imp_prof = (count($prof_arr) > 1) ? implode(',', $prof_arr) : $prof_arr[0];
            $prof_query = " and rs.ID_SPECIALISTE IN (" . $imp_prof . ") ";

            // Get all records list  with limit
            $results = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('ID_SPECIALISTE , NOM , PRENOM , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                    ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                    ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' " . $prof_query)
                    ->order('rst.TYPE_SPECIALISTE_' . $this->lang . ',NOM')
                    ->limit(RETAILERSLISTPERPAGE, $limit) // the trick is here!
                    ->queryAll();
        }

        // Get all records list  with limit
        $retail_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rs.* ,  NOM_TYPE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                ->where("rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ID_RETAILER=$id")
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

        $sname_qry = '';
        $scat_query = '';
        $scntry_qry = '';
        $sregion_qry = '';
        $scity_qry = '';
        $spostal_qry = '';

        $searchModel = new RetailerDirectory();
        $searchModel->unsetAttributes();

        $searchModel->country = isset($searchModel->country) ? $searchModel->country : DEFAULTPAYS;
        $scntry_qry = " AND rp.ID_PAYS = " . $searchModel->country;

        //$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query        
        $page = Yii::app()->request->getParam('page');
        $page = isset($page) ? $page : 1;
        $limit = 0;

        if ($page > 1) {
            $offset = $page - 1;
            $limit = RETAILERSLISTPERPAGE * $offset;
        }

        // $searchModel->unsetAttributes();
        if (isset($_GET['RetailerDirectory'])) {

            $searchModel->attributes = $_REQUEST['RetailerDirectory'];

            $search_name = isset($_GET['RetailerDirectory']['COMPAGNIE']) ? $_GET['RetailerDirectory']['COMPAGNIE'] : '';
            $search_cat = isset($_GET['RetailerDirectory']['searchcat']) ? $_GET['RetailerDirectory']['searchcat'] : '';
            $search_country = isset($_GET['RetailerDirectory']['country']) ? $_GET['RetailerDirectory']['country'] : '';
            $search_region = isset($_GET['RetailerDirectory']['region']) ? $_GET['RetailerDirectory']['region'] : '';
            $search_ville = isset($_GET['RetailerDirectory']['ID_VILLE']) ? $_GET['RetailerDirectory']['ID_VILLE'] : '';
            $search_postal = isset($_GET['RetailerDirectory']['CODE_POSTAL']) ? $_GET['RetailerDirectory']['CODE_POSTAL'] : '';
            $search_ret_type = isset($_GET['RetailerDirectory']['ID_RETAILER_TYPE']) ? $_GET['RetailerDirectory']['ID_RETAILER_TYPE'] : '';
            $search_group = isset($_GET['RetailerDirectory']['ID_GROUPE']) ? $_GET['RetailerDirectory']['ID_GROUPE'] : '';


            if ($search_name != '') {
                $searchModel->COMPAGNIE = $search_name;
                $sname_qry = " AND COMPAGNIE like '%$search_name%' ";
            }

            if ($search_cat != '') {
                $searchModel->searchcat = $search_cat;
                $scat_query = " AND CATEGORY_$search_cat ";
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

            if ($search_postal != '') {
                $searchModel->CODE_POSTAL = $search_postal;
                $spostal_qry = " AND CODE_POSTAL = " . $search_postal;
            }

            if ($search_ret_type != '') {
                $searchModel->ID_RETAILER_TYPE = $search_ret_type;
                $srettype_qry = " AND rs.ID_RETAILER_TYPE = " . $search_ret_type;
            }

            if ($search_group != '') {
                $searchModel->ID_GROUPE = $search_group;
                $sgroup_qry = " AND ID_GROUPE = " . $search_group;
            }
        }

        // Get all records list  with limit
        $retail_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ID_RETAILER , COMPAGNIE , NOM_TYPE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' " . $sname_qry . $scntry_qry . $sregion_qry . $scity_qry . $scat_query . $spostal_qry . $srettype_qry . $sgroup_qry)
                ->order('COMPAGNIE')
                ->limit(RETAILERSLISTPERPAGE, $limit) // the trick is here!
                ->queryAll();

        // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' " . $sname_qry . $scntry_qry . $sregion_qry . $scity_qry . $scat_query . $spostal_qry . $srettype_qry . $sgroup_qry)
                ->queryScalar(); // do not LIMIT it, this must count all items!
        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(RETAILERSLISTPERPAGE);

        // render
        $this->render('index', array(
            'searchModel' => $searchModel,
            'model' => $retail_query,
            'item_count' => $item_count,
            'page_size' => RETAILERSLISTPERPAGE,
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

        $model = new RetailerDirectory;
        $umodel = new UserDirectory('frontend');

        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['RetailerDirectory'])) {

            $model->attributes = $_POST['RetailerDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];

           // $model->ID_CLIENT = $umodel->USR;
            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
            $umodel->sGuid = Myclass::getGuid();
            //$umodel->LANGUE = Yii::app()->session['language'];
            $umodel->MUST_VALIDATE = 1;

            $model->image = CUploadedFile::getInstance($model, 'image');

            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
                // save the other city informations and get cityid
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

                $address = $model->ADRESSE;
                $country = $model->country;
                $region = $model->region;
                $cty = $model->ID_VILLE;

                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if ($geo_values != '') {
                    $exp_latlong = explode('~', $geo_values);
                    $model->map_lat = $exp_latlong[0];
                    $model->map_long = $exp_latlong[1];
                }

                // save retailer logo
                if ($model->image) {
                    $imgname = time() . '_' . $model->image->name;
                    $model->FICHIER = $imgname;
                    $ret_img_path = Yii::getPathOfAlias('webroot') . '/' . RET_IMG_PATH . '/';
                    if (!is_dir($ret_img_path)) {
                        mkdir($ret_img_path, 0777, true);
                    }
                    $model->image->saveAs($ret_img_path . $imgname);
                }
                $model->CREATED_DATE = date("Y-m-d");
                $model->save(false);
                $umodel->ID_RELATION = $model->ID_RETAILER;
                $umodel->save(false);

                $this->lang = Yii::app()->session['language'];
                
                
                
                /* Send mail to admin for confirmation */
                $mail = new Sendmail();
                $retailer_url = ADMIN_URL . '/admin/userDirectory/update/id/' . $umodel->ID_UTILISATEUR;
                $enc_url = Myclass::refencryption($retailer_url);
                $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;
                
                if($this->lang=='EN' ){
                    $subject = SITENAME . " - New optical retailer registration notification - " . $model->COMPAGNIE;
                }elseif($this->lang=='FR'){
                    $subject = SITENAME . " - Nouveau profil créé";
                }
                $trans_array = array(
                    "{NAME}" => $model->COMPAGNIE,
                    "{UTYPE}" => 'optical retailer',
                    "{NEXTSTEPURL}" => $nextstep_url,
                );
                $message = $mail->getMessage('registration', $trans_array);
                $mail->send(ADMIN_EMAIL, $subject, $message);

                /* Send activatoin link to the user */
                $mail2 = new Sendmail();
                $confirmation_url = GUIDEURL . '/optiguide/default/confirmation/id/' . $umodel->sGuid;    
                if($this->lang=='EN' ){
                    $subject = SITENAME . " - Subscription confirmation mail";
                }elseif($this->lang=='FR'){
                    $subject = SITENAME . " - Finalisez votre inscription";
                }
                $trans_array = array(
                    "{NAME}" => $model->COMPAGNIE,
                    "{NEXTSTEPURL}" => $confirmation_url,
                );
                $message = $mail2->getMessage('subscription_confirmation', $trans_array);
                $mail2->send($umodel->COURRIEL, $subject, $message);
                
                // mapping the retailer to the reference professional
                $profid = Yii::app()->request->getParam('profid');
                if ($profid != '') {
                    $checkprofessionalexist = UserDirectory::model()->find("sGuid='" . $profid . "'");
                    if (!empty($checkprofessionalexist)) {
                        $professional_id = $checkprofessionalexist->ID_RELATION;
                        $mr_model = new MappingRetailers();
                        $mr_model->ID_SPECIALISTE = $professional_id;
                        $mr_model->ID_RETAILER = $model->ID_RETAILER;
                        $mr_model->affliate = 1;
                        $mr_model->save();
                    }
                }

                Yii::app()->user->setFlash('success', Myclass::t('OG044', '', 'og'));
                $this->redirect(array('create'));
            }
        }

        $this->render('create', compact('umodel', 'model'));
    }

    /**
     * update model.    
     */
    public function actionUpdate() {

        $relid = Yii::app()->user->relationid;
        $id = Yii::app()->user->id;
        $model = $this->loadModel($relid);
        $umodel = UserDirectory::model()->findByPk($id);
        $umodel->scenario = 'frontend';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['RetailerDirectory'])) {
            $model->attributes = $_POST['RetailerDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;

            $model->image = CUploadedFile::getInstance($model, 'image');

            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
                // save the other city informations and get cityid
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

                $address = $model->ADRESSE;
                $country = $model->country;
                $region = $model->region;
                $cty = $model->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if ($geo_values != '') {
                    $exp_latlong = explode('~', $geo_values);
                    $model->map_lat = $exp_latlong[0];
                    $model->map_long = $exp_latlong[1];
                }

                // save retailer logo
                if ($model->image) {
                    $imgname = time() . '_' . $model->image->name;
                    $model->FICHIER = $imgname;
                    $ret_img_path = Yii::getPathOfAlias('webroot') . '/' . RET_IMG_PATH . '/';
                    if (!is_dir($ret_img_path)) {
                        mkdir($ret_img_path, 0777, true);
                    }
                    $model->image->saveAs($ret_img_path . $imgname);
                }

                $model->save(false);
                $umodel->ID_RELATION = $model->ID_RETAILER;
                $umodel->MUST_VALIDATE = 1;
                $umodel->save(false);

                Yii::app()->user->setFlash('success', Myclass::t('OG036', '', 'og'));
                $this->redirect(array('update'));
            }
        }
        $this->render('update', compact('umodel', 'model'));
    }

    public function actionGetGroups() {
        $options = '';
        $cid = isset($_POST['id']) ? $_POST['id'] : '';
        $options = "<option value=''>" . Myclass::t('OG119') . "</option>";
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
