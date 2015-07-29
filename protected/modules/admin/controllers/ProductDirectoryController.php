<?php

class ProductDirectoryController extends Controller {
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
        $model = new ProductDirectory;


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ProductDirectory'])) {
            $model->attributes = $_POST['ProductDirectory'];

            if ($model->save()) {
                if (isset($_POST['ProductDirectory']['Marques2'])) {
                    $Marques2 = $_POST['ProductDirectory']['Marques2'];

                    foreach ($Marques2 as $info) {
                        $marqueproduct = new ProductMarqueDirectory;
                        $values["ID_PRODUIT"] = $model->ID_PRODUIT;
                        $values["ID_MARQUE"] = $info;

                        $marqueproduct->attributes = $values;
                        $marqueproduct->save();
                    }
                }
                Yii::app()->user->setFlash('success', 'Produit créé avec succès avec des marques!!!');
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

        if (isset($_POST['ProductDirectory'])) {
            $model->attributes = $_POST['ProductDirectory'];
            if ($model->save()) {
                
                ProductMarqueDirectory::model()->deleteAll("ID_PRODUIT ='" . $id . "'");
                if (isset($_POST['ProductDirectory']['Marques2'])) {
                    $Marques2 = $_POST['ProductDirectory']['Marques2'];
                    foreach ($Marques2 as $info) {
                        $marqueproduct = new ProductMarqueDirectory;
                        $values["ID_PRODUIT"] = $model->ID_PRODUIT;
                        $values["ID_MARQUE"] = $info;

                        $marqueproduct->attributes = $values;
                        $marqueproduct->save();
                    }
                }
                
                Yii::app()->user->setFlash('success', 'Produit à jour avec succès!!!');
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'ProductDirectory Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ProductDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductDirectory']))
            $model->attributes = $_GET['ProductDirectory'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProductDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductDirectory']))
            $model->attributes = $_GET['ProductDirectory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-directory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
