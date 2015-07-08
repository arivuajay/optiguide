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
            $lastLogin = date('Y-m-d H:i:s');
            $user->admin_last_login = $lastLogin;
            $user->admin_login_ip = Yii::app()->request->userHostAddress;
            $user->save(false);
            $this->_id = $user->admin_id;
            $this->setState('username', $user->admin_name);
            $this->setState('v1', $user->admin_email);
            $this->setState('role', 'admin');

        endif;

        return !$this->errorCode;
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
}