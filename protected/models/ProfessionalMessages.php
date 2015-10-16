<?php

/**
 * This is the model class for table "professional_messages".
 *
 * The followings are the available columns in table 'professional_messages':
 * @property integer $message_id
 * @property integer $ID_SPECIALISTE
 * @property integer $employee_id
 * @property string $message
 * @property string $date_remember
 * @property integer $user_view_status
 * @property integer $status
 * @property string $created_date
 * @property string $randkey
 * @property integer $mail_sent_counts
 */
class ProfessionalMessages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'professional_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_SPECIALISTE, employee_id, user_view_status, status, mail_sent_counts', 'numerical', 'integerOnly'=>true),
			array('randkey', 'length', 'max'=>255),
			array('message, date_remember, created_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('message_id, ID_SPECIALISTE, employee_id, message, date_remember, user_view_status, status, created_date, randkey, mail_sent_counts', 'safe', 'on'=>'search'),
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
			'ID_SPECIALISTE' => Myclass::t('Id Specialiste'),
			'employee_id' => Myclass::t('Employee'),
			'message' => Myclass::t('Message'),
			'date_remember' => Myclass::t('Date Remember'),
			'user_view_status' => Myclass::t('User View Status'),
			'status' => Myclass::t('Status'),
			'created_date' => Myclass::t('Created Date'),
			'randkey' => Myclass::t('Randkey'),
			'mail_sent_counts' => Myclass::t('Mail Sent Counts'),
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
	public function search($id)
	{
            // @todo Please modify the following code to remove attributes that should not be searched.
            $criteria=new CDbCriteria;

            $criteria->addCondition("t.ID_SPECIALISTE='$id'");

            $criteria->with = array(
                "employeeProfiles" => array(
                  'alias' => 'employeeProfiles',
                  'select' => 'employee_name,employee_email',
                ),
              );
            $criteria->order = 'date_remember ASC';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination' => array(
                        'pageSize' => 5,
                    )
            ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProfessionalMessages the static model class
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
