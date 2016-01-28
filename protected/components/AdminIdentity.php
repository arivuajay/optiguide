<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity {

    private $_id;
    
    public $email;

	    

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {

        $user = Admin::model()->find('admin_username = :U', array(':U' => $this->username));


        if ($user === null):
            $this->errorCode = self::ERROR_USERNAME_INVALID;     // Error Code : 1
        else:
            $is_correct_password = ($user->admin_password !== Myclass::encrypt($this->password)) ? false : true;

            if ($is_correct_password):
                $this->errorCode = self::ERROR_NONE;
            else:
                $this->errorCode = self::ERROR_USERNAME_INVALID;   // Error Code : 1
            endif;
        endif;

        if ($this->errorCode == self::ERROR_NONE):           
            $this->setUserData($user);
        endif;

        return !$this->errorCode;
    }
    
    protected function setUserData($user) {
     
        $lastLogin = date('Y-m-d H:i:s');
        $user->admin_last_login = $user->admin_last_login;
        $user->admin_login_ip = Yii::app()->request->userHostAddress;
        $user->save(false);
        $this->_id = $user->admin_id;
        $this->setState('username', $user->admin_name);
        $this->setState('v1', $user->admin_email);
        $this->setState('role', 'admin');
        //$this->setState('role', $user->role);
        //$this->setState('rolename', $user->roleMdl->Description);
        return;
    }
    
     public function checkadminemail() {
         
         $user = Admin::model()->find('admin_email = :U', array(':U' => $this->email));

        if ($user === null):
            $this->errorCode = self::ERROR_EMAIL_INVALID;     // Error Code : 1        
        endif;
        
        return !$this->errorCode;
     }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }
    
    public static function checkAccess($id = NULL, $controller = NULL, $action = NULL, $group_role = NULL) {
        $return = true;
       
        if ($id == NULL)
            $id = Yii::app()->user->id;
        if ($controller == NULL)
            $controller = Yii::app()->controller->id;
        if ($action == NULL)
            $action = Yii::app()->controller->action->id;

        $user = Admin::model()->find('admin_id = :U', array(':U' => $id));
        
        $othercontrollers = array("exportDatas","paymentTransaction","supplierSubscriptionPrice");

        if(in_array($controller , $othercontrollers))
        {   
            $screen = MasterScreen::model()->find("Screen_code = :controller and action= :action", array(':controller' => $controller, ':action'=>$action));                           
        }else{    
            $screen = MasterScreen::model()->find("Screen_code = :controller", array(':controller' => $controller));
        }    
       
        if (!empty($user) && !empty($screen)) {
           
         
            $auth_resources = AuthResources::model()->findByAttributes(array('Master_Role_ID' => $user->role, 'Master_Module_ID' => $screen->Module_ID, 'Master_Screen_ID' => $screen->Master_Screen_ID));
  
            if (!empty($auth_resources)) {
                $insert_actions = array('create');
                $update_actions = array('update','repUpdateStatus');
                $view_actions = array('index', 'view', 'retailerIndex','supplierIndex','clientIndex','reptransaction',"statsprice","repview");
                $delete_actions = array('delete');
                $other_actions = array();
               
                if (in_array($action, $insert_actions)) {
                    $return = $auth_resources->Master_Task_ADD == 1;
                } elseif (in_array($action, $update_actions)) {
                    $return = $auth_resources->Master_Task_UPT == 1;
                } elseif (in_array($action, $view_actions)) {
                    $return = $auth_resources->Master_Task_SEE == 1;
                } elseif (in_array($action, $delete_actions)) {
                    $return = $auth_resources->Master_Task_DEL == 1;
                } elseif (in_array($action, $other_actions)) {
                    $return = true;
                }
            }
        }
        return $return;
    }
    
     public static function checkAdmin() {
        $return = false;
        if(isset(Yii::app()->user->id)){
            $user = User::model()->find('id = :U', array(':U' => Yii::app()->user->id));
            $return = $user->role == 1;
        }
        return $return;
    }
    
     public static function checkPrivilages($rank) {
        $return = false;
        if(isset(Yii::app()->user->id)){
            $user = User::model()->find('id = :U', array(':U' => Yii::app()->user->id));
            $return = $user->roleMdl->Rank <= $rank;
        }
        return $return;
    }
}