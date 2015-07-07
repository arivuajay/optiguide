<?php

class DefaultController extends Controller {

    public $pageTitle = 'Admin';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'forgotpassword'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'index', 'profile', 'changepassword'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        if (Yii::app()->user->isGuest):
            $this->redirect(array('login'));
        endif;

        $this->render('index');
    }

    public function actionLogin() {
        $this->layout = '//layouts/login';
        $model = new AdminLoginForm;
        // collect user input data
        if (isset($_POST['AdminLoginForm'])) {
            $model->attributes = $_POST['AdminLoginForm'];
            if ($model->validate() && $model->login()):
                $this->redirect(array('index'));
            endif;
        }
        $this->render('login', compact('model'));
    }
    
    public function actionProfile() {
        $id = Yii::app()->user->id;
        $model = Admin::model()->findByPk($id);
        $model->setScenario('update');
        $this->performAjaxValidation($model);

        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            if ($model->validate()):
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Profile updated successfully');
                $this->redirect(array('profile'));
            endif;
        }
        $this->render('profile', compact('model'));
    }
    
    public function actionLogout() {
        Yii::app()->user->logout(false);
        $this->redirect('login');
    }

    public function actionForgotpassword() {
        $this->layout = '//layouts/login';
        $newmodel = new Admin('forgotpassword');
        $newmodel->setScenario('forgotpassword');
        if (isset($_POST['Admin'])):
            $newmodel->attributes = $_POST['Admin'];
            if ($newmodel->validate()):
                $admin = Admin::model()->find('admin_email ="' . $newmodel->admin_email . '"');
                if ($admin) {
                    $adminmodel = $this->loadModel($admin->admin_id);
                    $fullname = $adminmodel->admin_name;
                    $password = Myclass::getRandomString('8');
                    $adminmodel->admin_password = Myclass::encrypt($password);
                    $adminmodel->save(false);
//                    Yii::app()->user->setFlash('success', 'Your account password has been reset. Please check your email');
                    $loginlink = Yii::app()->createAbsoluteUrl('/admin/default/login');

                    $mail = new Sendmail;
                    $trans_array = array(
                        "{NAME}" => ucfirst($fullname),
                        "{USEREMAIL}" => $adminmodel->admin_username,
                        "{USEREPASS}" => $password,
                        "{NEXTSTEPURL}" => $loginlink,
                        "{CONTACT}" => CONTACTMAIL,
                    );
                    $message = $mail->getMessage('adminforgotpassword', $trans_array);
                    $Subject = $mail->translate('Reset Password From {SITENAME}');
                    $mail->send($newmodel->admin_email, $Subject, $message);
                    Yii::app()->user->setFlash('success', 'Your account password has been reset. Please check your email for new password');
                    $this->redirect('login');
                } else {
                    Yii::app()->user->setFlash('danger', 'Email address is not valid.');
                    $this->redirect('forgotpassword');
                }
            endif;

        endif;

        $this->render('forgotpassword', array('newmodel' => $newmodel));
    }

    public function loadModel($id) {
        $model = Admin::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionSettings() {
        $model = $this->loadModel(Yii::app()->user->id);
        $model->setScenario('update');
        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            if ($model->validate()) {
                $model->save(false);
                Yii::app()->user->setFlash('success', Yii::t('admin', 'ADMIN331'));
                $this->redirect('index');
            }
        }
        $this->render('settings', array('model' => $model));
    }

    public function actionChangepassword() {
        $id = Yii::app()->user->id;
        $model = Admin::model()->findByPk($id);
        $model->setScenario('changepassword');
        $model->admin_password = '';
        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            if ($model->validate()) {
                $model->admin_password = Myclass::encrypt($_POST['Admin']['current_password']);
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Password changed successfullly');
                $this->redirect(array('changepassword'));
            }
        }
        $this->render('changepassword', compact('model'));
    }

    public function actionPlan() {
        $model = new Subscriptions;

        if (isset($_POST['Subscriptions'])) {
            $model->attributes = $_POST['Subscriptions'];
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('subscriptions'));
            }
        }
        $this->render('plan', compact('model'));
    }

    public function actionSubscriptions() {
        $subscriptions = Subscriptions::model()->findAll();
        $this->render('subscriptions', compact('subscriptions'));
    }

    public function actionPlandelete($id) {
        $model = Subscriptions::model()->findByPk($id);
        $model->delete();
        Yii::app()->user->setFlash('success', 'Plan has been deleted Successfully');
        $this->redirect(array('subscriptions'));
    }

    public function actionPlanupdate($id) {
        $model = Subscriptions::model()->findByPk($id);
        if (isset($_POST['Subscriptions'])) {
            $model->attributes = $_POST['Subscriptions'];
            if ($model->validate()) {
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Plan has been updated Successfully');
                $this->redirect(array('subscriptions'));
            }
        }

        $this->render('plan', compact('model'));
    }

    public function actionAddcity() {
        $model = new Cities;
        if (isset($_POST['Cities'])) {
            $model->attributes = $_POST['Cities'];
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $this->render('addcity', compact('model'));
    }

    public function actionAddlocality() {
        $model = new Locality;
        if (isset($_POST['Locality'])) {
            $model->attributes = $_POST['Locality'];
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $this->render('addlocality', compact('model'));
    }

    public function actionAddstate() {
        $model = new States;
        if (isset($_POST['States'])) {
            $model->attributes = $_POST['States'];
            if ($model->validate()) {
                $model->save(false);
                $this->redirect(array('index'));
            }
        }
        $this->render('addstate', compact('model'));
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
    
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

}
