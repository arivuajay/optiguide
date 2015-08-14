<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class OrIdentity extends CUserIdentity {

    private $_id;

    const ERROR_ACCOUNT_NOT_ACTIVE = 3;
    const ERROR_ACCOUNT_NOT_SUBSCRIBED = 4;
    const ERROR_ACCOUNT_EXPIRED = 5;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = SalesRep::model()->find('rep_username = :U', array(':U' => $this->username));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;     // Error Code : 1
        } else if ($user->rep_password !== Myclass::encrypt($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;   // Error Code : 1
        } else {
            $this->_id = $user->rep_id;
            $this->setState('role', $user->rep_role);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}
