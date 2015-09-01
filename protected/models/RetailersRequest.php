<?php

/**
 * This is the model class for table "RetailersRequest".
 */
class RetailersRequest extends CFormModel
{
        public $retailername,$retaileremail,$message;        	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('retailername, retaileremail,message', 'required'),
                    array('retaileremail','email'),
                   array('message', 'length', 'max' => 1000),                   
            );
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'retailername'  => Myclass::t('OGO161','','og'),
			'retaileremail' => Myclass::t('OGO162','','og'),
			'message'       => Myclass::t('OGO163','','og'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuppliersSubscription the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}        
       
}
