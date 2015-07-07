<?php

class UsersController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//	public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view', 'changestatus', 'deletemultiple'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
        $model = new Users('admin_register');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $password = Myclass::getRandomString(8);
            $model->password = Myclass::encrypt($password);
            $valid = $model->validate();
            if ($valid):
                $model->save(false);
                if (!empty($model->useremail)):
                    $mail = new Sendmail();
                    $nextstep_url = Yii::app()->createAbsoluteUrl('/site/default/login');
                    $subject = "Registraion Mail From - " . SITENAME;
                    $trans_array = array(
                        "{SITENAME}" => SITENAME,
                        "{STAFF_NAME}" => $profModel->first_name,
                        "{EMAIL_ID}" => $model->useremail,
                        "{STAFF_PASSWORD}" => $password,
                        "{NEXTSTEPURL}" => $nextstep_url,
                    );
                    $message = $mail->getMessage('staffregister', $trans_array);
                    $mail->send($model->useremail, $subject, $message);
                    $this->redirect(array('index'));
                endif;
            endif;
        }

        $this->render('create', compact('model', 'profModel'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $valid = $model->validate();
            if ($valid):
                $model->save(false);
                $this->redirect(array('index'));
            endif;
        }

        $this->render('update', compact('model'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $user = $this->loadModel($id);

        if (empty($user))
            throw new CHttpException(404, 'The requested page does not exist.');

//        $user->setAttribute('user_status', '2');
//        if($user->save()){
        Diary::model()->deleteAll("diary_user_id = $id");
        Entry::model()->deleteAll("temp_activation_key = '$user->user_activation_key'");
        $user->delete();
        Yii::app()->user->setFlash('success', 'You have deleted successfully');
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//        }else{
//            Yii::app()->user->setFlash('error', 'Faield to delete');
//        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "user_status != '2'";
        $Criteria->order = 'created DESC';
        $users = Users::model()->findAll($Criteria);

        $this->render('index', array(
            'users' => $users,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionChangestatus($id) {
        $user = $this->loadModel($id);
        $user->user_status = ($user->user_status == 0) ? 1 : 0;
        if ($user->save(false)) {
            $user->user_status == 0 ? $status = 'In-Active' : $status = 'Active';
            echo '"' . $user->user_name . '" status: ' . $status;
        } else {
            echo 'Error while changing status !!!';
        }
    }

    public function actionDeletemultiple() {
        $return = array();
        foreach ($_POST['id'] as $id) {
            $user = $this->loadModel($id);
            Diary::model()->deleteAll("diary_user_id = $id");
            Entry::model()->deleteAll("temp_activation_key = '$user->user_activation_key'");

            if ($user->delete()) {
                $return['sts'] = 'success';
                $return['text'] = 'Selected Users deleted successfully';
            } else {
                $return['sts'] = 'fail';
                $return['text'] = 'Failed to delete this user: ' . $user->user_name;
                echo json_encode($return);
                exit;
            }
        }
        echo json_encode($return);
    }

}
