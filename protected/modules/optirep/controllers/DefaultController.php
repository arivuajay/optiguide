<?php

class DefaultController extends ORController {

    public $layout = '//layouts/landing_page';

    public function actionIndex() {
        $model = new OrLoginForm;
        if (isset($_POST['sign_in'])) {
            $model->attributes = $_POST['OrLoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('index', compact('model'));
    }

    public function actionRegister() {
        $model = new SalesRep;
        $profile = new SalesRepProfile;

        $this->performAjaxValidation(array($model, $profile));

        if (isset($_POST['SalesRep'], $_POST['SalesRepProfile'])) {
            $model->attributes = $_POST['SalesRep'];
            $profile->attributes = $_POST['SalesRepProfile'];

            $valid = $model->validate();
            $valid = $profile->validate() && $valid;

            if ($valid && $this->subscription()) {
                $model->rep_password = Myclass::encrypt($model->rep_password);
                $model->rep_status = 1;
                $model->rep_subscribed = 1;
                $model->rep_subscription_end = date('Y-m-d', strtotime('+1 month'));
                
                if($model->rep_subscription_type_id == 1)
                    $model->rep_role = SalesRep::ROLE_SINGLE;
                else
                    $model->rep_role = SalesRep::ROLE_COMPANY;
                
                // use false parameter to disable validation
                $model->save(false);
                $profile->rep_id = $model->rep_id;
                $profile->save(false);
                $this->redirect('index');
            }
        }
        $this->render('register', compact('model', 'profile'));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('index'));
    }
    
    protected function subscription() {
        return true;
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
