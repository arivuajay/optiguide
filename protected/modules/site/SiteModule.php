<?php

class SiteModule extends CWebModule {

    public function init() {
        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');
        $this->layout = 'main';
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
