<?php

class AdminModule extends CWebModule {
    
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
        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');
        $this->layout = '//layouts/main';
        
          if(!isset(Yii::app()->session['language']))
            Yii::app()->session['language'] = 'FR'; 
        
        Yii::app()->getComponent("booster");
    }

    public function beforeControllerAction($controller, $action) {
        Yii::app()->user->loginUrl = array('/admin/default/login');
        
        

        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
