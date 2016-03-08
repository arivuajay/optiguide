<?php

class ArchiveCategoryController extends Controller {
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
                 'expression'=> 'AdminIdentity::checkAccess()',
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
        $model = new ArchiveCategory;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ArchiveCategory'])) {
            $model->attributes = $_POST['ArchiveCategory'];
            if ($model->save()) {
                $msg = Myclass::t('APP33')." ".Myclass::t('APP501');
                Yii::app()->user->setFlash('success', $msg);
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

        if (isset($_POST['ArchiveCategory'])) {
            $model->attributes = $_POST['ArchiveCategory'];
            if ($model->save()) {
                $msg = Myclass::t('APP33')." ".Myclass::t('APP502');
                Yii::app()->user->setFlash('success', $msg);
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        
        
        $models = $this->loadModel($id)->archiveFichiers;
        foreach ($models as $model){
            
            //news management
            $news_managements = NewsManagement::model()->findAll('ID_FICHIER='.$model->ID_FICHIER);
            if(!empty($news_managements)){
                foreach ($news_managements as $newsm){
                    $news = NewsManagement::model()->findByPk($newsm->ID_NOUVELLE);
                    echo "news -".$newsm->ID_NOUVELLE;
                    $news->ID_FICHIER = '0';
                    $news->save(false);
                }
            }
            
            //Publicity Ads
            $publicity_ads = PublicityAds::model()->findAll('ID_FICHIER='.$model->ID_FICHIER);
            if(!empty($publicity_ads)){
                foreach ($publicity_ads as $publicity_ad){
                    $ads = PublicityAds::model()->findByPk($publicity_ad->ID_PUBLICITE);
                    echo "publicity -".$publicity_ad->ID_PUBLICITE;
                    $ads->ID_FICHIER = '0';
                    $ads->save(false);
                }
            }
            
            //CalenderEvent
            $calender_events = CalenderEvent::model()->findAll('iId_fichier='.$model->ID_FICHIER);
            if(!empty($calender_events)){
                foreach ($calender_events as $calender_event){
                    $events = CalenderEvent::model()->findByPk($calender_event->ID_EVENEMENT);
                    echo "Calender -".$calender_event->ID_EVENEMENT;
                    $events->iId_fichier = '0';
                    $events->save(false);
                }
            }
            
            //SuppliersDirectory
            $suppliers = SuppliersDirectory::model()->findAll('iId_fichier='.$model->ID_FICHIER);
            if(!empty($suppliers)){
                foreach ($suppliers as $supplier){
                    $supp = SuppliersDirectory::model()->findByPk($supplier->ID_FOURNISSEUR);
                    echo "Supplier -".$supplier->ID_FOURNISSEUR;
                    $supp->iId_fichier = '0';
                    $supp->save(false);
                }
            }
        }
        
        //ArchiveFichier
        ArchiveFichier::model()->deleteAll('ID_CATEGORIE='.$id);
        
        $this->loadModel($id)->delete();
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $msg = Myclass::t('APP33')." ".Myclass::t('APP503');
            Yii::app()->user->setFlash('success',$msg);
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ArchiveCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ArchiveCategory']))
            $model->attributes = $_GET['ArchiveCategory'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ArchiveCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ArchiveCategory']))
            $model->attributes = $_GET['ArchiveCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ArchiveCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ArchiveCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Myclass::t('APP506'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ArchiveCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'archive-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
