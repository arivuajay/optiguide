<?php

/**
 * This is the model class for table "rep_credential_profiles".
 *
 * The followings are the available columns in table 'rep_credential_profiles':
 * @property integer $rep_profile_id
 * @property integer $rep_credential_id
 * @property string $rep_profile_firstname
 * @property string $rep_profile_lastname
 * @property string $rep_profile_email
 * @property string $rep_profile_phone
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property RepCredentials $repCredential
 */
class RepCredentialProfiles extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rep_credential_profiles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rep_profile_firstname, rep_profile_email', 'required', 'on' => 'step2'),
            array('rep_profile_email', 'email'),
            array('rep_credential_id', 'numerical', 'integerOnly' => true),
            array('rep_profile_firstname, rep_profile_email, rep_profile_phone', 'length', 'max' => 255),
            array('rep_profile_lastname', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_profile_id, rep_credential_id, rep_profile_firstname, rep_profile_lastname, rep_profile_email, rep_profile_phone, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'rep_profile_id' => Myclass::t('Rep Profile'),
            'rep_credential_id' => Myclass::t('Rep Credential'),
            'rep_profile_firstname' => Myclass::t('Firstname'),
            'rep_profile_lastname' => Myclass::t('Lastname'),
            'rep_profile_email' => Myclass::t('Email'),
            'rep_profile_phone' => Myclass::t('Phone'),
            'created_at' => Myclass::t('Created At'),
            'modified_at' => Myclass::t('Modified At'),
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

        $criteria->compare('rep_profile_id', $this->rep_profile_id);
        $criteria->compare('rep_credential_id', $this->rep_credential_id);
        $criteria->compare('rep_profile_firstname', $this->rep_profile_firstname, true);
        $criteria->compare('rep_profile_lastname', $this->rep_profile_lastname, true);
        $criteria->compare('rep_profile_email', $this->rep_profile_email, true);
        $criteria->compare('rep_profile_phone', $this->rep_profile_phone, true);
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
     * @return RepCredentialProfiles the static model class
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

}
