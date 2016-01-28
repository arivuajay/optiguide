<?php

class ArchiveFichierController extends Controller {
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
        $model = new ArchiveFichier('create');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $getallcat = ArchiveFichier::get_allcategory();
        
        $path = Yii::getPathOfAlias('webroot').'/'. ARCHIVE_IMG_PATH;

        if (isset($_POST['ArchiveFichier'])) {
            
            $model->attributes = $_POST['ArchiveFichier'];     
            
            if($model->validate())
            {              
                $model->image     = CUploadedFile::getInstance($model,'image');
                $imgname = time().'_'.$model->image->name;
                $model->FICHIER   = $imgname;
                $model->EXTENSION = $model->image->extensionName;
                
                $catid =  $_POST['ArchiveFichier']['ID_CATEGORIE'];
                $cat_img_path =  $path.$catid.'/';
                
                if (!is_dir($cat_img_path)) 
                {
                    mkdir($cat_img_path,0777, true);        
                }
                
                $model->image->saveAs($cat_img_path .$imgname);
                
                if($model->save())
                {
                   
                    // redirect to success page
                    Yii::app()->user->setFlash('success', 'ArchiveFichier Created Successfully!!!');
                    $this->redirect(array('index', 'id'=>$model->ID_CATEGORIE));
                }
            }
        }

        $this->render('create', compact('model', 'getallcat'));
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

        $getallcat = ArchiveFichier::get_allcategory();
        
        $path = Yii::getPathOfAlias('webroot').'/'. ARCHIVE_IMG_PATH;

        if (isset($_POST['ArchiveFichier'])) {
            
            $model->attributes = $_POST['ArchiveFichier'];     
            
            if($model->validate())
            {              
                $model->image     = CUploadedFile::getInstance($model,'image');
                if( $model->image)
                {     
                    $imgname = time().'_'.$model->image->name;
                    $model->FICHIER   = $imgname;
                    $model->EXTENSION = $model->image->extensionName;

                    $catid =  $_POST['ArchiveFichier']['ID_CATEGORIE'];
                    $cat_img_path =  $path.$catid.'/';

                    if (!is_dir($cat_img_path)) 
                    {
                        mkdir($cat_img_path,0777, true);        
                    }

                    $model->image->saveAs($cat_img_path .$imgname);
                }
                
                if($model->save())
                {                   
                    // redirect to success page
                    Yii::app()->user->setFlash('success', 'ArchiveFichier Created Successfully!!!');
                    $this->redirect(array('index', 'id'=>$model->ID_CATEGORIE));
                }
            }
        }

        $this->render('update', compact('model', 'getallcat'));
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
            Yii::app()->user->setFlash('success', 'ArchiveFichier Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ArchiveFichier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ArchiveFichier']))
            $model->attributes = $_GET['ArchiveFichier'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ArchiveFichier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ArchiveFichier']))
            $model->attributes = $_GET['ArchiveFichier'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ArchiveFichier the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ArchiveFichier::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ArchiveFichier $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'archive-fichier-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
