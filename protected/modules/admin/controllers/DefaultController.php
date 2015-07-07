<?php

/**
 * Site controller
 */
class DefaultController extends Controller {

    public $layout = '//layouts/column1';

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'error', 'request-password-reset', 'screens'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'index', 'profile'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogin() {
        $this->layout = '//layouts/login';

        if (!Yii::app()->user->isGuest) {
            $this->goHome();
        }

        $model = new LoginForm();

        if (isset($_POST['sign_in'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()):
                Myclass::addAuditTrail("{$model->username} logged-in successfully.", "user");
                $this->goHome();
            endif;
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Myclass::addAuditTrail(Yii::app()->user->name . " logged-out successfully.", "user");
        Yii::app()->user->logout();
        $this->redirect(array('/site/default/login'));
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if (isset($_POST['PasswordResetRequestForm'])) {
            $model->attributes = $_POST['PasswordResetRequestForm'];
            if ($model->validate()):
                if ($model->sendEmail()) {
                    Yii::app()->user->setFlash('success', 'Check your email for further instructions.');
                    $this->goHome();
                } else {
                    Yii::app()->user->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            endif;
        }

        $this->render('requestPasswordResetToken', array(
            'model' => $model,
        ));
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (isset($_POST['ResetPasswordForm'])) {
            $model->attributes = $_POST['ResetPasswordForm'];
            if ($model->validate() && $model->resetPassword()):
                Yii::app()->user->setFlash('success', 'New password was saved.');
                $this->goHome();
            endif;
        }

        $this->render('resetPassword', array(
            'model' => $model,
        ));
    }

    public function actionProfile() {
        $id = Yii::app()->user->id;
        $model = User::model()->findByPk($id);
        $model->setScenario('update');

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate()):
                $model->save(false);
                Myclass::addAuditTrail("Updated a {$model->username} successfully.", "user");
                Yii::app()->user->setFlash('success', 'Profile updated successfully');
                $this->refresh();
            endif;
        }
        $this->render('profile', compact('model'));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
                Yii::app()->end();
            } else {
                $name = Yii::app()->errorHandler->error['code'] . ' Error';
                $this->render('error', compact('error', 'name'));
            }
        }
    }

    public function actionScreens($path) {
        if ($path) {
            $this->render('screens', compact('path'));
        }
    }

}
