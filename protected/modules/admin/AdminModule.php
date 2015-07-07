<?php

class AdminModule extends CWebModule {

    public function init() {
        $this->layout = '//layouts/column1';
        Yii::app()->theme = "admin";

        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
        ));

        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'admin/default/error'),
            'user' => array(
                'class' => 'CWebUser',
                'loginUrl' => Yii::app()->createUrl('admin/default/login'),
            )
        ));

        Yii::app()->user->setStateKeyPrefix('_admin');
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            if (Yii::app()->user->isGuest && ($action->id != 'login' && $action->id != 'forgotpassword')):
                Yii::app()->getController()->redirect(array('/admin/default/login'));
            endif;
            return true;
        } else
            return false;
    }

}
