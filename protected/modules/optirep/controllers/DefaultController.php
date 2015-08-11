<?php

class DefaultController extends ORController {

    public $layout = '//layouts/landing_page';

    public function actionIndex() {
        $this->render('index');
    }

    public function actionRegister() {
        $this->render('register');
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('index'));
    }

}
