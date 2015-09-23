<?php

class RepCredentialController extends Controller {

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
        );
    }

    public function actionIndex() {
        $model = new RepCredentials('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RepCredentials'])) {
            $model->attributes = $_GET['RepCredentials'];
            $model->search();
        }

        $this->render('index', compact('model'));
    }
    
    public function actionView($id){
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
            'profile' => $model->repCredentialProfiles,
        ));
    }
    
    public function loadModel($id) {
        $model = RepCredentials::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
