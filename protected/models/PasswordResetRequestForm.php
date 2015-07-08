<?php

/**
 * AdminLoginForm class.
 * AdminLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PasswordResetRequestForm extends CFormModel {

     public $email;
     private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(                     
            array('email', 'required'),
            array('email', 'email')          
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email' => Myclass::t('APP6'),          
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate() 
    {  
        $userinfo = Admin::model()->find('admin_email = :U', array(':U' => $this->email));

        if ($userinfo === null):
            $this->addError('email', Myclass::t('APP15'));  // Error Code : 1               
        else:
            $randpass   = Myclass::getRandomString(5);           
            $userinfo->admin_password = Myclass::encrypt($randpass);
            $userinfo->save(false);    
            $toemail    = $userinfo->admin_email;           
            $mail = new Sendmail;
            $trans_array = array(
                "{NAME}"      => $userinfo->admin_username,
                "{SITENAME}"  => SITENAME,
                "{USEREMAIL}" => $userinfo->admin_username,
                "{USEREPASS}" => $randpass,
                "{NEXTSTEPURL}" => Yii::app()->createAbsoluteUrl('/admin/default/login')   
            );
            $message = $mail->getMessage('adminforgotpassword', $trans_array);
            
            $reset_subject = Myclass::t('App16');
            $Subject = $mail->translate('{SITENAME}: '.$reset_subject);
            $mail->send($toemail, $Subject, $message);
            return true;
         endif;        
    }    
   

}