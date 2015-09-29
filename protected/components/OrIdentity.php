<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class OrIdentity extends CUserIdentity {

    private $_id;

    const ERROR_ACCOUNT_INACTIVE = 3;
    const ERROR_ACCOUNT_EXPIRED = 4;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = RepCredentials::model()->find('rep_username = :U', array(':U' => $this->username));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID; 
        } elseif ($user->rep_password !== $this->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID; 
        } elseif ($user->rep_status == 0) {
            $this->errorCode = self::ERROR_ACCOUNT_INACTIVE; 
        } elseif ($user->rep_role == RepCredentials::ROLE_SINGLE && $user->rep_expiry_date < date("Y-m-d") && $user->rep_parent_id != 0) {
            $this->errorCode = self::ERROR_ACCOUNT_EXPIRED; 
        } else {
            $this->_id = $user->rep_credential_id;
            $this->setState('rep_role', $user->rep_role);
            $this->setState('rep_username', $user->rep_username);
            $this->setState('rep_parent_id', $user->rep_parent_id);
            $this->errorCode = self::ERROR_NONE;
            
            $sess_id    = $user->rep_credential_id;
            $condition  = " NOM_TABLE='rep_credentials' AND ID_RELATION='$sess_id' ";
            $ufrm_infos = UserDirectory::model()->find($condition);
            if(!empty($ufrm_infos))
            {    
                $this->setState('user_id', $ufrm_infos->ID_UTILISATEUR);
            }    
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
