<?php

/**
 * This is the model class for table "client_messages".
 *
 * The followings are the available columns in table 'client_messages':
 * @property integer $message_id
 * @property integer $client_id
 * @property integer $employee_id
 * @property string $message
 * @property string $date_remember
 * @property integer $user_view_status
 * @property integer $mail_sent_counts
 * @property integer $status
 * @property string $created_date
 */
class ClientMessages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('client_id, employee_id,message,date_remember' , 'required'),
			array('client_id, employee_id, user_view_status, mail_sent_counts, status', 'numerical', 'integerOnly'=>true),
			array('message, date_remember, created_date,randkey', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('message_id, client_id, employee_id, message, date_remember, user_view_status, mail_sent_counts, status, created_date', 'safe', 'on'=>'search'),
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
                    'clientProfiles' => array(self::BELONGS_TO, 'ClientProfiles', 'client_id'),
                    'employeeProfiles' => array(self::BELONGS_TO, 'EmployeeProfiles', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'message_id' => Myclass::t('Message'),
			'client_id' => Myclass::t('Client'),
			'employee_id' => Myclass::t('Employé'),
			'message' => Myclass::t('Message'),
			'date_remember' => Myclass::t('Date d\'alerte'),
			'user_view_status' => Myclass::t('Vue de l\'utilisateur statut'),
			'mail_sent_counts' => Myclass::t('Mail Sent Counts'),
			'status' => Myclass::t('Rappel'),
			'created_date' => Myclass::t('Created Date'),
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

		$criteria->compare('message_id',$this->message_id);
		$criteria->compare('t.client_id',$this->client_id);
		$criteria->compare('t.employee_id',$this->employee_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('date_remember',$this->date_remember,true);
		$criteria->compare('user_view_status',$this->user_view_status);
		$criteria->compare('mail_sent_counts',$this->mail_sent_counts);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_date',$this->created_date,true);
               
                $criteria->with = array(
                    "clientProfiles" => array(
                      'alias' => 'clientProfiles', 
                      'select' => 'name'
                    ),
                    "employeeProfiles" => array(
                      'alias' => 'employeeProfiles',
                      'select' => 'employee_name',
                    ),
                  );

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
	 * @return ClientMessages the static model class
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
