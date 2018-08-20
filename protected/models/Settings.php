<?php

/**
 * This is the model class for table "bj_settings".
 *
 * The followings are the available columns in table 'bj_settings':
 * @property integer $setting_id
 * @property string $option_name
 * @property string $option_value
 * @property string $option_type
 * @property string $updated_at
 */
class Settings extends CActiveRecord {

    public $payment_mode, $payment_partner, $payment_vendor_id, $payment_vendor_user, $payment_vendor_pass, $st_payment_mode, $business_email, $paypal_advanced_status, $paypal_standard_status, $currency;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'settings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('setting_id, option_name, option_value, option_type, updated_at', 'safe'),
            array('payment_mode, payment_partner, payment_vendor_id,payment_vendor_user, payment_vendor_pass, st_payment_mode, business_email, paypal_advanced_status, paypal_standard_status, currency', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'payment_mode' => "Mode",
            'payment_partner' => 'Partner',
            'payment_vendor_id' => 'Vendor ID',
            'payment_vendor_user' => 'Vendor User',
            'payment_vendor_pass' => 'Vendor Password',
            'paypal_advanced_status' => 'Paypal Advanced',
            'st_payment_mode' => 'Standard Paypal Mode',
            'business_email' => 'Business Email',
            'paypal_standard_status' => 'Paypal Standard',
            'currency' => 'Currency'
        );
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BjSettings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
