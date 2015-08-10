<?php

class PublicityAdsController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PublicityAds;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PublicityAds'])) {
            $model->attributes = $_POST['PublicityAds'];

            if ($model->PRIORITE == "0") {
                $model->DATE_DEBUT = $_POST['PublicityAds']['DATE_DEBUT'];
                $model->DATE_FIN   = $_POST['PublicityAds']['DATE_FIN'];
            } elseif ($model->PRIORITE == "1") {
                $model->NB_IMPRESSIONS = $_POST['PublicityAds']['NB_IMPRESSIONS'];
            }

            $publicityModules = isset($_POST['PublicityAds']['publicityModules']) ? $_POST['PublicityAds']['publicityModules'] : array();
            $regions = isset($_POST['PublicityAds']['regions']) ? $_POST['PublicityAds']['regions'] : array();
            $section = isset($_POST['PublicityAds']['section']) ? $_POST['PublicityAds']['section'] : array();

            if ($model->save()) {

                $publicite_id = $model->ID_PUBLICITE;

                // Store selected section values
                if (!empty($section)) {
                    foreach ($section as $sinfo) {
                        $clmodel = new AdsLInkCategory();
                        $clmodel->ID_PUBLICITE = $publicite_id;
                        $clmodel->ID_SECTION   = $sinfo;
                        $clmodel->save(false);
                    }
                }

                // Store selected module values                       
                if (!empty($publicityModules)) {
                    foreach ($publicityModules as $minfo) {
                        $mlmodel = new AdsLInkModule();
                        $mlmodel->ID_PUBLICITE = $publicite_id;
                        $mlmodel->ID_MODULE = $minfo;
                        $mlmodel->save(false);
                    }
                }

                // Store selected region values                       
                if (!empty($regions)) {
                    foreach ($regions as $rinfo) {
                        $rlmodel = new AdsLInkRegion();
                        $rlmodel->ID_PUBLICITE = $publicite_id;
                        $rlmodel->ID_REGION = $rinfo;
                        $rlmodel->save(false);
                    }
                }

                Yii::app()->user->setFlash('success', 'PublicityAds Created Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PublicityAds'])) {
            $model->attributes = $_POST['PublicityAds'];

            if ($model->PRIORITE == "0") {
                $model->DATE_DEBUT = $_POST['PublicityAds']['DATE_DEBUT'];
                $model->DATE_FIN = $_POST['PublicityAds']['DATE_FIN'];
            } elseif ($model->PRIORITE == "1") {
                $model->NB_IMPRESSIONS = $_POST['PublicityAds']['NB_IMPRESSIONS'];
            }

            $publicityModules = isset($_POST['PublicityAds']['publicityModules']) ? $_POST['PublicityAds']['publicityModules'] : array();
            $regions = isset($_POST['PublicityAds']['regions']) ? $_POST['PublicityAds']['regions'] : array();
            $section = isset($_POST['PublicityAds']['section']) ? $_POST['PublicityAds']['section'] : array();

            if ($model->save()) {

                $publicite_id = $model->ID_PUBLICITE;
                
                AdsLInkCategory::model()->deleteAll("ID_PUBLICITE ='" . $publicite_id . "'");
                AdsLInkModule::model()->deleteAll("ID_PUBLICITE ='" . $publicite_id . "'");
                AdsLInkRegion::model()->deleteAll("ID_PUBLICITE ='" . $publicite_id . "'");
                // Store selected section values
                
                if (!empty($section)) {
                   
                    foreach ($section as $sinfo) {
                        $clmodel = new AdsLInkCategory();
                        $clmodel->ID_PUBLICITE = $publicite_id;
                        $clmodel->ID_SECTION = $sinfo;
                        $clmodel->save(false);
                    }
                }

                // Store selected module values    
              
                if (!empty($publicityModules)) {
                    
                    foreach ($publicityModules as $minfo) {
                        $mlmodel = new AdsLInkModule();
                        $mlmodel->ID_PUBLICITE = $publicite_id;
                        $mlmodel->ID_MODULE = $minfo;
                        $mlmodel->save(false);
                    }
                }

                // Store selected region values                       
                if (!empty($regions)) {
                    
                    foreach ($regions as $rinfo) {
                        $rlmodel = new AdsLInkRegion();
                        $rlmodel->ID_PUBLICITE = $publicite_id;
                        $rlmodel->ID_REGION = $rinfo;
                        $rlmodel->save(false);
                    }
                }

                Yii::app()->user->setFlash('success', 'Publicité mis à jour avec succès!!!');
                $this->redirect(array('index'));
            }
        }
        
        $selected_regions = array();
        $qry_selected_regions = AdsLInkRegion::model()->findAll(array('condition'=>"ID_PUBLICITE=$id"));              
        if(!empty($qry_selected_regions))
        {    
            foreach($qry_selected_regions as $reginfo)
            {
                $pubregid =  $reginfo['ID_REGION'];  
                $selected_regions[$pubregid]['selected'] =  'selected';               
            }            
        } 
        
        $selected_modules = array();
        $qry_selected_modules = AdsLInkModule::model()->findAll(array('condition'=>"ID_PUBLICITE=$id"));              
        if(!empty($qry_selected_modules))
        {    
            foreach($qry_selected_modules as $modinfo)
            {
                $pubmodid =  $modinfo['ID_MODULE'];  
                $selected_modules[$pubmodid]['selected'] =  'selected';               
            }            
        } 
        
        $selected_sections = array();
        $qry_selected_category = AdsLInkCategory::model()->findAll(array('condition'=>"ID_PUBLICITE=$id"));              
        if(!empty($qry_selected_category))
        {    
            foreach($qry_selected_category as $catinfo)
            {
                $pubcatid =  $catinfo['ID_SECTION'];  
                $selected_sections[$pubcatid]['selected'] =  'selected';               
            }            
        } 
        
        $this->render('update', compact('model','selected_regions','selected_modules','selected_sections'));
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
            Yii::app()->user->setFlash('success', 'PublicityAds Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new PublicityAds('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PublicityAds']))
            $model->attributes = $_GET['PublicityAds'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new PublicityAds('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PublicityAds']))
            $model->attributes = $_GET['PublicityAds'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PublicityAds the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PublicityAds::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PublicityAds $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'publicity-ads-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
