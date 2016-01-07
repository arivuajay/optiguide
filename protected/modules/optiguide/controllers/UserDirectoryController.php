<?php

class UserDirectoryController extends OGController {
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
                'actions' => array('forgotpassword','resetpassword'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update','changepassword','confirmation'),
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
    
    public function actionConfirmation()
    {        
        $id     = Yii::app()->user->id;
        $model  = $this->loadModel($id);
        
        $pk     = Yii::app()->user->relationid;
        
        if (Yii::app()->user->role == "Professionnels") {
        
            $pmodel = ProfessionalDirectory::model()->findByPk($pk);
            $profileurl = '/optiguide/professionalDirectory/update';
            $view = '_professionalprofile';

        } else if (Yii::app()->user->role == "Detaillants") {

            $pmodel = RetailerDirectory::model()->findByPk($pk);
            $profileurl = '/optiguide/retailerDirectory/update';
            $view = '_retailerprofile';
              
        } else if (Yii::app()->user->role == "Fournisseurs") {
            
            $pmodel = SuppliersDirectory::model()->findByPk($pk);
            $profileurl = '/optiguide/suppliersDirectory/update';
            $view = '_supplierprofile';
        }

        if (isset($_POST['UserDirectory'])) {
                      
            $model->attributes = $_POST['UserDirectory'];
            
            if ($model->save(false)) {                
                Yii::app()->user->setFlash('success', Myclass::t('OGO220','','og'));
                $this->redirect($profileurl);
            }
        }

        $this->render($view, compact('model','pmodel','profileurl'));        
    }        

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
         //umodel = UserDirectory('frontend');
        $id=Yii::app()->user->id;
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['UserDirectory'])) {
            $model->attributes = $_POST['UserDirectory'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Myclass::t('OG036', '', 'og'));
                $this->redirect(array('update'));
            }
        }

        $this->render('update', compact('model','id'));
    }
    public function actionForgotpassword(){
        $baseurl = Yii::app()->request->getBaseUrl(true);
        $model = new UserDirectory('forgot');
        
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['UserDirectory'])) 
        {
            
            $model = UserDirectory::model()->findByAttributes(array('USR' => $_POST['UserDirectory']['username'],'COURRIEL' => $_POST['UserDirectory']['email']));
            if (empty($model)) {
                Yii::app()->user->setFlash('danger', Myclass::t("OR587", "", "or"));
                
            }  else {
                $model->attributes = $_POST['UserDirectory'];
                $valid = $model->validate();
            
            if($valid)
            {
                    
//                    $rep_profile = $model->COURRIEL;
                    $model->reset_pwd_code = Myclass::getRandomString(5);
//                    echo "<pre>";
//                    print_r($model->attributes);exit;
                    $model->save(false);

                    if (!empty($model->COURRIEL)):
                        //$loginlink = Yii::app()->createAbsoluteUrl('/site/default/login');
                        $this->lang = Yii::app()->session['language'];
                        $mail = new Sendmail;
                        $nextstep_url = $baseurl . '/optiguide/userDirectory/resetpassword/cnfrm/'.$model->reset_pwd_code;
                        $trans_array = array(
                            "{NEXTSTEPURL}"=>$nextstep_url,
                            "{USERNAME}" => $model->NOM_UTILISATEUR,
                        );
                        if($this->lang=='EN' ){
                            $subject = SITENAME . " - Reset Password";
                        }elseif($this->lang=='FR'){
                            $subject = SITENAME . " - Réinitialiser votre mot de passe";
                        }
                        $message = $mail->getMessage('guide_forgot_password', $trans_array);
                        $mail->send($model->COURRIEL, $subject, $message);
                    endif;

                    Yii::app()->user->setFlash('success', Myclass::t("OR737", "", "or"));
                }
            }
                $this->refresh();
            }
              
        $this->render('forgotpassword', array('model' => $model));
    }
    public function actionResetpassword($cnfrm){
        $baseurl = Yii::app()->request->getBaseUrl(true);
        $model = UserDirectory::model()->findByAttributes(array('reset_pwd_code' => $cnfrm));
        if (empty($model)) {
            $this->redirect($baseurl);
        }
        $model->scenario = 'resetPwd';
        
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['UserDirectory'])) 
        {
//            $model = UserDirectory::model()->findByAttributes(array('USR' => $usr,'reset_pwd_code' => $pwd_code));
            
            $model->attributes = $_POST['UserDirectory'];
            
            $valid = $model->validate();
            
            if($valid)
            {
                    $model->PWD = $_POST['UserDirectory']['new_password'];
                    $model->reset_pwd_code = '';
                    $model->save(false);
                       Yii::app()->user->setFlash('success', Myclass::t('OGO113', '', 'og'));    
            }
                $this->refresh();
        }
        $this->render('resetpassword', array('model' => $model));
    }
    
    public function actionchangepassword()
    {
        $id=Yii::app()->user->id;
        $model = UserDirectory::model()->findByPk($id);
        $model->scenario = 'changePwd';       
        
         // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['UserDirectory'])) 
        {
            
            $model->attributes = $_POST['UserDirectory'];
            $valid = $model->validate();

            if($valid)
            {

              $model->PWD = $model->new_password;
              if($model->save())
              {
                 Yii::app()->user->setFlash('success', Myclass::t('OGO113', '', 'og'));    
                 $this->redirect(array('changepassword'));       
              }
                
            }           
            
        }
        
        $this->render('changepassword', compact('model','id'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UserDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel() {
        
         $id=Yii::app()->user->id;
        $model = UserDirectory::model()->findByPk($id);
        $model->scenario = 'frontend';
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-directory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
