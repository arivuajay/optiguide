<?php

/**
 * AdminLoginForm class.
 * AdminLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class OrLoginForm extends CFormModel {

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
            // username required On ForgotPassword
            array('username', 'required', 'on' => 'forgotpass'),
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
            'username' => 'Username',
            'password' => 'Password',
            'rememberMe' => 'Remember Me',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()):
            $this->_identity = new OrIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()):
                if (($this->_identity->errorCode == 1) or ( $this->_identity->errorCode == 2))
                    $this->addError('password', 'Username/Password combination is wrong');
                elseif ($this->_identity->errorCode == 3)
                    $this->addError('password', 'Your account is now In-Active');
                elseif ($this->_identity->errorCode == 4)
                    $this->addError('password', 'Your account is expired');
                else
                    $this->addError('password', 'Invalid Exception');
            endif;
        endif;
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null):
            $this->_identity = new OrIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        endif;

        if ($this->_identity->errorCode === OrIdentity::ERROR_NONE):
            $duration = $this->rememberMe ? 3600 * 24 * 5 : 0; // 30 days
            @Yii::app()->user->login($this->_identity, $duration);
            return true;
        endif;
    }

}
