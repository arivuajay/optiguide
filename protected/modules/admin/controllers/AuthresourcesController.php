<?php

class AuthresourcesController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'user', 'role', 'getscreensbymodule', 'society'),
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
        $model = new AuthResources;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['AuthResources'])) {
            $model->attributes = $_POST['AuthResources'];
            if ($model->save()) {
                Myclass::addAuditTrail("Created Auth Resources successfully.", "users");

                Yii::app()->user->setFlash('success', 'AuthResources Created Successfully!!!');
                //$this->redirect(array('view','id'=>$model->Master_Resource_ID));
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

        if (isset($_POST['AuthResources'])) {
            $model->attributes = $_POST['AuthResources'];
            if ($model->save()) {
                Myclass::addAuditTrail("Updated Auth Resources successfully.", "users");
                Yii::app()->user->setFlash('success', 'AuthResources Updated Successfully!!!');
//				$this->redirect(array('view','id'=>$model->Master_Resource_ID));
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
            $this->loadModel($id)->delete();

            Myclass::addAuditTrail("Deleted Auth Resources successfully.", "group");
        } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451) {
                throw new CHttpException(400, Yii::t('err', 'Relation Restriction Error.'));
            } else {
                throw $e;
            }
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'AuthResources Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new AuthResources('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AuthResources']))
            $model->attributes = $_GET['AuthResources'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AuthResources('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AuthResources']))
            $model->attributes = $_GET['AuthResources'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AuthResources the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AuthResources::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AuthResources $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'auth-resources-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUser($uid = null) {
        $model = new AuthResources();
        if ($uid)
            $model->Master_User_ID = $uid;

        return $this->render('user_base', compact('model'));
    }

    public function actionRole($rid = null) {
        $model = new AuthResources();
        if ($rid)
            $model->Master_Role_ID = $rid;

        return $this->render('role_base', compact('model'));
    }

    public function actionSociety($sid = null) {
        $model = new AuthResources();
        if ($sid)
            $model->Master_Society_ID = $sid;

        return $this->render('society_base', compact('model'));
    }

    public function actionGetscreensbymodule() {
        $mid = $id = $type = '';
        if (isset($_GET['mid']) && isset($_GET['id']) && isset($_GET['type'])) {
            $mid = $_GET['mid'];
            $id = $_GET['id'];
            $type = $_GET['type'];
        }
        $model = new AuthResources();
        $masters = MasterScreen::model()->isActive()->findAllByAttributes(array('Module_ID' => $mid));

        if ($type != '') {
            $u_type = ucfirst($type);
           // echo "Master_{$u_type}_ID"; exit;
            $exist_resources = AuthResources::model()->with('masterScreen')->findAllByAttributes(array('Master_Module_ID' => $mid, "Master_{$u_type}_ID" => $id));
        }

        if (Yii::app()->request->isPostRequest) {
            $valid = true;           
            foreach ($_POST['AuthResources'] as $data) {
                if (is_array($data)) {
                    $model = !isset($data['Master_Resource_ID']) ? new AuthResources : $this->loadModel($data['Master_Resource_ID']);
                    $model->attributes = $data;   
                    if($model->save())
                    {    
                        $flag = true;
                    }else{
           
                        $errores = $model->getErrors();
                        print_r($errores);
                        exit;
            
                    }    
                }
            }
            if ($valid) {
                Yii::app()->user->setFlash('success', 'Changes saved successfully!!!');               
                return $this->redirect(array('/admin/masterrole/index'));
            }
        } else {
            return $this->renderPartial('_screen_by_module', compact('masters', 'exist_resources', 'model', 'id', 'type', 'mid', 'u_type'));
        }
    }

}
