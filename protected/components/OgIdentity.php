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
        
        if($user->NOM_TABLE=="Professionnels"){
            $relation_table = ProfessionalDirectory::model()->findByPk($user->ID_RELATION);
        }else if($user->NOM_TABLE=="Detaillants"){
            $relation_table = RetailerDirectory::model()->findByPk($user->ID_RELATION);
        }else if($user->NOM_TABLE=="Fournisseurs"){
            $relation_table = SuppliersDirectory::model()->findByPk($user->ID_RELATION);
        }
        
        $user_dbpass = $user->PWD;
        // strip out all whitespace
        $user_dbpass = preg_replace('/\s*/', '', $user_dbpass);
        // convert the string to all lowercase
        $user_dbpass = strtolower($user_dbpass);
        
        $user_postpass = $this->password;
        // strip out all whitespace
        $user_postpass = preg_replace('/\s*/', '', $user_postpass);
        // convert the string to all lowercase
        $user_postpass = strtolower($user_postpass);
        
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;     // Error Code : 1
        } else if ($user_dbpass !== $user_postpass) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;   // Error Code : 1
        } else if (empty ($relation_table)) {
            //Add new condition to finding the status of user.
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else if ($user->NOM_TABLE == 'rep_credentials') {
            //Add new condition to finding the status of user.
            $this->errorCode = self::ERROR_USERNAME_NOT_ACTIVE;
        }else if ($user->status == 0) {
            //Add new condition to finding the status of user.
            $this->errorCode = self::ERROR_USERNAME_NOT_ACTIVE;
        } else {
            $this->_id = $user->ID_UTILISATEUR;
            $this->setState('name', $user->NOM_UTILISATEUR);
            $this->setState('role', $user->NOM_TABLE);
            $this->setState('userstatus', $user->status);
            $this->setState('relationid', $user->ID_RELATION);
            $this->setState('encryptval', $user->sGuid);
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
