<?php

class PaymentTransactionController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete','reptransaction'),
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PaymentTransaction'])) {
            $model->attributes = $_POST['PaymentTransaction'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'PaymentTransaction status Updated Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new PaymentTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentTransaction']))
            $model->attributes = $_GET['PaymentTransaction'];

        $this->render('index', array(
            'model' => $model,
        ));
    }
    
     /**
     * Lists all models.
     */
    public function actionReptransaction() {
        $model = new PaymentTransaction('searchrep');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentTransaction']))
            $model->attributes = $_GET['PaymentTransaction'];

        $this->render('reptransaction', array(
            'model' => $model,
        ));
    }
    
    

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PaymentTransaction the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PaymentTransaction::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PaymentTransaction $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-transaction-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
