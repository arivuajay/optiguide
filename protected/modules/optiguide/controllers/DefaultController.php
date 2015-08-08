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
        $this->render('advertise');
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index');
    }

}
