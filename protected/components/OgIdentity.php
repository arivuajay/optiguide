<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class OgIdentity extends CUserIdentity {

    private $_id;

    const ERROR_USERNAME_NOT_ACTIVE = 3;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = UserDirectory::model()->find('USR = :U', array(':U' => $this->username));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;     // Error Code : 1
        } else if ($user->PWD !== $this->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;   // Error Code : 1
        } else if ($user->MUST_VALIDATE == 0) {
            //Add new condition to finding the status of user.
            $this->errorCode = self::ERROR_USERNAME_NOT_ACTIVE;
        } else {
            $this->_id = $user->ID_UTILISATEUR;
            $this->setState('name', $user->NOM_UTILISATEUR);
            $this->setState('role', $user->NOM_TABLE);
            $this->setState('userstatus', $user->MUST_VALIDATE);
            $this->setState('relationid', $user->ID_RELATION);
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
