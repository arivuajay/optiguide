<?php

class ContactForm extends CFormModel {

    public $name;
    public $email;
    public $phone;
    public $message;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('name, email, phone, message', 'required'),
            array('email', 'email'),
            array('phone', 'phoneNumber'),
        );
    }
    
    public function phoneNumber($attribute, $params = '') {
        if ($this->$attribute != '' && preg_match("/[A-Za-z]+/", $this->$attribute) == 1) {
            $this->addError($attribute, 'Invalid Format.');
        }
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'name' => Myclass::t('Name'),
            'email' => Myclass::t('Email'),
            'phone' => Myclass::t('Phone'),
            'message' => Myclass::t('Message'),
        );
    }

}
