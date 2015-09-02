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
    }

    public function beforeControllerAction($controller, $action) {
        Yii::app()->user->loginUrl = array('/optirep/');
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
