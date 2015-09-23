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
               
        // Check the expiry date for suppliers login and redirect to renew page       
        if(isset(Yii::app()->user->id) && Yii::app()->user->id!='')
        {
            if(Yii::app()->user->role=="Fournisseurs")
            {                 
                $_controller = $controller->id;
                $_action = $action->id;
                $relid  = Yii::app()->user->relationid;
                
                $supp_result = SuppliersDirectory::model()->findByPk($relid);
                $profile_expirydate = $supp_result['profile_expirydate'];
                $p_expdate = date("Y-m-d", strtotime($profile_expirydate));  

                //$action_arr = array('renewsubscription',"renewpaypalreturn","renewpaypalnotify","renewpaypalcancel","transactions","logout");
                $action_arr = array('update','updateproducts','mappingreps','listreps','changepassword');
                $cntr_arr   = array('professionalDirectory',"retailerDirectory");

                if($p_expdate < date("Y-m-d"))
                {  
                   if( in_array($_action,$action_arr) || in_array($_controller,$cntr_arr) )
                   {        
                    Yii::app()->user->setFlash('info', Myclass::t('OGO186', '', 'og')); 
                    Yii::app()->request->redirect("/optiguide/suppliersDirectory/renewsubscription/");             
                   } 
                }

            }            
        }  
        
        Yii::app()->user->loginUrl = array('/optiguide/');
        
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
