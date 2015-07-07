<?php

class UsersController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/frontend';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array(
                    'index', 'view', 'register', 'signupsocial', 'sociallogin',
                    'login', 'activation', 'test', 'forgot', 'reset', 'temporary', 'reminder'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'logout', 'myprofile'),
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
    public function actionRegister() {
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('/site/journal/create'));

        $model = new Users('register');

        $this->performAjaxValidation($model);
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $valid = $model->validate();
            if ($valid) {
                Myclass::addUser($model);

                Yii::app()->user->setFlash('success', "Please check your mail for activation");
                $this->redirect(array('/site/users/login'));
            }
        } else {
            if (Yii::app()->session['temp_user_mail'])
                $model->user_email = Yii::app()->session['temp_user_mail'];
        }

        $this->render('register', array(
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

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->user_id));
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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Users');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users']))
            $model->attributes = $_GET['Users'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
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
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSignupsocial($provider) {
        try {

            Yii::import('application.components.HybridAuthIdentity');
            $haComp = new HybridAuthIdentity();
            if (!$haComp->validateProviderName($provider))
                throw new CHttpException('500', 'Invalid Action. Please try again.');

            $haComp->adapter = $haComp->hybridAuth->authenticate($provider);
            $haComp->userProfile = $haComp->adapter->getUserProfile();

            $haComp->processLogin();  //further action based on successful login or re-direct user to the required url
            $redirectUrl = $this->createUrl("/site/journal/create");
            echo "<script type='text/javascript'>if(window.opener){window.opener.location = '$redirectUrl';window.close();}else{window.opener.location = '$redirectUrl';}</script>";
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
            //process error message as required or as mentioned in the HybridAuth 'Simple Sign-in script' documentation
            $this->redirect(array('/site/users/register'));
            return;
        }

        Yii::app()->end(true);
    }

    public function actionSociallogin() {
        Yii::import('application.components.HybridAuthIdentity');
        $path = Yii::getPathOfAlias('ext.HybridAuth');
        require_once $path . '/hybridauth-' . HybridAuthIdentity::VERSION . '/hybridauth/index.php';
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('/site/journal/dashboard'));
        }



        $model = new LoginForm('login');

        if (Yii::app()->session['temp_user_mail'])
            $model->username = Yii::app()->session['temp_user_mail'];

        $this->performAjaxValidation($model);
        if (isset($_POST['sign_in'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()):
                $this->redirect(array('/site/journal/dashboard'));
            endif;
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        Yii::app()->user->setFlash('success', "You were logged out successfully");
        $this->redirect(array('/site/users/login'));
    }

    public function actionActivation($activationkey, $userid) {
        $user = Users::model()->findByAttributes(array(
            'user_id' => $userid,
            'user_activation_key' => $activationkey,
            'user_last_login' => null)
        );
        if (empty($user))
            throw new CHttpException(404, 'The specified post cannot be found.');

        $user = $this->loadModel($userid);
        $user->setAttribute('user_status', '1');
        $user->setAttribute('user_last_login', date('Y-m-d H:i:s'));
        if ($user->save(false)) {
//            $mail = new Sendmail;
//            $message = '<p>Dear ' . $user->user_name . '</p>';
//            $message .= '<p>Your email account verified successfully.</p>';
//            $message .= '<p>You can login with your email and password: ';
//            $message .= '<a href="' . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl . '/site/users/login">Click Here to Login</a></p>';
//            $Subject = CHtml::encode(Yii::app()->name) . ': Email Verfied';
//            $mail->send($user->user_email, $Subject, $message);
            ///////////////////////////
            if (!empty($user->user_email)):
            $mail = new Sendmail;
            $loginlink = Yii::app()->createAbsoluteUrl('/site/users/login');
            $trans_array = array(
                "{SITENAME}" => SITENAME,
                "{USERNAME}" => $user->user_name,
                "{EMAIL_ID}" => $user->user_email,
                "{NEXTSTEPURL}" => $loginlink,
            );
            $message = $mail->getMessage('activation', $trans_array);
            $Subject = $mail->translate('{SITENAME}: Email Verfied');
            $mail->send($user->user_email, $Subject, $message);
        endif;
        /////////////////////////

            Yii::app()->user->setFlash('success', "Your Email account verified. you can login");
            $this->redirect(array('/site/users/login'));
        } else {
            echo var_dump($user->getErrors());
        }
        exit;
    }

    public function actiontemporary($activationkey, $userid) {
        $user = Users::model()->findByAttributes(array(
            'user_id' => $userid,
            'user_activation_key' => $activationkey,
            'user_last_login' => null)
        );
        $temp_model = Entry::model()->findByAttributes(array(
            'temp_activation_key' => $activationkey,
        ));
        $journal_model = new Diary('create');
        if (empty($user))
            throw new CHttpException(404, 'The specified post cannot be found.');

        $journal_model->setAttribute('diary_user_id', $userid);
        $journal_model->setAttribute('diary_title', $temp_model->temp_title);
        $journal_model->setAttribute('diary_description', $temp_model->temp_description);
        $journal_model->setAttribute('diary_category_id', $temp_model->temp_category_id);
        $journal_model->setAttribute('diary_tags', $temp_model->temp_tags);
        $journal_model->setAttribute('diary_current_date', $temp_model->temp_current_date);
        $journal_model->setAttribute('diary_user_mood_id', $temp_model->temp_user_mood_id);
//        $journal_model->setAttribute('diary_upload', $temp_model->temp_upload);
        $journal_model->setAttribute('created', $temp_model->created);
        $journal_model->setAttribute('modified', $temp_model->modified);
        if ($journal_model->save(false)) {
            Entry::model()->deleteByPk(array('temp_activation_key' => $temp_model->temp_activation_key, 'temp_id' => $temp_model->temp_id));
            $user = $this->loadModel($userid);
            $user->setAttribute('user_status', '1');
            $user->setAttribute('user_last_login', date('Y-m-d H:i:s'));
            if ($user->save(false)) {
                $mail = new Sendmail;
                $message = '<p>Dear ' . $user->user_name . '</p>';
                $message .= '<p>Your email account verified successfully.</p>';
                $message .= '<p>You can login with your email and password: ';
                $message .= '<a href="' . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl . '/site/users/login">Click Here to Login</a></p>';
                $Subject = CHtml::encode(Yii::app()->name) . ': Email Verfied';
                $mail->send($user->user_email, $Subject, $message);

                Yii::app()->user->setFlash('success', "Your Email account verified. you can login");
                $this->redirect(array('/site/users/login'));
            } else {
                echo var_dump($user->getErrors());
            }
        }
        exit;
    }

    public function actionForgot() {
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('/site/journal/create'));

        $model = new LoginForm('forgotpass');
        $this->performAjaxValidation($model);
        if (isset($_POST['forgot'])) {
            $model->attributes = $_POST['LoginForm'];
            $response = Myclass::forgotPass($model);

            if ($response['success'] === 0) {
                Yii::app()->user->setFlash("error", "This Email Address Not Exists");
                $this->redirect(array('/site/users/forgot'));
            } else {
                Yii::app()->user->setFlash('success', "Your Password Reset Link sent to your email address.");
                $this->redirect(array('/site/users/login'));
            }
        }

        $this->render('forgot', array('model' => $model));
    }

    public function actionReset($str, $id) {
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('/site/journal/create'));

        $model = $this->loadModel($id);
        if (empty($model) || $model->reset_password_string != $str) {
            Yii::app()->user->setFlash('error', "Not a valid Reset Link");
            $this->redirect(array('/site/users/login'));
        } else {
            $time1 = new DateTime(date('H:i:s'));
            $time2 = new DateTime(date('H:i:s', strtotime($model->modified)));
            $interval = $time1->diff($time2);
            $minutes = $interval->format('%i');
            if ($minutes > 5) {
                Yii::app()->user->setFlash('error', "This Reset Link Expired. Please Try again.");
                $this->redirect(array('/site/users/forgot'));
            }
        }

        $model->setScenario('reset');
        $this->performAjaxValidation($model);
        if (isset($_POST['reset'])) {
            $model->setAttribute('user_password', Myclass::encrypt($_POST['Users']['new_password']));
            $model->setAttribute('reset_password_string', '');
            $model->save(false);
            Yii::app()->user->setFlash('success', "Your Password Changed Successfully.");
            $this->redirect(array('/site/users/login'));
        }
        $this->render('reset', array('model' => $model));
    }

    public function actionTest() {
        //temp smtp mail
//        $mail = Yii::app()->Smtpmail;
//        $mail->SetFrom('noreply@express2help.com', CHtml::encode(Yii::app()->name));
//        $mail->Subject = CHtml::encode(Yii::app()->name) . ': Confirmation you mail';
//        $message = '<p>Dear ' . $model->user_name . '</p>';
//        $message .= '<p>Thank you for signing up, we just need to verify your email address</p>';
//        $message .= '<p><a href="' . Yii::app()->baseUrl . '/site/users/activation?activationkey=' . $model->user_activation_key . '&userid=' . $model->user_id . '">Click Here to activate</a></p><br />';
//        $message .= "<p>If you can't click the button above, you can verify your email address by copying and pasting (or typing) the following address into your browser:</p>";
//        $message .= '<p><a href="' . Yii::app()->baseUrl . '/site/users/activation?activationkey=' . $model->user_activation_key . '&userid=' . $model->user_id . '">' . Yii::app()->baseUrl . '/site/users/activation?activationkey=' . $model->user_activation_key . '&userid=' . $model->user_id . '</a></p><br />';
//        $mail->MsgHTML($message);
//
//        $mail->AddAddress($model->user_email, "");
//        if (!$mail->Send()) {
//            echo "Mailer Error: " . $mail->ErrorInfo;
//        }
//        //end
//        exit;

        $mail = new Sendmail;
        try {
            if ($mail->send('prakash.paramanandam@arkinfotec.com', 'test', 'test')) {
                echo 'success';
            } else {
                echo 'fail';
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        exit;
    }

    public function actionMyprofile() {
        $this->layout = '//layouts/frontinner';
        $path = realpath(Yii::app()->getBasePath() . "/../") . "/themes/site/image/prof_img/";
        $model = Users::model()->findByPk(Yii::app()->user->id);
        if (isset($_POST['update'])) {
            $model->setScenario('update');
            $old_name = $model->user_prof_image;
            $model->attributes = $_POST['Users'];
            $model->user_prof_image = CUploadedFile::getInstance($model, 'user_prof_image');
            $valid = $model->validate();
            if ($valid) {
                if (!empty($model->user_prof_image)) {
                    $name = $model->user_prof_image->getName();
                    $filename = time() . '_' . Yii::app()->user->id . '_' . $name;
                    $model->user_prof_image->saveAs($path . $filename);
                    if (!empty($old_name)) {
                        unlink($path . $old_name);
                    }
                    $model->user_prof_image = $filename;
                } else {
                    $model->user_prof_image = $old_name;
                }
                Myclass::updateUser($model);

                Yii::app()->user->setFlash('success', "Your profile successfully updated.");
                $this->refresh();
            }
        } elseif (isset($_POST['forgot'])) {
            $model->setScenario('changepassword');
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->user_password = Myclass::encrypt($_POST['Users']['new_password']);
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Password has been reset successfully');
                $this->refresh();
            }
        }

        $this->render('update_profile', array(
            'model' => $model,
        ));
    }

    public function actionReminder($key = null) {
        if ($key == 'vZu3G6Ewy') {
            $users = Users::model()->isActive()->findAll();

            foreach ($users as $user) {
            $mail = new Sendmail;
            $trans_array = array(
                "{SITENAME}" => SITENAME,
                "{USERNAME}" => $user->user_name,
                "{EMAIL_ID}" => $user->user_email,
            );
            $message = $mail->getMessage('reminder', $trans_array);
            $Subject = $mail->translate('{SITENAME}: : Reminder');
            $mail->send($user->user_email, $Subject, $message);
            }
        }
        Yii::app()->end();
    }

}
