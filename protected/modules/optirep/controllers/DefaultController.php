<?php

class DefaultController extends ORController {

    public $layout = '//layouts/landing_page';

    public function actionIndex() {
        $model = new SalesRep;
        $this->render('index', compact('model'));
    }

    public function actionRegister() {
        $model = new SalesRep;
        $profile = new SalesRepProfile;

        $this->performAjaxValidation(array($model, $profile));

        if (isset($_POST['SalesRep'], $_POST['SalesRepProfile'])) {
            $model->attributes = $_POST['SalesRep'];
            $profile->attributes = $_POST['SalesRepProfile'];

            // validate BOTH $a and $b
            $valid = $model->validate();
            $valid = $profile->validate() && $valid;

            if ($valid && $this->subscription()) {
                $model->rep_password = Myclass::encrypt($model->rep_password);
                $model->rep_subscribed = 1;
                $model->rep_subscription_end = date('Y-m-d', strtotime('+1 month'));
                // use false parameter to disable validation
                $model->save(false);
                $profile->rep_id = $model->rep_id;
                $profile->save(false);
                $this->redirect('index');
            } 
        }
        $this->render('register', compact('model', 'profile'));
    }

    protected function subscription() {
        return true;
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('index'));
    }

    /**
     * Performs the AJAX validation.
     * @param ProfessionalDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sales-rep-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
