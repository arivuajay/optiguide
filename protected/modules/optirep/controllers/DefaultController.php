<?php

class DefaultController extends ORController {

    public $layout = '//layouts/anonymous_page';

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
                'actions' => array('index', 'aboutus', 'legend', 'contactus', 'forgotPassword','error'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout'),
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
    
     public function actionError()
    {
      
        $error = Yii::app()->errorHandler->error;
        if ($error)
        $this->render('_error', array('error'=>$error));
        else
        throw new CHttpException(404, 'Page not found.');
    } 

    public function actionIndex() {
        $model = new OrLoginForm('login');
        if (isset($_POST['login'])) {
            $model->attributes = $_POST['OrLoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(array('/optirep/dashboard'));
            }
        }
        $this->render('index', array('model' => $model));
    }

    public function actionAboutus() {
        $this->layout = '//layouts/column1';
        $this->render('aboutus');
    }

    public function actionLegend() {
        $this->layout = '//layouts/column1';
        $this->render('legend');
    }

    public function actionContactus() {
        $this->layout = '//layouts/column1';
        $this->render('contactus');
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index');
    }

    public function actionForgotPassword() {
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('index'));

        $model = new OrLoginForm('forgotpass');

        if (isset($_POST['forgot'])) {
            $model->attributes = $_POST['OrLoginForm'];
            if ($model->validate()) {
                $rep = RepCredentials::model()->findByAttributes(array('rep_username' => $_POST['OrLoginForm']['username']));
                if (empty($rep)) {
                    Yii::app()->user->setFlash('danger', 'This Username Not Exists!!!');
                } else {
                    $rep_profile = $rep->repCredentialProfiles;
                    $rep->rep_password = Myclass::getRandomString(5);
                    $rep->save(false);
                    
                    if (!empty($rep_profile['rep_profile_email'])):
                        //$loginlink = Yii::app()->createAbsoluteUrl('/site/default/login');
                        $mail = new Sendmail;
                        $trans_array = array(
                            "{USERNAME}" => $rep->rep_username,
                            "{NEWPASSWORD}" => $rep->rep_password,
                        );
                        $message = $mail->getMessage('rep_forgot_password', $trans_array);
                        $Subject = $mail->translate('Reset Password');
                        $mail->send($rep_profile['rep_profile_email'], $Subject, $message);
                    endif;
                    
                    Yii::app()->user->setFlash('success', 'New Password has been sent to your registered email. Please check your email');
                }
                $this->refresh();
            }
        }
        $this->render('forgotPassword', array('model' => $model));
    }

}
