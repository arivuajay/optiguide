<?php

/**
 * This is the model class for table "internal_message".
 *
 * The followings are the available columns in table 'internal_message':
 * @property integer $id
 * @property integer $id1
 * @property integer $id2
 * @property integer $user1
 * @property integer $user2
 * @property string $message
 * @property integer $timestamp
 * @property string $user1read
 * @property string $user2read
 */
class InternalMessage extends CActiveRecord
{
        public $maxColumn;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'internal_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('message', 'required'),
                    array('message', 'length', 'max' => 1000),
                    array('id1, id2, user1, user2, timestamp', 'numerical', 'integerOnly'=>true),
                    array('user1read, user2read', 'length', 'max'=>3),
                    array('message,maxColumn', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, id1, id2, user1, user2, message, timestamp, user1read, user2read', 'safe', 'on'=>'search'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Myclass::t('ID'),
			'id1' => Myclass::t('Id1'),
			'id2' => Myclass::t('Id2'),
			'user1' => Myclass::t('User1'),
			'user2' => Myclass::t('User2'),
			'message' => Myclass::t('Message'),
			'timestamp' => Myclass::t('Timestamp'),
			'user1read' => Myclass::t('User1read'),
			'user2read' => Myclass::t('User2read'),
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
		$criteria->compare('id1',$this->id1);
		$criteria->compare('id2',$this->id2);
		$criteria->compare('user1',$this->user1);
		$criteria->compare('user2',$this->user2);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('timestamp',$this->timestamp);
		$criteria->compare('user1read',$this->user1read,true);
		$criteria->compare('user2read',$this->user2read,true);

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
	 * @return InternalMessage the static model class
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
