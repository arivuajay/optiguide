<?php

/**
 * This is the model class for table "rep_loggedin_activities".
 *
 * The followings are the available columns in table 'rep_loggedin_activities':
 * @property integer $loggedin_id
 * @property string $loggedin_date
 * @property integer $rep_credential_id
 * @property string $loggedin_ip
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property RepCredentials $repCredential
 */
class RepLoggedinActivities extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rep_loggedin_activities';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('loggedin_date, rep_credential_id, loggedin_ip', 'required'),
            array('rep_credential_id', 'numerical', 'integerOnly' => true),
            array('loggedin_ip', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('loggedin_id, loggedin_date, rep_credential_id, loggedin_ip, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'repCredential' => array(self::BELONGS_TO, 'RepCredentials', 'rep_credential_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'loggedin_id' => Myclass::t('Loggedin', '', 'or'),
            'loggedin_date' => Myclass::t('OR693', '', 'or'),
            'rep_credential_id' => Myclass::t('OR664', '', 'or'),
            'loggedin_ip' => Myclass::t('OR694', '', 'or'),
            'created_at' => Myclass::t('OR660', '', 'or'),
            'modified_at' => Myclass::t('OR661', '', 'or'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('loggedin_id', $this->loggedin_id);
        $criteria->compare('loggedin_date', $this->loggedin_date, true);
        $criteria->compare('rep_credential_id', $this->rep_credential_id);
        $criteria->compare('loggedin_ip', $this->loggedin_ip, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RepLoggedinActivities the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    public function beforeSave() {
        if ($this->isNewRecord)
            $this->created_at = new CDbExpression('NOW()');

        $this->modified_at = new CDbExpression('NOW()');
        return parent::beforeSave();
    }

    public function insertLoggedinActivity() {
        $this->setIsNewRecord(true);
        $this->rep_credential_id = Yii::app()->user->id;
        $this->loggedin_date = new CDbExpression('NOW()');
        $this->loggedin_ip = $_SERVER['REMOTE_ADDR'];
        $this->save();
    }

}
