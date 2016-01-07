<?php

class SuppliersDirectoryController extends OGController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $lang;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        $this->lang = Yii::app()->session['language'];
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
                'actions' => array('renewalmail', 'detect_supplier', 'create', 'index', 'view', 'category', 'addproducts', 'addmarques', 'getproducts', 'listmarques', 'payment', 'paypaltest', 'paypalreturn', 'paypalcancel', 'paypalnotify', 'renewpaypalnotify', 'delproducts'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'updateproducts', 'updatemarques', 'updatelogo', 'transactions', 'mappingreps', 'listreps', 'renewsubscription', 'renewpaypalreturn', 'renewpaypalcancel', 'renewpaypalnotify'),
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

    public function actionRenewalmail() {
        $baseurl = Yii::app()->request->getBaseUrl(true);
        $ret_result = Yii::app()->db->createCommand(
                        "SELECT f.profile_expirydate AS expirydate , ru.COURRIEL AS email ,ru.NOM_UTILISATEUR AS username,f.renewal_flag AS flag, f.ID_FOURNISSEUR AS s_id, ru.ID_UTILISATEUR AS u_id, f.COMPAGNIE AS COMPAGNIE
                FROM repertoire_fournisseurs f, repertoire_utilisateurs as ru
                WHERE f.ID_FOURNISSEUR = ru.ID_RELATION AND ru.status = 1 AND ru.NOM_TABLE = 'Fournisseurs' AND f.profile_expirydate != '0000-00-00 00:00:00' AND ru.COURRIEL != '' 
                ")->queryAll();
        $flag = 0;
        foreach ($ret_result as $single_record) {
            $difference = strtotime($single_record['expirydate']) - strtotime(date("Y-m-d H:m:s"));
            $days = floor($difference / (60 * 60 * 24));
            if ($days == 90 && $single_record['flag'] != 1) {
                $single_record['flag'] = 1;
                $flag = 1;
            } elseif ($days == 30 && $single_record['flag'] != 2) {
                $single_record['flag'] = 2;
                $flag = 1;
            } elseif ($days == 7 && $single_record['flag'] != 3) {
                $single_record['flag'] = 3;
                $flag = 1;
            }
            if ($flag != 0) {
                $sql = "UPDATE repertoire_fournisseurs SET renewal_flag=:flag WHERE ID_FOURNISSEUR=:supplier_id";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":supplier_id", $single_record['s_id']);
                $command->bindParam(":flag", $single_record['flag']);
                $command->execute();

                $this->lang = Yii::app()->session['language'];
                $mail = new Sendmail;
                $nextstep_url = $baseurl . '/optiguide/suppliersDirectory/renewsubscription';
                if($this->lang=='EN' ){
                    $Subject = SITENAME . " - Account expiry reminder";
                }elseif($this->lang=='FR'){
                    $Subject = SITENAME . " - Votre abonnement tire à sa fin";
                }
                $trans_array = array(
                    "{NEXTSTEPURL}" => $nextstep_url,
                    "{RENEWALDAY}" => date("d-m-Y", strtotime($single_record['expirydate'])),
                    "{USERNAME}" => $single_record['username'],
                );
                $message = $mail->getMessage('renewal_mail', $trans_array);
                $mail->send($single_record['email'], $Subject, $message);
            }
            $flag = 0;
        }
    }

    public function actionMappingreps() {

        $imp_ret = '';
        $ret_query = '';
        $model = new RepCredentials('mapping');
        $supp_id = Yii::app()->user->relationid;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));

        // Mapping the user to the current professional.
        if (isset($_POST['RepCredentials'])) {

            $reps = $_POST['RepCredentials']['Reps2'];

            if (!empty($reps)) {

                foreach ($reps as $info) {
                    $mr_model = new MappingReps();
                    $mr_model->ID_FOURNISSEUR = $supp_id;
                    $mr_model->rep_credential_id = $info;
                    $mr_model->save();
                }

                Yii::app()->user->setFlash('success', Myclass::t('OGO170', '', 'og'));
                $this->redirect(array('listreps'));
            }
        }

        // Get the existing mapping reps for the current supplier.
        $rep_query = '';
        $mappingresult = MappingReps::model()->findAll("ID_FOURNISSEUR =" . $supp_id);
        if (!empty($mappingresult)) {

            foreach ($mappingresult as $info2) {
                $rep_arr[] = $info2->rep_credential_id;
            }
            $imp_rep = (count($rep_arr) > 1) ? implode(',', $rep_arr) : $rep_arr[0];
            $rep_query = " and rc.rep_credential_id NOT IN (" . $imp_rep . ") ";
        }

        // Get all records list  with limit
        $results = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rc.rep_credential_id , rc.rep_username, NOM_VILLE ,  NOM_REGION_EN , ABREVIATION_EN ,  NOM_PAYS_EN')
                ->from(array('rep_credentials rc', 'rep_credential_profiles rcf', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                ->where("rc.rep_credential_id=rcf.rep_credential_id AND rcf.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and rc.rep_status='1' and rep_role='single' " . $rep_query)
                ->order('rc.rep_username ASC')
                ->queryAll();


        $this->render('mappingreps', array('model' => $model, 'results' => $results));
    }

    public function actionListreps() {

        $model = new MappingReps();
        $supp_id = Yii::app()->user->relationid;
        $results = array();

        if (isset($_POST['btnSubmit'])) {
            $reps = $_POST['repid'];

            $criteria = new CDbCriteria;
            $criteria->addCondition("ID_FOURNISSEUR = " . $supp_id);
            $criteria->addInCondition("rep_credential_id", $reps);
            MappingReps::model()->deleteAll($criteria);

            Yii::app()->user->setFlash('success', Myclass::t('OGO180', '', 'og'));
            $this->redirect(array('listreps'));
        }

        $mappingresult = MappingReps::model()->findAll("ID_FOURNISSEUR = " . $supp_id);

        if (!empty($mappingresult)) {
            foreach ($mappingresult as $info2) {
                $rep_arr[] = $info2->rep_credential_id;
            }

            $imp_rep = (count($rep_arr) > 1) ? implode(',', $rep_arr) : $rep_arr[0];
            $rep_query = " and rc.rep_credential_id IN (" . $imp_rep . ") ";

            // Get all records list  with limit
            $results = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('rc.rep_credential_id , rc.rep_username, NOM_VILLE ,  NOM_REGION_EN , ABREVIATION_EN ,  NOM_PAYS_EN')
                    ->from(array('rep_credentials rc', 'rep_credential_profiles rcf', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                    ->where("rc.rep_credential_id=rcf.rep_credential_id AND rcf.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and rc.rep_status='1' and rep_role='single' " . $rep_query)
                    ->order('rc.rep_username ASC')
                    ->queryAll();
        }

        $this->render('listreps', array('model' => $model, 'results' => $results));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView() {

        $id = Yii::app()->request->getParam('id');
        $sectionid = Yii::app()->request->getParam('sectionid');
        $productid = Yii::app()->request->getParam('productid');
        $marqueid = Yii::app()->request->getParam('marqueid');


        // Get the list of corresponding representatives to the supplier
        $results = array();
        $supp_id = $id;
        $mappingresult = MappingReps::model()->findAll("ID_FOURNISSEUR=" . $supp_id);
        if (!empty($mappingresult)) {
            foreach ($mappingresult as $info2) {
                $rep_arr[] = $info2->rep_credential_id;
            }
            $imp_rep = (count($rep_arr) > 1) ? implode(',', $rep_arr) : $rep_arr[0];
            $rep_query = "  and rc.rep_credential_id IN (" . $imp_rep . ") ";

            // Get all records list  with limit
            $results = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('rc.rep_credential_id , rc.rep_username, NOM_VILLE ,  NOM_REGION_EN , ABREVIATION_EN ,  NOM_PAYS_EN')
                    ->from(array('rep_credentials rc', 'rep_credential_profiles rcf', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                    ->where("rc.rep_credential_id=rcf.rep_credential_id AND rcf.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and rc.rep_status='1' and rep_role='single' " . $rep_query)
                    ->order('rc.rep_username ASC')
                    ->queryAll();
        }


        //this query contains supplier informations
        $supplier_query = Yii::app()->db->createCommand()
                ->select('f.* , af.ID_CATEGORIE , af.FICHIER , af.EXTENSION ,  TYPE_FOURNISSEUR_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'archive_fichier af', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.iId_fichier=af.ID_FICHIER AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 and ID_FOURNISSEUR=" . $id)
                ->queryRow();

        $sectionqry = '';
        $productqry = '';
        $marqueqry = '';
        $searchModel = new SuppliersDirectory();

        if ($sectionid != '') {
            $searchModel->ID_SECTION = $sectionid;
            $sectionqry = " AND rp.ID_SECTION = " . $sectionid;
        }
        if ($productid != '') {
            $searchModel->PROD_SERVICE = $productid;
            $productqry = " AND rp.ID_PRODUIT = " . $productid;
        }

        if ($marqueid != '') {
            $marqueqry = " AND rpm.ID_MARQUE = " . $marqueid;
        }

        //this query contains get all products with marques list for the supplier
        $products_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rp.ID_PRODUIT , rm.ID_MARQUE , rp.NOM_PRODUIT_' . $this->lang . ' , rm.NOM_MARQUE')
                ->from(array('repertoire_fournisseur_produit rfp', 'repertoire_produit_marque rpm', 'repertoire_produit AS rp', 'repertoire_marque AS rm'))
                ->where("rfp.ID_LIEN_PRODUIT_MARQUE = rpm.ID_LIEN_MARQUE AND rpm.ID_PRODUIT = rp.ID_PRODUIT AND rpm.ID_MARQUE = rm.ID_MARQUE AND rm.ID_MARQUE != 0 AND rfp.ID_FOURNISSEUR =" . $id . $sectionqry . $productqry . $marqueqry)
                ->order('rp.NOM_PRODUIT_' . $this->lang . ',rm.NOM_MARQUE')
                ->queryAll();


        $result = array();
        foreach ($products_query as $infos) {
            $pid = $infos['ID_PRODUIT'];
            $prod = $pid . '~' . $infos['NOM_PRODUIT_' . $this->lang . ''];
            $result[$prod][] = $infos;
        }

        $this->render('view', array(
            'model' => $supplier_query,
            'searchModel' => $searchModel,
            'supplierproducts' => $result,
            'results' => $results,
        ));
    }

    /**
     * Lists all products based on the section
     */
    public function actionGetproducts() {
        $options = '';
        $sid = isset($_POST['id']) ? $_POST['id'] : '';
        $options = "<option value=''>" . Myclass::t('OG206') . "</option>";
        if ($sid != '') {
            $criteria = new CDbCriteria;
            $criteria->order = 'NOM_PRODUIT_' . $this->lang . ' ASC';
            $criteria->condition = 'ID_SECTION=:id';
            $criteria->params = array(':id' => $sid);
            $data_products = CHtml::listData(ProductDirectory::model()->findAll($criteria), 'ID_PRODUIT', 'NOM_PRODUIT_' . $this->lang);
            foreach ($data_products as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    public function actionDetect_supplier() {

        // Get all records list  with limit
        $supplier_query1 = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ID_FOURNISSEUR')
                ->from(array('repertoire_fournisseurs f'))
                ->order('ID_FOURNISSEUR ASC')
                ->queryAll();

        foreach ($supplier_query1 as $finfo1) {
            $sup_id = $finfo1['ID_FOURNISSEUR'];

            $supplier_query2 = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('ru.ID_UTILISATEUR AS UID , ru.ID_RELATION,  f.ID_FOURNISSEUR')
                    ->from(array('repertoire_fournisseurs f', 'repertoire_utilisateurs ru'))
                    ->where("f.ID_FOURNISSEUR = ru.ID_RELATION AND ru.NOM_TABLE='Fournisseurs' and ru.ID_RELATION=" . $sup_id)
                    ->order('ru.ID_RELATION , UID ASC')
                    ->queryAll();
            $k = 0;
            foreach ($supplier_query2 as $finfo2) {
                if ($k == 0) {
                    $uid = $finfo2['UID'];
                    $model = UserDirectory::model()->findByPk($uid);
                    $model->status = 1;
                    $model->save();
                }
                $k++;
            }
        }
        exit;
    }

    /**
     * Lists all suppliers.
     */
    public function actionIndex() {

        $searchModel = new SuppliersDirectory();

        $page = Yii::app()->request->getParam('page');
        $page = isset($page) ? $page : 1;
        $limit = 0;

        if ($page > 1) {
            $offset = $page - 1;
            $limit = SUPPLIERSLISTPERPAGE * $offset;
        }

        $sname_qry = '';
        $stype_qry = '';
        $section_product_qry = '';
        $infoarr = array();
        $supplierids = array();

        // $searchModel->unsetAttributes();
        if (isset($_GET['SuppliersDirectory'])) {

            $searchModel->attributes = $_REQUEST['SuppliersDirectory'];

            $search_name = isset($_GET['SuppliersDirectory']['COMPAGNIE']) ? $_GET['SuppliersDirectory']['COMPAGNIE'] : '';
            $search_type = isset($_GET['SuppliersDirectory']['ID_TYPE_FOURNISSEUR']) ? $_GET['SuppliersDirectory']['ID_TYPE_FOURNISSEUR'] : '';

            /* Sections and Products */
            $search_section = isset($_GET['SuppliersDirectory']['ID_SECTION']) ? $_GET['SuppliersDirectory']['ID_SECTION'] : '';
            $search_product = isset($_GET['SuppliersDirectory']['PROD_SERVICE']) ? $_GET['SuppliersDirectory']['PROD_SERVICE'] : '';

            if ($search_name != '') {
                $searchModel->COMPAGNIE = $search_name;
                $sname_qry = " AND COMPAGNIE like '%$search_name%' ";
            }

            if ($search_type != '') {
                $searchModel->ID_TYPE_FOURNISSEUR = $search_type;
                $stype_qry = " AND f.ID_TYPE_FOURNISSEUR = $search_type";
            }

            if ($search_section != '') {
                // Get productmarques ids based on products and sections
                $criteria = new CDbCriteria;
                $criteria->with = array("productMarqueDirectory" => array("select" => "ID_LIEN_MARQUE"));
                $criteria->condition = 'ID_SECTION=:id';
                $criteria->params = array(':id' => $search_section);
                if ($search_product != '') {
                    $criteria->condition = 't.ID_PRODUIT=:pid';
                    $criteria->params = array(':pid' => $search_product);
                }
                $data_products_marques = ProductDirectory::model()->findAll($criteria);

                foreach ($data_products_marques as $infos) {
                    foreach ($infos['productMarqueDirectory'] as $info2) {
                        $infoarr[] = $info2['ID_LIEN_MARQUE'];
                    }
                }

                if (!empty($infoarr)) {
                    // Get supplierids related to the productmarques   
                    $criteria = new CDbCriteria;
                    $criteria->addInCondition('ID_LIEN_PRODUIT_MARQUE', $infoarr);
                    $criteria->group = 'ID_FOURNISSEUR';
                    $data_suppliers = SupplierProducts::model()->findAll($criteria);

                    foreach ($data_suppliers as $infos3) {
                        $supplierids[] = $infos3['ID_FOURNISSEUR'];
                    }
                }

                if (!empty($supplierids)) {
                    $imp_suppids = (count($supplierids) > 1) ? implode(',', $supplierids) : $supplierids[0];
                    $section_product_qry = " AND f.ID_FOURNISSEUR IN (" . $imp_suppids . ") ";
                }
            }
        }

        // Get all records list  with limit
        $today_date = date("Y-m-d ");
        $supplier_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select("DATEDIFF(profile_expirydate,'$today_date') AS expiredays,
                          (CASE WHEN (DATEDIFF(profile_expirydate,'$today_date') IS NULL || DATEDIFF(profile_expirydate,'$today_date') <= 0 ) 
                          THEN '2'
                          ELSE '1'
                          END) AS expiry_status,ID_FOURNISSEUR , COMPAGNIE ,profile_expirydate , TYPE_FOURNISSEUR_" . $this->lang . " ,  NOM_VILLE ,  NOM_REGION_" . $this->lang . " , ABREVIATION_" . $this->lang . ",  NOM_PAYS_" . $this->lang)
                ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("f.ID_FOURNISSEUR=ru.ID_RELATION AND f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 AND ru.NOM_TABLE ='Fournisseurs' and ru.status=1 " . $sname_qry . $stype_qry . $section_product_qry)
                ->order('ft.TYPE_FOURNISSEUR_' . $this->lang . ' ASC , expiry_status ASC,COMPAGNIE ASC')
                ->limit(SUPPLIERSLISTPERPAGE, $limit) // the trick is here!
                ->queryAll();

        // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("f.ID_FOURNISSEUR=ru.ID_RELATION AND f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 AND ru.NOM_TABLE ='Fournisseurs' and ru.status=1 " . $sname_qry . $stype_qry . $section_product_qry)
                ->queryScalar(); // do not LIMIT it, this must count all items!
        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(SUPPLIERSLISTPERPAGE);

        $result = array();
        foreach ($supplier_query as $users) {
            $supptype = $users['TYPE_FOURNISSEUR_' . $this->lang . ''];
            $result[$supptype][] = $users;
        }

        // render
        $this->render('index', array(
            'searchModel' => $searchModel,
            'model' => $result,
            'item_count' => $item_count,
            'page_size' => SUPPLIERSLISTPERPAGE,
            'pages' => $pages,
        ));
    }

    /**
     * Lists all suppliers based category.
     */
    public function actionCategory() {

        $searchModel = new SuppliersDirectory();

        $page = Yii::app()->request->getParam('page');
        $page = isset($page) ? $page : 1;
        $limit = 0;

        if ($page > 1) {
            $offset = $page - 1;
            $limit = CATEGORIESLISTPERPAGE * $offset;
        }

        $section_product_qry = '';
        $infoarr = array();
        $supplierids = array();

        // $searchModel->unsetAttributes();
        if (isset($_GET['SuppliersDirectory'])) {

            $searchModel->attributes = $_REQUEST['SuppliersDirectory'];

            /* Sections and Products */
            $search_section = isset($_GET['SuppliersDirectory']['ID_SECTION']) ? $_GET['SuppliersDirectory']['ID_SECTION'] : '';
            $search_product = isset($_GET['SuppliersDirectory']['PROD_SERVICE']) ? $_GET['SuppliersDirectory']['PROD_SERVICE'] : '';


            if ($search_section != '') {
                // Get productmarques ids based on products and sections
                $criteria = new CDbCriteria;
                $criteria->with = array("productMarqueDirectory" => array("select" => "ID_LIEN_MARQUE"));
                $criteria->condition = 'ID_SECTION=:id';
                $criteria->params = array(':id' => $search_section);
                if ($search_product != '') {
                    $criteria->condition = 't.ID_PRODUIT=:pid';
                    $criteria->params = array(':pid' => $search_product);
                }

                $data_products_marques = ProductDirectory::model()->findAll($criteria);

                foreach ($data_products_marques as $infos) {
                    foreach ($infos['productMarqueDirectory'] as $info2) {
                        $infoarr[] = $info2['ID_LIEN_MARQUE'];
                    }
                }

                if (!empty($infoarr)) {
                    // Get supplierids related to the productmarques   
                    $criteria = new CDbCriteria;
                    $criteria->addInCondition('ID_LIEN_PRODUIT_MARQUE', $infoarr);
                    $criteria->group = 'ID_FOURNISSEUR';
                    $data_suppliers = SupplierProducts::model()->findAll($criteria);

                    foreach ($data_suppliers as $infos3) {
                        $supplierids[] = $infos3['ID_FOURNISSEUR'];
                    }
                }

                if (!empty($supplierids)) {
                    $imp_suppids = (count($supplierids) > 1) ? implode(',', $supplierids) : $supplierids[0];
                    $section_product_qry = " AND f.ID_FOURNISSEUR IN (" . $imp_suppids . ") ";
                }
            }
        }

        // Get all records list  with limit
        $supplier_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ID_FOURNISSEUR , COMPAGNIE , TYPE_FOURNISSEUR_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 " . $section_product_qry)
                ->order('ft.TYPE_FOURNISSEUR_' . $this->lang . ',COMPAGNIE')
                ->limit(CATEGORIESLISTPERPAGE, $limit) // the trick is here!
                ->queryAll();

        // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 " . $section_product_qry)
                ->queryScalar(); // do not LIMIT it, this must count all items!
        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(CATEGORIESLISTPERPAGE);

        $result = array();
        foreach ($supplier_query as $users) {
            $supptype = $users['TYPE_FOURNISSEUR_' . $this->lang . ''];
            $result[$supptype][] = $users;
        }

        // render
        $this->render('index', array(
            'searchModel' => $searchModel,
            'model' => $result,
            'item_count' => $item_count,
            'page_size' => CATEGORIESLISTPERPAGE,
            'pages' => $pages,
        ));
    }

    public function actionCreate() {

        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('index'));
        }

        $model = new SuppliersDirectory;
        $umodel = new UserDirectory('frontend');

        if (Yii::app()->user->hasState("secondtab") || Yii::app()->user->hasState("thirdtab") || Yii::app()->user->hasState("fourthtab")) {
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

            Yii::app()->user->setState("secondtab", null);
            Yii::app()->user->setState("thirdtab", null);
            Yii::app()->user->setState("fourthtab", null);
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['SuppliersDirectory'])) {

            $model->attributes = $_POST['SuppliersDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            // $model->ID_CLIENT = $umodel->USR;
            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
            $umodel->sGuid = Myclass::getGuid();
            $umodel->LANGUE = Yii::app()->session['language'];
            $umodel->MUST_VALIDATE = 1;

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

                //set session variable
                $scountry = $_POST['SuppliersDirectory']['country'];
                $sregion = $_POST['SuppliersDirectory']['region'];
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
        $this->render('create', compact('umodel', 'model', 'tab'));
    }

    //TAB 2
    public function actionAddproducts() {

        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('index'));
        }

        $data_products = array();

        // For create form
        $model = new SuppliersDirectory;
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
                    $marque_ids[$info] = '';
                }

                $marque_result = $marque_ids;

                if (Yii::app()->user->hasState("marque_ids")) {
                    $sess_marque_ids = Yii::app()->user->getState("marque_ids");
                    $marque_result = $marque_ids + $sess_marque_ids;
                    array_unique($marque_result);
                }

                Yii::app()->user->setState("marque_ids", $marque_result);
                Yii::app()->user->setState("product_ids", $result);
                Yii::app()->user->setState("thirdtab", "3");
            } else {
                Yii::app()->user->setState("thirdtab", "3");
            }

            $this->redirect(array('addmarques'));
        }

        if (Yii::app()->user->hasState("product_ids")) {
            $proids = Yii::app()->user->getState("product_ids");
            $data_products = SuppliersDirectory::getproducts($proids);
        }

        $tab = 2;
        $viewpage = '_section_products_form';

        $this->render($viewpage, compact('model', 'tab', 'data_products'));
    }

    public function actionAddmarques() {

        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('index'));
        }

        $sess_product_ids = array();
        $data_products = array();

        if (Yii::app()->user->hasState("mattributes")) {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
        }


        $model = new SuppliersDirectory;
        $umodel = new UserDirectory('frontend');


        if ($_POST['btnSubmit'] == "marquesubmit") {

            Yii::app()->user->setState("fourthtab", "4");
            $this->redirect(array('payment'));
        }

        //check if session exists
        if (Yii::app()->user->hasState("mattributes")) {
            //get session variable         
            $model->attributes = $sess_attr_m;
            $sess_attr_u = Yii::app()->user->getState("uattributes");
            $umodel->attributes = $sess_attr_u;
        }

        if (Yii::app()->user->hasState("product_ids")) {
            $sess_product_ids = Yii::app()->user->getState("product_ids");
            $data_products = SuppliersDirectory::getproducts($sess_product_ids);

            if (empty($sess_product_ids)) {
                Yii::app()->user->setState("marque_ids", null);
            }
        }

        $tab = 3;
        $viewpage = '_products_marques_form';
        $this->render($viewpage, compact('model', 'tab', 'data_products'));
    }

    public function actionPayment() {

        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('index'));
        }

        $pmodel = new SuppliersSubscription;
        $model_paypaladvance = new PaymentTransaction('paypal_advance');

        $this->performAjaxValidation(array($pmodel));

        if (isset($_POST['SuppliersSubscription'])) {

            $pmodel->attributes = $_POST['SuppliersSubscription'];

            $pmodel->scenario = ($_POST['SuppliersSubscription']['subscription_type'] == 2) ? "type2" : "";

            $pmodel->ID_CATEGORIE = $_POST['SuppliersSubscription']['ID_CATEGORIE'];
            $pmodel->TITRE_FICHIER = $_POST['SuppliersSubscription']['TITRE_FICHIER'];
            $pmodel->image = CUploadedFile::getInstance($pmodel, 'image');

            $card_validdate = true;
            if ($_POST['SuppliersSubscription']['payment_type'] == 2) {
                $model_paypaladvance->attributes = $_POST['PaymentTransaction'];
                $card_validdate = $model_paypaladvance->validate();
            }

            if ($pmodel->validate() && $card_validdate) {

                // Set subscriptino price
                $subprices = SupplierSubscriptionPrice::model()->findByPk(1);
                $profile_price = $subprices->profile_price;
                $profile_logo_price = $subprices->profile_logo_price;
                $tax_price = $subprices->tax;

                $invoice_number = Myclass::getRandomString();

                $payment_details = array();

                // Price calculation
                if ($_POST['SuppliersSubscription']['subscription_type'] == 2) {
                    // Tax calculation and grand total
                    $taxval_profile_logo = $profile_logo_price * ($tax_price / 100);
                    $grandtotal_profile_logo = ( $profile_logo_price + $taxval_profile_logo);

                    $pmodel->amount = $grandtotal_profile_logo;

                    $payment_details['subscription_price'] = $profile_logo_price;
                    $payment_details['tax'] = $taxval_profile_logo;
                    $payment_details['total_price'] = $grandtotal_profile_logo;
                } else {
                    // Tax calculation and grand total
                    $taxval_profile = $profile_price * ($tax_price / 100);
                    $grandtotal_profile = ( $profile_price + $taxval_profile);

                    $pmodel->amount = $grandtotal_profile;

                    $payment_details['subscription_price'] = $profile_price;
                    $payment_details['tax'] = $taxval_profile;
                    $payment_details['total_price'] = $grandtotal_profile;
                }

                $payment_details['payment_type'] = $pmodel->payment_type;
                $payment_details['subscription_type'] = $pmodel->subscription_type;

                // For pay with credit card
                if ($_POST['SuppliersSubscription']['payment_type'] == 2) {
                    $response = $this->pay_with_creditcard($model_paypaladvance, $pmodel->amount);
                    if ($response['RESULT'] != 0 || $response['RESPMSG'] != 'Approved') {
                        Yii::app()->user->setFlash('danger', 'Your card details not corret , please try again!!!');
                        $this->redirect(array('payment'));
                    }
                }


                if ($pmodel->scenario == "type2") {
                    //Upload image and get the name
                    $path = Yii::getPathOfAlias('webroot') . '/' . ARCHIVE_IMG_PATH;

                    $fmodel = new ArchiveFichier('create');

                    $fmodel->image = $pmodel->image;
                    $imgname = time() . '_' . $fmodel->image->name;

                    $fmodel->FICHIER = $imgname;
                    $fmodel->EXTENSION = $fmodel->image->extensionName;

                    $fmodel->ID_CATEGORIE = $pmodel->ID_CATEGORIE;
                    $fmodel->TITRE_FICHIER_FR = $pmodel->TITRE_FICHIER;
                    $fmodel->TITRE_FICHIER_EN = $pmodel->TITRE_FICHIER;

                    $catid = $pmodel->ID_CATEGORIE;
                    $cat_img_path = $path . $catid . '/';
                    if (!is_dir($cat_img_path)) {
                        mkdir($cat_img_path, 0777, true);
                    }

                    $fmodel->image->saveAs($cat_img_path . $imgname);

                    $payment_details['ID_CATEGORIE'] = $pmodel->ID_CATEGORIE;
                    $payment_details['TITRE_FICHIER'] = $pmodel->TITRE_FICHIER;
                    $payment_details['FICHIER'] = $imgname;
                    $payment_details['EXTENSION'] = $fmodel->EXTENSION;
                }

                // Session supplier model attribute    
                $sess_attr_m = Yii::app()->user->getState("mattributes");
                // Session user model attribute
                $sess_attr_u = Yii::app()->user->getState("uattributes");
                // Session productids 
                $sess_productids = Yii::app()->user->getState("product_ids");
                // Session marqueids 
                $sess_marqueids = Yii::app()->user->getState("marque_ids");

                // For pay with credit card
                if ($_POST['SuppliersSubscription']['payment_type'] == 2) {
                    if ($response['RESPMSG'] == 'Approved') {
                        $payment_details['PNREF'] = $response['PNREF'];

                        $this->savecreditcard_response($sess_attr_m, $sess_attr_u, $sess_productids, $sess_marqueids, $payment_details, $invoice_number);
                        $this->unset_sessionvals();
                        Yii::app()->user->setFlash('success', Myclass::t('OG044', '', 'og'));
                        $this->redirect(array('create'));
                    }
                }

                $serial_attr_m = serialize($sess_attr_m);
                $serial_attr_u = serialize($sess_attr_u);
                $serial_pids = serialize($sess_productids);
                $serial_mids = serialize($sess_marqueids);
                $pdetails = serialize($payment_details);

                $stmodel = new SupplierTemp;
                $stmodel->umodel = $serial_attr_u;
                $stmodel->smodel = $serial_attr_m;
                $stmodel->product_ids = $serial_pids;
                $stmodel->marque_ids = $serial_mids;
                $stmodel->paymentdetails = $pdetails;
                $stmodel->invoice_number = $invoice_number;

                $stmodel->save(false);

                // unset Session vals 
                $this->unset_sessionvals();

                // Save products in to database        
                // $this->paypal_ipn($invoice_number);    

                $this->paypaltest($pmodel->subscription_type, $pmodel->amount, $invoice_number);
            }
        }
        $tab = 4;
        $viewpage = '_payment_form';
        $this->render($viewpage, compact('pmodel', 'tab', 'model_paypaladvance'));
    }

    protected function unset_sessionvals() {
        Yii::app()->user->setState("mattributes", null);
        // unset Session user model attribute
        Yii::app()->user->setState("uattributes", null);
        // unset Session productids 
        Yii::app()->user->setState("product_ids", null);
        // unset Session marqueids 
        Yii::app()->user->setState("marque_ids", null);
        // unset Session tab4
        Yii::app()->user->setState("fourthtab", null);
        // unset Session tab3 
        Yii::app()->user->setState("thirdtab", null);
        // unset Session tab2
        Yii::app()->user->setState("secondtab", null);
        // unset Session scountry  
        Yii::app()->user->setState("scountry", null);
        // unset Session sregion  
        Yii::app()->user->setState("sregion", null);
    }

    protected function savecreditcard_response($sess_attr_m, $sess_attr_u, $sess_productids, $sess_marqueids, $pdetails, $invoice_number) {
        $baseurl = Yii::app()->request->getBaseUrl(true);
        if (!empty($sess_attr_m)) {
            $ficherid = 0;

            //Save the  supplier ficher (logo)
            if (!empty($pdetails)) {
                if ($pdetails['subscription_type'] == 2) {
                    $afmodel = new ArchiveFichier('create');
                    $afmodel->ID_CATEGORIE = $pdetails['ID_CATEGORIE'];
                    $afmodel->TITRE_FICHIER_FR = $pdetails['TITRE_FICHIER'];
                    $afmodel->TITRE_FICHIER_EN = $pdetails['TITRE_FICHIER'];
                    $afmodel->FICHIER = $pdetails['FICHIER'];
                    $afmodel->EXTENSION = $pdetails['EXTENSION'];
                    $afmodel->DISPONIBLE = 1;

                    $afmodel->save(false);

                    $ficherid = $afmodel->ID_FICHIER;
                }
            }

            if ($pdetails['subscription_type'] == 1) {
                $itemname = 'Suppliers Subscription - Profile only';
            } else if ($pdetails['subscription_type'] == 2) {
                $itemname = 'Suppliers Subscription - Profile & logo';
            }

            $model = new SuppliersDirectory;
            $umodel = new UserDirectory('frontend');

            // Save supplier in user and supplier table
            $model->attributes = $sess_attr_m;
            $model->ID_CLIENT = $sess_attr_m['ID_CLIENT'];
            $model->iId_fichier = $ficherid;
            $model->profile_expirydate = date("Y-m-d", strtotime('+1 year'));
            if ($pdetails['subscription_type'] == 2) {
                $model->logo_expirydate = date("Y-m-d", strtotime('+1 year'));
            }
            $model->CREATED_DATE = date("Y-m-d");
            $model->save(false);

            $umodel->attributes = $sess_attr_u;
            $umodel->ID_RELATION = $model->ID_FOURNISSEUR;
            $umodel->status = 1;
            $umodel->save(false);

            $supplierid = $model->ID_FOURNISSEUR;

            // Save products and brands for the supplier
            if (!empty($sess_productids)) {
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
            $ptmodel->user_id = $model->ID_FOURNISSEUR;
            $ptmodel->total_price = $pdetails['total_price'];
            $ptmodel->subscription_price = $pdetails['subscription_price'];
            $ptmodel->tax = $pdetails['tax'];
            $ptmodel->payment_status = 'Completed';
            $ptmodel->txn_id = $pdetails['PNREF'];
            $ptmodel->payment_type = 'ppa';
            $ptmodel->item_name = $itemname;
            $ptmodel->NOMTABLE = 'suppliers';
            $ptmodel->subscription_type = $pdetails['subscription_type'];
            $ptmodel->invoice_number = $invoice_number;
            $ptmodel->pay_type = '2';
            $ptmodel->save(false);

            /* Send mail to admin for confirmation */
            $mail = new Sendmail();
            $suppliers_url = ADMIN_URL . 'admin/userDirectory/update/id/' . $umodel->ID_UTILISATEUR;
            $invoice_url = ADMIN_URL . 'admin/paymentTransaction/view/id/' . $ptmodel->id;

            $enc_url = Myclass::refencryption($suppliers_url);
            $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

            $enc_url2 = Myclass::refencryption($invoice_url);
            $nextstep_url2 = ADMIN_URL . 'admin/default/login/str/' . $enc_url2;

            if($this->lang=='EN' ){
                $subject = SITENAME . " - New suppliers registration notification with invoice details - " . $model->COMPAGNIE;
            }elseif($this->lang=='FR'){
                $subject = SITENAME . " - Nouveau profil à authentifier ";
            }
            $trans_array = array(
                "{NAME}" => $model->COMPAGNIE,
                "{UTYPE}" => 'suppliers',
                "{NEXTSTEPURL}" => $nextstep_url,
                "{item_name}" => $itemname,
                "{total_price}" => $pdetails['total_price'],
                "{payment_status}" => 'Completed',
                "{txn_id}" => $pdetails['PNREF'],
                "{INVOICEURL}" => $nextstep_url2
            );
            $message = $mail->getMessage('supplier_registration', $trans_array);
            $mail->send(ADMIN_EMAIL, $subject, $message);

            if($this->lang=='EN' ){
                $subject = SITENAME . " - Thanks for your subscription as a supplier and invoice details.";
                $message1 = 'Thanks for your subscription as a supplier user type in ' . SITENAME.'.';
                $message2 = 'Your subscription will expire on ' . $model->profile_expirydate . '.';
                
            }elseif($this->lang=='FR'){
                $subject = SITENAME . " - Votre inscription comme fournisseur est complétée";
                $message1 = 'Nous vous remercions de vous être inscrit comme fournisseur sur le site ' . SITENAME.'.';
                $message2 = 'Votre inscription sera en vigueur jusqu’au ' . $model->profile_expirydate . '.';
            }
            $subject = SITENAME . "- Thanks for your subscription as a supplier and invoice details.";
            $nextstep_url = $baseurl . '/optiguide/suppliersDirectory/transactions';
            $trans_array = array(
                "{NAME}" => $model->COMPAGNIE,
                "{UTYPE}" => 'suppliers',
                "{NEXTSTEPURL}" => $nextstep_url,
                "{message1}" => $message1,
                "{message2}" => $message2,
                "{item_name}" => $itemname,
                "{pay_type}" => 'Credit Card',
                "{total_price}" => $pdetails['total_price'],
                "{payment_status}" => 'Completed',
                "{txn_id}" => $pdetails['PNREF'],
            );
            $message = $mail->getMessage('supplier_frontend_subscription_account', $trans_array);
            $mail->send($umodel->COURRIEL, $subject, $message);
        }
    }

    protected function pay_with_creditcard($model_paypalAdvance, $amount) {
        $paypalAdv = new PaypalAdvance;
        $request = array(
            "PARTNER" => $paypalAdv::PARTNER,
            "VENDOR" => $paypalAdv::VENDOR,
            "USER" => $paypalAdv::USER,
            "PWD" => $paypalAdv::PWD,
            "TENDER" => "C",
            "TRXTYPE" => "S",
            "CURRENCY" => "CAD",
            "AMT" => $amount,
            "ACCT" => $model_paypalAdvance->credit_card,
            "EXPDATE" => $model_paypalAdvance->exp_month . $model_paypalAdvance->exp_year,
            "CVV2" => $model_paypalAdvance->cvv2,
        );

        //Run request and get the response
        $response = $paypalAdv->run_payflow_call($request);
        return $response;
    }

    public function paypaltest($subscription_type = '', $price = '', $invoice = '') {
        $paypalManager = new Paypal;

        $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optiguide/suppliersDirectory/paypalreturn'));
        $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optiguide/suppliersDirectory/paypalcancel'));
        $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optiguide/suppliersDirectory/paypalnotify'));

        if ($subscription_type == 1) {
            $itemname = 'Suppliers Subscription - Profile only';
        } else if ($subscription_type == 2) {
            $itemname = 'Suppliers Subscription - Profile & logo';
        }

        $paypalManager->addField('item_name', $itemname);
        $paypalManager->addField('amount', $price);
        $paypalManager->addField('custom', $invoice);
        $paypalManager->addField('return', $returnUrl);
        $paypalManager->addField('cancel_return', $cancelUrl);
        $paypalManager->addField('notify_url', $notifyUrl);

        //$paypalManager->dumpFields();   // for printing paypal form fields
        $paypalManager->submitPaypalPost();
    }

    public function actionPaypalreturn() {

        $pstatus = $_POST["payment_status"];

        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', Myclass::t('OGO132', '', 'og'));
            } else {
                Yii::app()->user->setFlash('success', Myclass::t('OG044', '', 'og'));
            }
        } else {
            Yii::app()->user->setFlash('danger', Myclass::t('OGO133', '', 'og'));
        }

        $this->redirect(array('create'));
    }

    public function actionPaypalcancel() {

        Yii::app()->user->setFlash('warning', Myclass::t('OGO134', '', 'og'));
        $this->redirect(array('create'));
    }

    public function actionPaypalnotify() {
        $baseurl = Yii::app()->request->getBaseUrl(true);
        $paypalManager = new Paypal;

        if ($paypalManager->notify() && ( $_POST['payment_status'] == "Completed" || $_POST['payment_status'] == "Pending")) {

            $invoice_number = $_POST['custom'];

            $paymentinfos = PaymentTransaction::model()->find("invoice_number ='" . $invoice_number . "'");
            // Check the transation already exists
            if (!empty($paymentinfos)) {

                $suppid = $paymentinfos->user_id;
                $subscription_type = $paymentinfos->subscription_type;

                if ($_POST['payment_status'] == "Completed") {
                    /* Update user status 1 in user table */
                    $userinfos = UserDirectory::model()->find("NOM_TABLE='Fournisseurs' AND ID_REALTION = " . $suppid);
                    $userinfos->status = 1;
                    $userinfos->save(false);

                    /* Update supplier expiry date in supplier table */
                    $supp_model = SuppliersDirectory::model()->findByPk($suppid);
                    $supp_model->profile_expirydate = date("Y-m-d", strtotime('+1 year'));
                    if ($subscription_type == 2) {
                        $supp_model->logo_expirydate = date("Y-m-d", strtotime('+1 year'));
                    }
                    $supp_model->save(false);

                    /* Update supplier expiry date in payment transation table */
                    $paymentinfos->expirydate = date("Y-m-d", strtotime('+1 year'));
                    $paymentinfos->save(false);
                }
            } else {

                $result = SupplierTemp::model()->find("invoice_number='$invoice_number'");

                if (!empty($result)) {

                    $serial_attr_u = $result->umodel;
                    $serial_attr_m = $result->smodel;
                    $serial_pids = $result->product_ids;
                    $serial_mids = $result->marque_ids;
                    $pdetails = $result->paymentdetails;


                    $sess_attr_u = unserialize($serial_attr_u);
                    $sess_attr_m = unserialize($serial_attr_m);
                    $sess_productids = unserialize($serial_pids);
                    $sess_marqueids = unserialize($serial_mids);
                    $pdetails = unserialize($pdetails);


                    if (!empty($sess_attr_m)) {
                        $ficherid = 0;

                        //Save the  supplier ficher (logo)
                        if (!empty($pdetails)) {
                            if ($pdetails['subscription_type'] == 2) {
                                $afmodel = new ArchiveFichier('create');
                                $afmodel->ID_CATEGORIE = $pdetails['ID_CATEGORIE'];
                                $afmodel->TITRE_FICHIER_FR = $pdetails['TITRE_FICHIER'];
                                $afmodel->TITRE_FICHIER_EN = $pdetails['TITRE_FICHIER'];
                                $afmodel->FICHIER = $pdetails['FICHIER'];
                                $afmodel->EXTENSION = $pdetails['EXTENSION'];
                                $afmodel->DISPONIBLE = 1;

                                $afmodel->save(false);

                                $ficherid = $afmodel->ID_FICHIER;
                            }
                        }

                        $model = new SuppliersDirectory;
                        $umodel = new UserDirectory('frontend');

                        // Save supplier in user and supplier table
                        $model->attributes = $sess_attr_m;
                        $model->ID_CLIENT = $sess_attr_m['ID_CLIENT'];
                        $model->iId_fichier = $ficherid;
                        if ($_POST['payment_status'] == "Completed") {
                            $model->profile_expirydate = date("Y-m-d", strtotime('+1 year'));
                            if ($pdetails['subscription_type'] == 2) {
                                $model->logo_expirydate = date("Y-m-d", strtotime('+1 year'));
                            }
                        }
                        $model->CREATED_DATE = date("Y-m-d");
                        $model->save(false);

                        $umodel->attributes = $sess_attr_u;
                        $umodel->ID_RELATION = $model->ID_FOURNISSEUR;
                        if ($_POST['payment_status'] == "Completed") {
                            $umodel->status = 1;
                        }
                        $umodel->save(false);

                        $supplierid = $model->ID_FOURNISSEUR;

                        // Save products and brands for the supplier
                        if (!empty($sess_productids)) {
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
                        $ptmodel->total_price = $pdetails['total_price'];
                        $ptmodel->tax = $pdetails['tax'];
                        $ptmodel->subscription_price = $pdetails['subscription_price'];
                        $ptmodel->payment_status = $_POST['payment_status'];
                        $ptmodel->payer_email = $_POST['payer_email'];
                        $ptmodel->verify_sign = $_POST['verify_sign'];
                        $ptmodel->txn_id = $_POST['txn_id'];
                        $ptmodel->payment_type = $_POST['payment_type'];
                        $ptmodel->receiver_email = $_POST['receiver_email'];
                        $ptmodel->txn_type = $_POST['txn_type'];
                        $ptmodel->item_name = $_POST['item_name'];
                        $ptmodel->NOMTABLE = 'suppliers';
                        $ptmodel->expirydate = date("Y-m-d", strtotime('+1 year'));
                        $ptmodel->invoice_number = $_POST['custom'];
                        $ptmodel->pay_type = $pdetails['payment_type'];
                        $ptmodel->subscription_type = $pdetails['subscription_type'];
                        $ptmodel->save();

                        if ($_POST['payment_status'] == "Completed") {
                            SupplierTemp::model()->deleteAll("invoice_number = '" . $_POST['custom'] . "'");
                        }

                        /* Send mail to admin for confirmation */
                        $mail = new Sendmail();
                        
                        $suppliers_url = ADMIN_URL . '/admin/userDirectory/update/id/' . $umodel->ID_UTILISATEUR;
                        $invoice_url = ADMIN_URL . '/admin/paymentTransaction/view/id/' . $ptmodel->id;

                        $enc_url = Myclass::refencryption($suppliers_url);
                        $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                        $enc_url2 = Myclass::refencryption($invoice_url);
                        $nextstep_url2 = ADMIN_URL . 'admin/default/login/str/' . $enc_url2;
                        
                        if($this->lang=='EN' ){
                            $subject = SITENAME . " - New suppliers registration notification with invoice details - " . $model->COMPAGNIE;
                        }elseif($this->lang=='FR'){
                            $subject = SITENAME . " - Nouveau profil à authentifier ";
                        }
                        $trans_array = array(
                            "{NAME}" => $model->COMPAGNIE,
                            "{UTYPE}" => 'suppliers',
                            "{NEXTSTEPURL}" => $nextstep_url,
                            "{item_name}" => $_POST['item_name'],
                            "{total_price}" => $pdetails['total_price'],
                            "{payment_status}" => $_POST['payment_status'],
                            "{txn_id}" => $_POST['txn_id'],
                            "{INVOICEURL}" => $nextstep_url2
                        );
                        $message = $mail->getMessage('supplier_registration', $trans_array);
                        $mail->send(ADMIN_EMAIL, $subject, $message);
                        
                        
                        $subject = SITENAME . "- Thanks for your subscription as a supplier and invoice details.";
                        $nextstep_url = $baseurl . '/optiguide/suppliersDirectory/transactions';
                        $contact_url = $baseurl . '/optiguide/default/contactus';
                        
                        if($this->lang=='EN' ){
                            $subject = SITENAME . " - Thanks for your subscription as a supplier and invoice details.";
                            $message1 = 'Thank you for subscribing to ' . SITENAME.' Website. Your payment status is Pending,';
                            $message2 = 'Please <a href="' . $contact_url . '">contact</a> admin for further information.';

                        }elseif($this->lang=='FR'){
                            $subject = SITENAME . " - Votre inscription comme fournisseur est complétée";
                            $message1 = 'Nous vous remercions de vous être inscrit comme fournisseur sur le site ' . SITENAME.'. Votre paiement est présentement en traitement.';
                            $message2 = 'Pour plus de détails, vous pouvez <a href="' . $contact_url . '">nous contacter</a>.';
                        }
                        $trans_array = array(
                            "{NAME}" => $model->COMPAGNIE,
                            "{NEXTSTEPURL}" => $nextstep_url,
                            "{message1}" => $message1,
                            "{message2}" => $message2,
                            "{item_name}" => $_POST['item_name'],
                            "{pay_type}" => $ptmodel->payment_type,
                            "{total_price}" => $pdetails['total_price'],
                            "{payment_status}" => $_POST['payment_status'],
                            "{txn_id}" => $_POST['txn_id'],
                        );
                        $message = $mail->getMessage('supplier_frontend_subscription_account', $trans_array);
                        $mail->send($umodel->COURRIEL, $subject, $message);
                    }
                }
            }
        }
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
//                    if (Yii::app()->user->hasState("product_ids")) {
//                        $sess_product_ids = Yii::app()->user->getState("product_ids");
//                        if (($key = array_search($pid, $sess_product_ids)) !== FALSE) {
//                            // Remove from array
//                            unset($sess_product_ids[$key]);
//                        }
//                        Yii::app()->user->setState("product_ids", $sess_product_ids);
//
//                        // UNset marque ids for the product                   
//                        $sess_marque_ids = Yii::app()->user->getState("marque_ids");
//                        if (array_key_exists($pid, $sess_marque_ids)) {
//                            // Remove from array                      
//                            unset($sess_marque_ids[$pid]);
//                        }
//                        Yii::app()->user->setState("marque_ids", $sess_marque_ids);
//                    }

                    Yii::app()->user->setFlash('danger', 'Please select any brand.');
                    $this->redirect(array('listmarques', "id" => $pid));
                }


                if (Yii::app()->user->hasState("relationid")) {
                    $relid = Yii::app()->user->relationid;
                    $this->redirect(array('updatemarques'));
                } else {
                    $this->redirect(array('addmarques'));
                }
            }
        } else {

            if (Yii::app()->user->hasState("relationid")) {
                $this->redirect(array('updatemarques'));
            } else {
                $this->redirect(array('addmarques'));
            }
        }

        $this->render('listmarques', compact('get_selected_marques'));
    }

    public function actionUpdate() {

        $relid = Yii::app()->user->relationid;
        $id = Yii::app()->user->id;
        $model = $this->loadModel($relid);
        $umodel = UserDirectory::model()->findByPk($id);
        $umodel->scenario = 'frontend';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['SuppliersDirectory'])) {

            $model->attributes = $_POST['SuppliersDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
            $umodel->MUST_VALIDATE = 1;


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

                $model->save(false);
                $umodel->ID_RELATION = $model->ID_FOURNISSEUR;
                $umodel->save(false);

                Yii::app()->user->setFlash('success', Myclass::t('OG036', '', 'og'));
                $this->redirect(array('update'));
            }
        }

        $this->render('update', compact('umodel', 'model'));
    }

    public function actionUpdateproducts() {
        $data_products = array();
        $result = array();

        $relid = Yii::app()->user->relationid;
        $model = $this->loadModel($relid);
        //Yii::app()->user->setState("product_ids", NULL);
        // Set and intialize session from existing database records.         
        if (Yii::app()->user->hasState("product_ids") == FALSE) {
            $fid = $relid;
            $criteria1 = new CDbCriteria();
            $criteria1->condition = 'ID_FOURNISSEUR=:id';
            $criteria1->params = array(':id' => $fid);
            $criteria1->group = 'productMarqueDirectory.ID_PRODUIT';
            $get_selected_products = CHtml::listData(SupplierProducts::model()->with("productMarqueDirectory")->findAll($criteria1), 'ID_LIEN_REPERTOIRE_PRODUIT', 'productMarqueDirectory.ID_PRODUIT');

            /* Set products in session */
            if (!empty($get_selected_products)) {
                foreach ($get_selected_products as $pinfo) {
                    $result[] = $pinfo;
                }
                Yii::app()->user->setState("product_ids", $result);
                $data_products = SuppliersDirectory::getproducts($result);

                if (!empty($result)) {
                    /* Set marques in session */
                    foreach ($result as $pid) {
                        $prodid = $pid;
                        $criteria1 = new CDbCriteria();
                        $criteria1->condition = "ID_FOURNISSEUR=:fid AND productMarqueDirectory.ID_PRODUIT=:pid";
                        $criteria1->params = array(":fid" => $fid, ":pid" => $prodid);
                        $get_selected_marques = CHtml::listData(SupplierProducts::model()->with("productMarqueDirectory")->findAll($criteria1), 'ID_LIEN_REPERTOIRE_PRODUIT', 'productMarqueDirectory.ID_MARQUE');

                        if (!empty($get_selected_marques)) {
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
                }

                if (!empty($marque_ids)) {
                    Yii::app()->user->setState("marque_ids", $marque_ids);
                }
            }
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
                    $marque_ids[$info] = '';
                }

                $marque_result = $marque_ids;

                if (Yii::app()->user->hasState("marque_ids")) {
                    $sess_marque_ids = Yii::app()->user->getState("marque_ids");
                    $marque_result = $marque_ids + $sess_marque_ids;
                    array_unique($marque_result);
                }

                Yii::app()->user->setState("marque_ids", $marque_result);
                Yii::app()->user->setState("product_ids", $result);
                Yii::app()->user->setState("thirdtab", "3");
            } else {
                Yii::app()->user->setState("thirdtab", "3");
            }

            $this->redirect(array('updatemarques'));
        }

        if (Yii::app()->user->hasState("product_ids")) {
            $proids = Yii::app()->user->getState("product_ids");
            $data_products = SuppliersDirectory::getproducts($proids);
        }

        $tab = 2;
        $viewpage = '_update_section_products_form';

        $this->render($viewpage, compact('model', 'tab', 'data_products'));
    }

    public function actionUpdatelogo() {

        $relid = Yii::app()->user->relationid;
        $pmodel = $this->loadModel($relid);

        // Check expiry date and redirect to renew page for expired logos
        $logo_expirydate = $pmodel->logo_expirydate;
        $l_expdate = date("Y-m-d", strtotime($logo_expirydate));
        if ($l_expdate < date("Y-m-d")) {
            Yii::app()->user->setFlash('info', Myclass::t('OGO186', '', 'og'));
            Yii::app()->request->redirect("/optiguide/suppliersDirectory/renewsubscription/");
        }


        if ($pmodel->iId_fichier == 0) {
            $fmodel = new ArchiveFichier('create');
        } else {
            $fichid = $pmodel->iId_fichier;
            $fmodel = ArchiveFichier::model()->findByPk($fichid);
        }

        if (isset($_POST['ArchiveFichier'])) {
            $fmodel->attributes = $_POST['ArchiveFichier'];

            $fmodel->TITRE_FICHIER_FR = $_POST['ArchiveFichier']['TITRE_FICHIER_EN'];

            if ($fmodel->validate()) {
                //Upload image and get the name
                $path = Yii::getPathOfAlias('webroot') . '/' . ARCHIVE_IMG_PATH;

                $fmodel->image = CUploadedFile::getInstance($fmodel, 'image');

                if ($fmodel->image) {
                    $imgname = time() . '_' . $fmodel->image->name;
                    $fmodel->FICHIER = $imgname;
                    $fmodel->EXTENSION = $fmodel->image->extensionName;

                    $catid = $_POST['ArchiveFichier']['ID_CATEGORIE'];
                    $cat_img_path = $path . $catid . '/';

                    if (!is_dir($cat_img_path)) {
                        mkdir($cat_img_path, 0777, true);
                    }

                    $fmodel->image->saveAs($cat_img_path . $imgname);
                }

                $fmodel->DISPONIBLE = 1;

                if ($fmodel->save()) {

                    $pmodel->iId_fichier = $fmodel->ID_FICHIER;
                    $pmodel->save(false);

                    // redirect to success page
                    Yii::app()->user->setFlash('success', 'Logo Updated Successfully!!!');
                    $this->redirect(array('updatelogo'));
                }
            }
        }

        $viewpage = '_update_logo';
        $this->render($viewpage, compact('pmodel', 'fmodel'));
    }

    public function actionUpdatemarques() {

        $sess_product_ids = array();
        $data_products = array();

        $relid = Yii::app()->user->relationid;
        $model = $this->loadModel($relid);


        if ($_POST['btnSubmit'] == "marquesubmit") {

            SupplierProducts::model()->deleteAll("ID_FOURNISSEUR ='" . $relid . "'");

            $sess_productids = Yii::app()->user->getState("product_ids");
            // Session marqueids 
            $sess_marqueids = Yii::app()->user->getState("marque_ids");

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
                                $spmodel->ID_FOURNISSEUR = $relid;
                                $spmodel->ID_LIEN_PRODUIT_MARQUE = $prd_mar_id;
                                $spmodel->save();
                            }
                        }
                    }
                }
            }

            Yii::app()->user->setFlash('success', Myclass::t('OGO144', '', 'og'));
            $this->redirect(array('updatemarques'));
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
            }
        }

        if (Yii::app()->user->hasState("product_ids")) {
            $sess_product_ids = Yii::app()->user->getState("product_ids");

            $data_products = SuppliersDirectory::getproducts($sess_product_ids);

            if (empty($sess_product_ids)) {
                Yii::app()->user->setState("marque_ids", null);
            }
        }

        $tab = 3;
        $viewpage = '_update_products_marques_form';
        $this->render($viewpage, compact('model', 'tab', 'data_products'));
    }

    public function actionDelproducts($id) {
        $sess_product_ids = Yii::app()->user->getState("product_ids");

        $pid = isset($id) ? $id : '';

        if ($pid != '') {
            // foreach ($pids as $pid) {
            if (($key = array_search($pid, $sess_product_ids)) !== FALSE) {
                // Remove from array            
                unset($sess_product_ids[$key]);
            }
            $sess_product_ids = array_values($sess_product_ids);


            if (Yii::app()->user->hasState("marque_ids")) {
                // UNset marque ids for the product                   
                $sess_marque_ids = Yii::app()->user->getState("marque_ids");
                if (array_key_exists($pid, $sess_marque_ids)) {
                    // Remove from array                      
                    unset($sess_marque_ids[$pid]);
                }
            }
            // }         

            Yii::app()->user->setState("product_ids", $sess_product_ids);
            Yii::app()->user->setState("marque_ids", $sess_marque_ids);
        }

        // redirect to success page    
        if (isset(Yii::app()->user->relationid)) {
            $this->redirect(array('updatemarques'));
        } else {
            $this->redirect(array('addmarques'));
        }
    }

    public function actionTransactions() {

        $relid = Yii::app()->user->relationid;

        $criteria = new CDbCriteria();
        $criteria->addCondition('NOMTABLE="suppliers"');
        $criteria->addCondition('user_id = ' . $relid);
        $criteria->order = 'id DESC';

        $count = PaymentTransaction::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = SUPPLIERSLISTPERPAGE;
        $pages->applyLimit($criteria);
        $model = PaymentTransaction::model()->findAll($criteria);

        $this->render('_transactions', array(
            'model' => $model,
            'pages' => $pages,
        ));
    }

    public function actionRenewsubscription() {

        $pmodel = new SuppliersSubscription;
        $model_paypaladvance = new PaymentTransaction('paypal_advance');

        $this->performAjaxValidation(array($pmodel));

        if (isset($_POST['SuppliersSubscription'])) {

            $sub_types = $_POST['subvals'];

            $pmodel->attributes = $_POST['SuppliersSubscription'];

            $card_validdate = true;
            if ($_POST['SuppliersSubscription']['payment_type'] == 2) {
                $model_paypaladvance->attributes = $_POST['PaymentTransaction'];
                $card_validdate = $model_paypaladvance->validate();
            }


            if ($pmodel->validate() && $card_validdate) {

                $subprices = SupplierSubscriptionPrice::model()->findByPk(1);
                $tax_price = $subprices->tax;
                $profile_price = $subprices->profile_price;
                $profile_logo_price = $subprices->profile_logo_price;
                $logo_price = ( $profile_logo_price - $profile_price );

                $payment_details = array();

                if (count($sub_types) > 1) {

                    $subscriptiontype = "2";
                    $taxval_profile_logo = $profile_logo_price * ($tax_price / 100);
                    $grandtotal_profile_logo = ( $profile_logo_price + $taxval_profile_logo);
                    $amount = $grandtotal_profile_logo;

                    $payment_details['subscription_price'] = $profile_logo_price;
                    $payment_details['tax'] = $taxval_profile_logo;
                    $payment_details['total_price'] = $grandtotal_profile_logo;
                } else if ($sub_types[0] == "1") {

                    $subscriptiontype = $sub_types[0];
                    $taxval_profile = $profile_price * ($tax_price / 100);
                    $grandtotal_profile = ( $profile_price + $taxval_profile);
                    $amount = $grandtotal_profile;

                    $payment_details['subscription_price'] = $profile_price;
                    $payment_details['tax'] = $taxval_profile;
                    $payment_details['total_price'] = $grandtotal_profile;
                } else if ($sub_types[0] == "3") {

                    $subscriptiontype = $sub_types[0];
                    $taxval_logo = $logo_price * ($tax_price / 100);
                    $grandtotal_logo = ( $logo_price + $taxval_logo);
                    $amount = $grandtotal_logo;

                    $payment_details['subscription_price'] = $logo_price;
                    $payment_details['tax'] = $taxval_logo;
                    $payment_details['total_price'] = $grandtotal_logo;
                }

                $invoice_number = Myclass::getRandomString();

                // For pay with credit card
                if ($_POST['SuppliersSubscription']['payment_type'] == 2) {
                    $response = $this->pay_with_creditcard($model_paypaladvance, $amount);
                    if ($response['RESULT'] != 0 || $response['RESPMSG'] != 'Approved') {
                        Yii::app()->user->setFlash('danger', 'Your card details not corret , please try again!!!');
                        $this->redirect(array('renewsubscription'));
                    }
                }


                $payment_details['payment_type'] = $_POST['SuppliersSubscription']['payment_type'];
                $payment_details['subscription_type'] = $subscriptiontype;

                $relid = Yii::app()->user->relationid;
                $fmodel = $this->loadModel($relid);
                $profile_expirydate = $fmodel->profile_expirydate;
                $logo_expirydate = $fmodel->logo_expirydate;

                $payment_details['user_id'] = $relid;

                $cur_date = strtotime("now");

                if ($subscriptiontype == "1" || $subscriptiontype == "2") {

                    $p_expdate = date("Y-m-d", strtotime($profile_expirydate));
                    if ($p_expdate > date("Y-m-d")) {
                        $time = strtotime($profile_expirydate);
                        $payment_details['profile_expirydate'] = date("Y-m-d", strtotime("+1 year", $time));
                    } else {
                        $payment_details['profile_expirydate'] = date('Y-m-d', strtotime('+1 year'));
                    }
                }

                if ($subscriptiontype == "3" || $subscriptiontype == "2") {

                    $l_expdate = date("Y-m-d", strtotime($logo_expirydate));
                    if ($l_expdate > date("Y-m-d")) {
                        $time = strtotime($logo_expirydate);
                        $payment_details['logo_expirydate'] = date("Y-m-d", strtotime("+1 year", $time));
                    } else {
                        $payment_details['logo_expirydate'] = date('Y-m-d', strtotime('+1 year'));
                    }
                }

                // For pay with credit card
                if ($_POST['SuppliersSubscription']['payment_type'] == 2) {
                    if ($response['RESPMSG'] == 'Approved') {
                        $payment_details['PNREF'] = $response['PNREF'];

                        $this->savecreditcard_response_renew($model_paypaladvance, $payment_details, $invoice_number);
                        Yii::app()->user->setFlash('success', Myclass::t('OGO188', '', 'og'));
                        $this->redirect(array('renewsubscription'));
                    }
                }

                $pdetails = serialize($payment_details);

                $stmodel = new SupplierTemp;
                $stmodel->paymentdetails = $pdetails;
                $stmodel->invoice_number = $invoice_number;
                $stmodel->save(false);

                $this->renewpaypaltest($subscriptiontype, $amount, $invoice_number);
            }
        }
        $this->render('_renewsubscription', compact('model_paypaladvance', 'sub_types', 'pmodel'));
    }

    protected function savecreditcard_response_renew($model_paypaladvance, $pdetails, $invoice_number) {
        $baseurl = Yii::app()->request->getBaseUrl(true);
        if (!empty($pdetails)) {

            $supplierid = $pdetails['user_id'];
            $subtype = $pdetails['subscription_type'];

            if ($subtype == 1) {
                $itemname = ' - Renew Supplier Subscription - Profile only';
            } else if ($subtype == 2) {
                $itemname = ' - Renew Supplier Subscription - Profile & logo';
            } else if ($subtype == 3) {
                $itemname = ' - Renew Supplier Subscription - Logo only';
            }

            // Update the expiry date in supplier table once the payment is suceess (Completed)
            $model = SuppliersDirectory::model()->findByPk($supplierid);
            $user = UserDirectory::model()->findByAttributes(array('ID_RELATION' => $supplierid, 'NOM_TABLE' => 'Fournisseurs'));

            if ($subtype == "1" || $subtype == "2") {
                $model->profile_expirydate = $pdetails['profile_expirydate'];
            }
            if ($subtype == "3" || $subtype == "2") {
                $model->logo_expirydate = $pdetails['logo_expirydate'];
            }
            $model->save(false);

            // Save the payment details                                   
            $ptmodel = new PaymentTransaction;
            $ptmodel->user_id = $supplierid;
            $ptmodel->total_price = $pdetails['total_price'];
            $ptmodel->subscription_price = $pdetails['subscription_price'];
            $ptmodel->tax = $pdetails['tax'];
            $ptmodel->payment_status = 'Completed';
            $ptmodel->txn_id = $pdetails['PNREF'];
            $ptmodel->payment_type = 'ppa';
            $ptmodel->item_name = $itemname;
            $ptmodel->NOMTABLE = 'suppliers';
            $ptmodel->subscription_type = $pdetails['subscription_type'];
            $ptmodel->invoice_number = $invoice_number;
            $ptmodel->pay_type = '2';
            $ptmodel->save(false);

            /* Send mail to admin for confirmation */
            $mail = new Sendmail();              
            
            $umodel = UserDirectory::model()->findByAttributes(array('ID_RELATION' => $supplierid, 'NOM_TABLE' => 'Fournisseurs'));
            $suppliers_url = ADMIN_URL . '/admin/userDirectory/update/id/' . $umodel->ID_UTILISATEUR;
            $invoice_url = ADMIN_URL . '/admin/paymentTransaction/view/id/' . $ptmodel->id;

            $enc_url = Myclass::refencryption($suppliers_url);
            $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;
            
            
            $enc_url2 = Myclass::refencryption($invoice_url);
            $nextstep_url2 = ADMIN_URL . 'admin/default/login/str/' . $enc_url2;
            
            if($this->lang=='EN' ){
                $subject = SITENAME . $itemname . " notification with invoice details - " . $model->COMPAGNIE;
            }elseif($this->lang=='FR'){
                $subject = SITENAME . " - Renouvellement de profil exigeant votre approbation ";
            }
            $trans_array = array(
                "{NAME}" => $model->COMPAGNIE,
                "{UTYPE}" => 'suppliers',
                "{NEXTSTEPURL}" => $nextstep_url,
                "{item_name}" => $itemname,
                "{total_price}" => $pdetails['total_price'],
                "{payment_status}" => 'Completed',
                "{txn_id}" => $pdetails['PNREF'],
                "{INVOICEURL}" => $nextstep_url2
            );
            $message = $mail->getMessage('supplier_renew_subscription', $trans_array);
            $mail->send(ADMIN_EMAIL, $subject, $message);

            $nextstep_url = $baseurl . '/optiguide/suppliersDirectory/transactions';            
            
            if($this->lang=='EN' ){
                $subject = SITENAME . " - Thanks for your subscription as a supplier and invoice details.";
                $message1 = 'Thanks for your renewal subscription as a supplier user type in ' . SITENAME.' site.';
                $message2 = 'Your subscription will expire on '. $model->profile_expirydate . '.';

            }elseif($this->lang=='FR'){
                $subject = SITENAME . " - Votre inscription comme fournisseur est complétée";
                $message1 = 'Nous vous remercions d’avoir renouvelé votre inscription en tant que fournisseur sur le site ' . SITENAME.'.';
                $message2 = 'Votre inscription sera en vigueur jusqu’au '. $model->profile_expirydate . '.';
            }
            $trans_array = array(
                "{NAME}" => $model->COMPAGNIE,
                "{NEXTSTEPURL}" => $nextstep_url,
                "{message1}" => $message1,
                "{message2}" => $message2,
                "{item_name}" => $itemname,
                "{pay_type}" => 'Credit Card',
                "{total_price}" => $pdetails['total_price'],
                "{payment_status}" => 'Completed',
                "{txn_id}" => $pdetails['PNREF'],
            );
            $message = $mail->getMessage('supplier_frontend_subscription_account', $trans_array);
            $mail->send($user->COURRIEL, $subject, $message);
        }
    }

    public function renewpaypaltest($subscription_type = '', $price = '', $invoice = '') {
        $paypalManager = new Paypal;

        $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optiguide/suppliersDirectory/renewpaypalreturn'));
        $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optiguide/suppliersDirectory/renewpaypalcancel'));
        $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optiguide/suppliersDirectory/renewpaypalnotify'));
        // $price = 10;
        // $invoice = rand();

        if ($subscription_type == 1) {
            $itemname = 'Renew Supplier Subscription - Profile only';
        } else if ($subscription_type == 2) {
            $itemname = 'Renew Supplier Subscription - Profile & logo';
        } else if ($subscription_type == 3) {
            $itemname = 'Renew Supplier Subscription - Logo only';
        }

        $paypalManager->addField('item_name', $itemname);
        $paypalManager->addField('amount', $price);
        $paypalManager->addField('custom', $invoice);
        $paypalManager->addField('return', $returnUrl);
        $paypalManager->addField('cancel_return', $cancelUrl);
        $paypalManager->addField('notify_url', $notifyUrl);

        //$paypalManager->dumpFields();   // for printing paypal form fields
        $paypalManager->submitPaypalPost();
    }

    public function actionRenewpaypalnotify() {
        $baseurl = Yii::app()->request->getBaseUrl(true);
        $paypalManager = new Paypal;


        if ($paypalManager->notify() && ( $_POST['payment_status'] == "Completed" || $_POST['payment_status'] == "Pending")) {

            $invoice_number = $_POST['custom'];
            $paymentinfos = PaymentTransaction::model()->find("invoice_number ='" . $invoice_number . "'");
            $result = SupplierTemp::model()->find("invoice_number='$invoice_number'");

            if (!empty($paymentinfos)) {

                $suppid = $paymentinfos->user_id;
                $subscription_type = $paymentinfos->subscription_type;

                if (!empty($result)) {

                    $pdetails = $result->paymentdetails;
                    $pdetails = unserialize($pdetails);
                    /* Update supplier expiry date in supplier table */
                    $smodel = SuppliersDirectory::model()->findByPk($suppid);
                    if ($_POST['payment_status'] == "Completed") {

                        if ($subtype == "1" || $subtype == "2") {
                            $smodel->profile_expirydate = $pdetails['profile_expirydate'];
                        }
                        if ($subtype == "3" || $subtype == "2") {
                            $smodel->logo_expirydate = $pdetails['logo_expirydate'];
                        }
                        $smodel->save(false);

                        /* Update supplier expiry date in payment transation table */
                        if ($subscription_type == "1" || $subscription_type == "2") {
                            $paymentinfos->expirydate = $pdetails['profile_expirydate'];
                        } else if ($subscription_type == "3") {
                            $paymentinfos->expirydate = $pdetails['logo_expirydate'];
                        }
                        $paymentinfos->save(false);

                        SupplierTemp::model()->deleteAll("invoice_number = '" . $invoice_number . "'");
                    }
                }
            } else {


                if (!empty($result)) {

                    $pdetails = $result->paymentdetails;
                    $pdetails = unserialize($pdetails);

                    if (!empty($pdetails)) {

                        $supplierid = $pdetails['user_id'];
                        $subtype = $pdetails['subscription_type'];

                        // Update the expiry date in supplier table once the payment is suceess (Completed)
                        $model = SuppliersDirectory::model()->findByPk($supplierid);
                        if ($_POST['payment_status'] == "Completed") {

                            if ($subtype == "1" || $subtype == "2") {
                                $model->profile_expirydate = $pdetails['profile_expirydate'];
                            }
                            if ($subtype == "3" || $subtype == "2") {
                                $model->logo_expirydate = $pdetails['logo_expirydate'];
                            }
                            $model->save(false);
                        }

                        // Save the payment details                                   
                        $ptmodel = new PaymentTransaction;
                        $ptmodel->user_id = $supplierid;    // need to assign acutal user id
                        $ptmodel->total_price = $pdetails['total_price'];
                        $ptmodel->subscription_price = $pdetails['subscription_price'];
                        $ptmodel->tax = $pdetails['tax'];
                        $ptmodel->payment_status = $_POST['payment_status'];
                        $ptmodel->payer_email = $_POST['payer_email'];
                        $ptmodel->verify_sign = $_POST['verify_sign'];
                        $ptmodel->txn_id = $_POST['txn_id'];
                        $ptmodel->payment_type = $_POST['payment_type'];
                        $ptmodel->receiver_email = $_POST['receiver_email'];
                        $ptmodel->txn_type = $_POST['txn_type'];
                        $ptmodel->item_name = $_POST['item_name'];
                        $ptmodel->NOMTABLE = 'suppliers';
                        if ($subtype == "1" || $subtype == "2") {
                            $ptmodel->expirydate = $pdetails['profile_expirydate'];
                        } else if ($subtype == "3") {
                            $ptmodel->expirydate = $pdetails['logo_expirydate'];
                        }
                        $ptmodel->invoice_number = $_POST['custom'];
                        $ptmodel->pay_type = $pdetails['payment_type'];
                        $ptmodel->subscription_type = $pdetails['subscription_type'];
                        $ptmodel->supp_renew_status = 1;
                        $ptmodel->save();



                        // Remove the temp   
                        if ($_POST['payment_status'] != "Completed") {
                            SupplierTemp::model()->deleteAll("invoice_number = '" . $_POST['custom'] . "'");
                        }

                        /* Send mail to admin for confirmation */
                        $mail = new Sendmail();
                        
                        $user = UserDirectory::model()->findByAttributes(array('ID_RELATION' => $supplierid, 'NOM_TABLE' => 'Fournisseurs'));
                       $suppliers_url = ADMIN_URL . '/admin/userDirectory/update/id/' . $user->ID_UTILISATEUR;
                       $invoice_url = ADMIN_URL . '/admin/paymentTransaction/view/id/' . $ptmodel->id;

                       $enc_url = Myclass::refencryption($suppliers_url);
                       $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;


                       $enc_url2 = Myclass::refencryption($invoice_url);
                       $nextstep_url2 = ADMIN_URL . 'admin/default/login/str/' . $enc_url2;

                       if($this->lang=='EN' ){
                           $subject = SITENAME . $itemname . " notification with invoice details - " . $model->COMPAGNIE;
                       }elseif($this->lang=='FR'){
                           $subject = SITENAME . " - Renouvellement de profil exigeant votre approbation ";
                       }
                        $trans_array = array(
                            "{NAME}" => $model->COMPAGNIE,
                            "{UTYPE}" => 'suppliers',
                            "{NEXTSTEPURL}" => $nextstep_url,
                            "{item_name}" => $_POST['item_name'],
                            "{total_price}" => $pdetails['total_price'],
                            "{payment_status}" => $_POST['payment_status'],
                            "{txn_id}" => $_POST['txn_id'],
                            "{INVOICEURL}" => $nextstep_url2
                        );
                        $message = $mail->getMessage('supplier_renew_subscription', $trans_array);
                        $mail->send(ADMIN_EMAIL, $subject, $message);

                        
                        
                        $nextstep_url = $baseurl . '/optiguide/suppliersDirectory/transactions';
                        $contact_url = $baseurl . '/optiguide/default/contactus';
                        
                        if($this->lang=='EN' ){
                            $subject = SITENAME . " - Thanks for your renewal subscription as a supplier and invoice details.";
                            $message1 = 'Thank you for the renewal of your account in ' . SITENAME.' Website. However, note that your payment status is currently pending.';
                            $message2 = 'Please <a href="' . $contact_url . '">contact</a> admin for further information. ';

                        }elseif($this->lang=='FR'){
                            $subject = SITENAME . " - Renouvellement de votre profil fournisseur";
                            $message1 = 'Nous vous remercions d’avoir renouvelé votre inscription en tant que fournisseur sur le site ' . SITENAME.'. Notez que votre paiement est présentement en traitement.';
                            $message2 = 'Veuillez <a href="' . $contact_url . '">nous contacter</a> pour plus de détails.';
                        }
                        $trans_array = array(
                            "{NAME}" => $model->COMPAGNIE,
                            "{NEXTSTEPURL}" => $nextstep_url,
                            "{message1}" => $message1,
                            "{message2}" => $message2,
                            "{item_name}" => $_POST['item_name'],
                            "{pay_type}" => $ptmodel->payment_type,
                            "{total_price}" => $pdetails['total_price'],
                            "{payment_status}" => 'Completed',
                            "{txn_id}" => $_POST['txn_id'],
                        );
                        $message = $mail->getMessage('supplier_frontend_subscription_account', $trans_array);
                        if ($user->COURRIEL != '') {
                            $mail->send($user->COURRIEL, $subject, $message);
                        }
                    }
                }
            }
        }
    }

    public function actionRenewpaypalreturn() {

        $pstatus = $_POST["payment_status"];

        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', Myclass::t('OGO132', '', 'og'));
            } else {
                Yii::app()->user->setFlash('success', Myclass::t('OGO188', '', 'og'));
            }
        } else {
            Yii::app()->user->setFlash('danger', Myclass::t('OGO133', '', 'og'));
        }
        $this->redirect(array('renewsubscription'));
    }

    public function actionRenewpaypalcancel() {

        Yii::app()->user->setFlash('warning', Myclass::t('OGO134', '', 'og'));
        $this->redirect(array('renewsubscription'));
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
