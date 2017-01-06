<?php

/**
 * AdminLoginForm class.
 * AdminLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class AdminLoginForm extends CFormModel {

    public $email;
    public $username;
    public $password;
    public $rememberMe = 0;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            array('email', 'required', 'on' => 'forgotpass'),
            array('email', 'email'),
            //array('admin_username', 'email'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Myclass::t('APP3'),
            'password' => Myclass::t('APP4'),
            'rememberMe' => Myclass::t('APP13'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {

        if (!$this->hasErrors()):
            $this->_identity = new AdminIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()):
                if ($this->_identity->errorCode)                
                     if(($this->_identity->errorCode == 1) or ($this->_identity->errorCode == 2))
                        $this->addError('password',Myclass::t('APP14'));
                    elseif($this->_identity->errorCode == 3)
                        $this->addError('username',Myclass::t('OG125'));
                    elseif($this->_identity->errorCode == 4)
                        $this->addError('username',Myclass::t('OG227'));
                    else
                        $this->addError('username',Myclass::t('OG126'));
            endif;
        endif;      
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {

        if ($this->_identity === null):
            $this->_identity = new AdminIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        endif;
        
        if ($this->_identity->errorCode === AdminIdentity::ERROR_NONE):
            //$duration= 3600*24*30; // 30 days
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            //MyClass::rememberMeAdmin($this->username, $this->rememberMe);
            return true;
        else:

        endif;
    }

}
