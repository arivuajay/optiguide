<?php

class DefaultController extends OGController {

    public function actionIndex() {
        $searchModel = new SuppliersDirectory();    
        $this->render('index', array('searchModel' => $searchModel));
    }

    public function actionSubscribe() {
        
        if (!Yii::app()->user->isGuest)
        {
            $this->redirect(array('index')); 
        }   
        
        $this->render('subscribe');
    }
    
    public function actionContactus() {
        $this->render('contactus');
    }
    
    public function actionTermsandconditions() {
        $this->render('terms');
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
    
    public function actionupdateadsclick()
    {
        $ads_id = isset($_POST['id']) ? $_POST['id'] : '';
        
        if($ads_id!='' && is_numeric($ads_id))
        {    
            // Add one count for the loading banner.
            Yii::app()->db
            ->createCommand("UPDATE publicite_publicite SET CLICK_RATE = CLICK_RATE + 1 WHERE ID_PUBLICITE=:adsId")
            ->bindValues(array(':adsId' => $ads_id))
            ->execute();
            echo "success";
            exit;
        }    
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
