<?php

class DefaultController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionUnderdevelopment() {
        $this->layout = '//layouts/frontinner';
        $this->render('underdevelopment');
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'signup') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
