<?php

class OptiguideModule extends CWebModule {
    
    /**
     * @property boolean Force users to vote before seeing results.
     */
    public $forceVote = TRUE;

    /**
     * @property boolean Restrict anonymous votes by IP address,
     * otherwise it's tied only to the user's ID.
     */
    public $ipRestrict = TRUE;

    /**
     * @property boolean Allow guests to cancel their votes
     * if $ipRestrict is enabled.
     */
    public $allowGuestCancel = FALSE;

    public function init() {
        Yii::app()->theme = 'optiguide';
        Yii::app()->language = 'en';
        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');
        $this->layout = '//layouts/main';
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'optiguide.models.*',
            'optiguide.components.*',
        ));
        
    }

    public function beforeControllerAction($controller, $action) {
         Yii::app()->user->loginUrl = array('/optiguide/');
        
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
