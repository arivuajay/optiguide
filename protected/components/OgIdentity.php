<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class OgIdentity extends CUserIdentity {

    private $_id;
    
    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {

        $user = UserDirectory::model()->find('USR = :U', array(':U' => $this->username));
        
        if ($user === null):
            $this->errorCode = self::ERROR_USERNAME_INVALID;     // Error Code : 1
        else:
            $is_correct_password = ($user->PWD !== $this->password) ? false : true;

            if ($is_correct_password):
                $this->errorCode = self::ERROR_NONE;
            else:
                $this->errorCode = self::ERROR_USERNAME_INVALID;   // Error Code : 1
            endif;
        endif;

        if ($this->errorCode == self::ERROR_NONE):
            $this->_id = $user->ID_UTILISATEUR;
            $this->setState('name', $user->NOM_UTILISATEUR);
            $this->setState('role', $user->NOM_TABLE);
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