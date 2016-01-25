<?php

class MasterroleController extends Controller {
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
                //'expression'=> 'AdminIdentity::checkAccess()',
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
        $model = new MasterRole;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MasterRole'])) {
            $model->attributes = $_POST['MasterRole'];
            if ($model->save()) {
                Myclass::addAuditTrail("Created Role {$model->Role_Code} successfully.", "music");
                Yii::app()->user->setFlash('success', 'MasterRole Created Successfully!!!');
                //$this->redirect(array('view','id'=>$model->Master_Role_ID));
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
       
//        if(!UserIdentity::checkPrivilages($model->Rank)){
//            throw new CHttpException(403, 'You are not authorized to perform this action');
//        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MasterRole'])) {
            $model->attributes = $_POST['MasterRole'];
            if ($model->save()) {               
                Yii::app()->user->setFlash('success', 'MasterRole Updated Successfully!!!');
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
        try {
            $model = $this->loadModel($id);
//            if(!UserIdentity::checkPrivilages($model->Rank)){
//                throw new CHttpException(403, 'You are not authorized to perform this action');
//            }
            $model->delete();
            
        } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451) {
                throw new CHttpException(400, Yii::t('err', 'Relation Restriction Error.'));
            } else {
                throw $e;
            }
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'MasterRole Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $search = false;

        $model = new MasterRole();
        $searchModel = new MasterRole('search');
        $searchModel->unsetAttributes();  // clear any default values
        if (isset($_GET['MasterRole'])) {
            $search = true;
            $searchModel->attributes = $_GET['MasterRole'];
            $searchModel->search();
        }

        $this->render('index', compact('searchModel', 'search', 'model'));

    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MasterRole('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MasterRole']))
            $model->attributes = $_GET['MasterRole'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MasterRole the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MasterRole::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MasterRole $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'master-role-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
