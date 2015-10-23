<?php

class OptirepModule extends CWebModule {

    public function init() {
        Yii::app()->theme = 'optirep';
        Yii::app()->name = 'Opti-Rep';

        Yii::app()->language = 'en';

        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');
        $this->layout = '//layouts/main';
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'optirep.models.*',
            'optirep.components.*',
        ));

        Yii::app()->getComponent("booster");
    }

    public function beforeControllerAction($controller, $action) {
        // Check the expiry date for Rep Single login and redirect to renew page       
        if (isset(Yii::app()->user->id)) {
            if (Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE) {

                $_controller = $controller->id;
                $_action = $action->id;

                $cntr_arr = array('repSingleSubscriptions', 'default');
                $action_arr = array('logout');

                $rep_credential = RepCredentials::model()->findByPk(Yii::app()->user->id);
                $rep_expiry_date = $rep_credential['rep_expiry_date'];
                $expdate = date("Y-m-d", strtotime($rep_expiry_date));

                if ($expdate < date("Y-m-d")) {
                    if (!in_array($_action, $action_arr) && !in_array($_controller, $cntr_arr)) {
                        Yii::app()->user->setFlash('info', Myclass::t('OR646', '', 'or'));
                        Yii::app()->request->redirect("/optirep/repSingleSubscriptions");
                    }
                }
            }
        }

        Yii::app()->user->loginUrl = array('/optirep/');
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
