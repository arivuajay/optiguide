<?php

class DefaultController extends OGController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionSubscribe() {
        $this->render('subscribe');
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index');
    }

}
