<?php

class RetailerDirectoryController extends Controller {
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
        return array_merge(
                
           parent::accessRules(), 
            array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array(''),
                    'users' => array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'getgroups'),
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
        $model  = new RetailerDirectory;
        $umodel = new UserDirectory();

        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['RetailerDirectory'])) {
            $model->attributes = $_POST['RetailerDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
     
            $model->ID_CLIENT = $umodel->USR;

            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
            $umodel->PWD     = Myclass::getRandomString(5);
            $umodel->sGuid   = Myclass::getGuid();
            $umodel->LANGUE  = "FR";          
            
            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
                $model->save(false);
                $umodel->ID_RELATION = $model->ID_RETAILER;
                $umodel->save(false);

                Yii::app()->user->setFlash('success', 'Détaillant créé avec succès!!!');
                $this->redirect(array('index'));
            } else {
                var_dump($model->errors);
                 var_dump($umodel->errors);
            }
        }

        $this->render('create', compact('umodel', 'model'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $umodel));

        if (isset($_POST['RetailerDirectory'])) {
            $model->attributes = $_POST['RetailerDirectory'];
            $umodel->attributes = $_POST['UserDirectory'];
            $umodel->NOM_TABLE = $model::$NOM_TABLE;
            $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;

            $valid = $umodel->validate();
            $valid = $model->validate() && $valid;

            if ($valid) {
                $umodel->save(false);
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Détaillant correctement mis à jour!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('update', compact('umodel', 'model'));
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
            Yii::app()->user->setFlash('success', 'RetailerDirectory Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model  = new RetailerDirectory('search');
      //  $umodel = new UserDirectory();
        
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RetailerDirectory']))
            $model->attributes  = $_GET['RetailerDirectory'];
         //   $umodel->attributes = $_GET['UserDirectory'];

        $this->render('index', array(
            'model' => $model,
          //  'umodel' => $umodel,
        ));
    }

    public function actionGetGroups() {
        $options = '';
        $cid = isset($_POST['id']) ? $_POST['id'] : '';
        $options = "<option value=''>Sélectionnez le groupe</option>";
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new RetailerDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RetailerDirectory']))
            $model->attributes = $_GET['RetailerDirectory'];

        $this->render('admin', array(
            'model' => $model,
        ));
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
