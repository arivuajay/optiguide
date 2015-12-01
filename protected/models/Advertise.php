<?php

/**
 * This is the model class for table "advertise".
 *
 * The followings are the available columns in table 'advertise':
 * @property integer $id
 * @property string $name
 * @property string $telephone
 * @property string $informations
 * @property integer $position
 * @property string $email
 */
class Advertise extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'advertise';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('name, telephone, informations, position, email','required'),			
			array('name', 'length', 'max'=>255),
			array('telephone, email', 'length', 'max'=>55),
			array('informations', 'safe'),
                        array('telephone', 'phoneNumber'),
                        array('email', 'email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, telephone, informations, position, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
        
        /** 
        * check the format of the phone number entered
        * @param string $attribute the name of the attribute to be validated
        * @param array $params options specified in the validation rule
        */
        public function phoneNumber($attribute,$params='')
        {
          if($this->$attribute!='' && preg_match("/[A-Za-z]+/",$this->$attribute)==1)
          {            
                $this->addError($attribute,'Invalid Format.' );          
          }        
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Myclass::t('ID'),
			'name' => Myclass::t('OG190'),
			'telephone' => Myclass::t('OG192'),
			'informations' => Myclass::t('OG193'),
			'position' => Myclass::t('Position'),
			'email' => Myclass::t('OG191'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advertise the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function dataProvider() {
            return new CActiveDataProvider($this, array(
                'pagination' => array(
                    'pageSize' => PAGE_SIZE,
                )
            ));
        }
}
