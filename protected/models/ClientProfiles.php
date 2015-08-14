<?php

/**
 * This is the model class for table "client_profiles".
 *
 * The followings are the available columns in table 'client_profiles':
 * @property integer $id
 * @property string $client
 * @property string $message
 * @property string $meeting_date
 * @property string $created
 * @property integer $status
 */
class ClientProfiles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client_profiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('client,message,meeting_date,first_name, lastname ,country ,region ,ville','required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('client', 'length', 'max'=>255),
                        array('address', 'length', 'max'=>255),
                        array('first_name, lastname ,country ,region ,ville ,pincode , mail ,phonenumber', 'length', 'max'=>55),                    
			array('message, meeting_date, created', 'safe'),
                        array('mail','email'),
                        array('phonenumber','phoneNumber'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client, message, meeting_date, created, status , first_name, lastname ,address ,country ,region ,ville ,pincode , mail ,phonenumber', 'safe', 'on'=>'search'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'id' => Myclass::t('ID'),
                    'client' => Myclass::t('Client'),
                    'message' => Myclass::t('Message'),
                    'meeting_date' => Myclass::t('Rappel date de'),
                    'created' => Myclass::t('Created'),
                    'status' => Myclass::t('Status'),
                    'first_name' => Myclass::t('First Name'),
                    'lastname' => Myclass::t('Last Name'),
                    'address' => Myclass::t('Address'),
                    'country' => Myclass::t('Country'),
                    'region' => Myclass::t('Region'),
                    'ville' => Myclass::t('City'),
                    'pincode' => Myclass::t('Pincode'),
                    'mail' => Myclass::t('Email'),
                    'phonenumber' => Myclass::t('Phonenumber'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('client',$this->client,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('meeting_date',$this->meeting_date,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => PAGE_SIZE,
                        )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientProfiles the static model class
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
