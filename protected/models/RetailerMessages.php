<?php

/**
 * This is the model class for table "retailer_messages".
 *
 * The followings are the available columns in table 'retailer_messages':
 * @property integer $message_id
 * @property integer $ID_RETAILER
 * @property integer $employee_id
 * @property string $message
 * @property string $date_remember
 * @property integer $user_view_status
 * @property integer $status
 * @property string $created_date
 * @property string $randkey
 * @property integer $mail_sent_counts
 */
class RetailerMessages extends CActiveRecord
{
    public $afile;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'retailer_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_RETAILER, employee_id, user_view_status, status, mail_sent_counts', 'numerical', 'integerOnly'=>true),
			array('randkey', 'length', 'max'=>255),
			array('message, date_remember, created_date, alertfile', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('message_id, ID_RETAILER, employee_id, message, date_remember, user_view_status, status, created_date, randkey, mail_sent_counts', 'safe', 'on'=>'search'),
                        array('afile', 'file', 'allowEmpty'=>true, 'safe' => false),
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
                      'retailerDirectory' => array(self::BELONGS_TO, 'RetailerDirectory', 'ID_RETAILER'),  
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
			'ID_RETAILER' => Myclass::t('Id Retailer'),
			'employee_id' => Myclass::t('Employee'),
			'message' => Myclass::t('Message'),
			'date_remember' => Myclass::t('Date Remember'),
			'user_view_status' => Myclass::t('User View Status'),
			'status' => Myclass::t('Status'),
			'created_date' => Myclass::t('Created Date'),
			'randkey' => Myclass::t('Randkey'),
			'mail_sent_counts' => Myclass::t('Mail Sent Counts'),
                        'afile' => Myclass::t('Attachment File'),
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
	public function search_expirealerts($id)
	{
            // @todo Please modify the following code to remove attributes that should not be searched.
            $criteria=new CDbCriteria;
            $cur_day = date("Y-m-d");            
            $criteria->addCondition("DATE(t.date_remember)<'$cur_day'");
            $criteria->addCondition("t.ID_RETAILER='$id'");

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
        
        public function search_currentalerts($id)
	{           
            // @todo Please modify the following code to remove attributes that should not be searched.
            $criteria=new CDbCriteria;
            $cur_day = date("Y-m-d");            
            $criteria->addCondition("DATE(t.date_remember)>='$cur_day'");
            $criteria->addCondition("t.ID_RETAILER='$id'");

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
	 * @return RetailerMessages the static model class
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
