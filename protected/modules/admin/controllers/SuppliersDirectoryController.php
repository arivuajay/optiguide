<?php

class SuppliersDirectoryController extends Controller {
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
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'getproducts', 'addproducts', 'addmarques', 'listmarques'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        
        $data_products = array();

        $model = $this->loadModel($id);
        $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));        
        
        $mattributes = $model->attributes;
        $uattributes = $umodel->attributes;

        Yii::app()->user->setState("mattributes", $mattributes);
        Yii::app()->user->setState("uattributes", $uattributes);

        // Set and intialize session from existing database records.         
        if (Yii::app()->user->hasState("product_ids") == FALSE) 
        {     
            $fid = $id;
            $criteria1 = new CDbCriteria();
            $criteria1->condition = 'ID_FOURNISSEUR=:id';
            $criteria1->params = array(':id' => $fid);
            $criteria1->group = 'productMarqueDirectory.ID_PRODUIT';
            $get_selected_products = CHtml::listData(SupplierProducts::model()->with("productMarqueDirectory")->findAll($criteria1), 'ID_LIEN_REPERTOIRE_PRODUIT', 'productMarqueDirectory.ID_PRODUIT');

            /* Set products in session */
            if (!empty($get_selected_products)) 
            {
                foreach ($get_selected_products as $pinfo) {
                    $result[] = $pinfo;
                }
                Yii::app()->user->setState("product_ids", $result);                
                $data_products = SuppliersDirectory::getproducts($result);

                /* Set marques in session */
                foreach ($result as $pid) {
                    $prodid = $pid;
                    $criteria1 = new CDbCriteria();
                    $criteria1->condition = "ID_FOURNISSEUR=:fid AND productMarqueDirectory.ID_PRODUIT=:pid";
                    $criteria1->params = array(":fid" => $fid, ":pid" => $prodid);
                    $get_selected_marques = CHtml::listData(SupplierProducts::model()->with("productMarqueDirectory")->findAll($criteria1), 'ID_LIEN_REPERTOIRE_PRODUIT', 'productMarqueDirectory.ID_MARQUE');

                    if (!empty($get_selected_marques)) 
                    {
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

                if (!empty($marque_ids)) {
                    Yii::app()->user->setState("marque_ids", $marque_ids);
                }
            }
        }
         

        if (isset($_POST['SuppliersDirectory'])) 
        {
            $model->attributes = $_POST['SuppliersDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;

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
               
                $model->save(false);  
                $umodel->save(false);

                Yii::app()->user->setState("mattributes", $mattributes);
                Yii::app()->user->setState("uattributes", $uattributes);
                Yii::app()->user->setState("secondtab", "2");

                $this->redirect(array('addproducts'));
            }
        }
        
        if(Yii::app()->user->hasState("product_ids"))
        {    
            $proids = Yii::app()->user->getState("product_ids");
            $data_products = SuppliersDirectory::getproducts($proids);
        }   

        $tab = 1;
        $this->render('update', compact('umodel', 'model', 'tab','data_products'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    
    /*
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
     *      */
    public function actionCreate() {
        
        

        $model = new SuppliersDirectory;
        $umodel = new UserDirectory();

        if(Yii::app()->user->hasState("secondtab") || Yii::app()->user->hasState("thirdtab"))
        {    
            //check if session exists
            if (Yii::app()->user->hasState("mattributes")) {
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
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['SuppliersDirectory'])) {

            $model->attributes = $_POST['SuppliersDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];

            $model->ID_CLIENT = $umodel->USR;

            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
            $umodel->PWD = Myclass::getRandomString(5);
            $umodel->sGuid = Myclass::getGuid();
            $umodel->LANGUE  = "FR";

            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
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
            }else
            {
                $errores = $model->getErrors();
                print_r($errores);
               
            }    
        }
        $tab = 1;
        $this->render('create', compact('umodel', 'model', 'tab'));
    }

    //TAB 2
    public function actionAddproducts() {

        $data_products = array();
        
        if (Yii::app()->user->hasState("mattributes")) {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
        }
         
        /* Set session value for edit form */
        if (!empty($sess_attr_m)) 
        {
            //Check for update form
            if (isset($sess_attr_m['ID_FOURNISSEUR'])) 
             {
                $result = array();
                $fid = $sess_attr_m['ID_FOURNISSEUR'];
                $model = $this->loadModel($fid);
                $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");               
            } else {
                // For create form
                $model  = new SuppliersDirectory;
                $umodel = new UserDirectory();
            }
        }
        //check if session exists
        if (Yii::app()->user->hasState("mattributes")) 
        {
            //get session variable
            $model->attributes = $sess_attr_m;
            $sess_attr_u = Yii::app()->user->getState("uattributes");
            $umodel->attributes = $sess_attr_u;
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
        if (isset($sess_attr_m['ID_FOURNISSEUR'])) {
            $viewpage = 'update';
        } else {
            $viewpage = 'create';
        }
        $this->render($viewpage, compact('umodel', 'model', 'tab','data_products'));
    }

    public function actionAddmarques() {
        // Yii::app()->user->setState("marque_ids", null);
        
        
        $sess_product_ids = array();
        $data_products = array();
        
        if (Yii::app()->user->hasState("mattributes")) {
            $sess_attr_m = Yii::app()->user->getState("mattributes");
        }
     
        if (!empty($sess_attr_m))
        {
            //Check for update form
            if (isset($sess_attr_m['ID_FOURNISSEUR'])) 
            {
                $fid = $sess_attr_m['ID_FOURNISSEUR'];
                $model = $this->loadModel($fid);
                $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");
            } else {
                $model = new SuppliersDirectory;
                $umodel = new UserDirectory();
            }
        }       
        
        //check if session exists
        if (Yii::app()->user->hasState("mattributes")) {
            //get session variable         
            $model->attributes = $sess_attr_m;
            $sess_attr_u = Yii::app()->user->getState("uattributes");
            $umodel->attributes = $sess_attr_u;
        }
        
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

            if (Yii::app()->user->hasState("mattributes") && Yii::app()->user->hasState("uattributes")) {
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

            Yii::app()->user->setFlash('success', 'Supplier Created Successfully!!!');
            $this->redirect(array('index'));
        }

        // Delete products from session
        if (isset($_POST['yt3'])) {
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
                Yii::app()->user->setFlash('danger', 'Please select any products to delete!!!');
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
     
        if (isset($sess_attr_m['ID_FOURNISSEUR'])) {
            $viewpage = 'update';
        } else {
            $viewpage = 'create';
        }
       
        $this->render($viewpage, compact('umodel', 'model', 'tab', 'data_products'));
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

            if (isset($_POST) && $_POST['yt0'] == "Save") {
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

    public function actionGetproducts() {
        $options = '';
        $sid = isset($_POST['id']) ? $_POST['id'] : '';
        if ($sid != '') {
            $criteria = new CDbCriteria;
            $criteria->order = 'NOM_PRODUIT_FR ASC';
            $criteria->condition = 'ID_SECTION=:id';
            $criteria->params = array(':id' => $sid);
            $data_products = CHtml::listData(ProductDirectory::model()->findAll($criteria), 'ID_PRODUIT', 'NOM_PRODUIT_FR');
            foreach ($data_products as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'SuppliersDirectory Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
       
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
       
        $model = new SuppliersDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SuppliersDirectory']))
            $model->attributes = $_GET['SuppliersDirectory'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SuppliersDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SuppliersDirectory']))
            $model->attributes = $_GET['SuppliersDirectory'];

        $this->render('admin', array(
            'model' => $model,
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
