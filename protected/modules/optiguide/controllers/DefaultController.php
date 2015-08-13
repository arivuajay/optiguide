<?php

class DefaultController extends OGController {

    public function actionIndex() {
        $searchModel = new SuppliersDirectory();    
        $this->render('index', array('searchModel' => $searchModel));
    }

    public function actionSubscribe() {
        $this->render('subscribe');
    }
    
    public function actionContactus() {
        $this->render('contactus');
    }
    
    public function actionAdvertise(){
        
        $model = new Advertise;
        
        $this->performAjaxValidation(array($model));
        
        if (isset($_POST['Advertise'])) {
            $model->attributes = $_POST['Advertise'];
            
            /* Send request mail to admin for advertise */
            $mail    = new Sendmail();
            $subject = SITENAME." - Advertise request from ".$model->name;
            $trans_array  = array(
            "{SITE}"      => SITENAME,   
            "{NAME}"      => $model->name,     
            "{EMAIL}"     => $model->email,   
            "{TELEPHONE}" => $model->telephone,  
            "{MESSAGE}"   => $model->informations,  
            "{POSITION}"  => $model->position,     
            );
            $message = $mail->getMessage('advertise', $trans_array);
            $mail->send(ADMIN_EMAIL, $subject, $message, $model->name, $model->email);     
            
             Yii::app()->user->setFlash('success',  Myclass::t('OGO79','','og'));
             $this->redirect(array('advertise'));
         }    
        
        $this->render('advertise', compact('model'));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index');
    }
    
     /**
     * Performs the AJAX validation.
     * @param RetailerDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'advertise-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
