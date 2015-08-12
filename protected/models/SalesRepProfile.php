<?php

/**
 * This is the model class for table "sales_rep_profile".
 *
 * The followings are the available columns in table 'sales_rep_profile':
 * @property integer $rep_profile_id
 * @property integer $rep_id
 * @property string $rep_profile_firstname
 * @property string $rep_profile_lastname
 * @property string $rep_profile_email
 * @property string $rep_profile_phone
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property SalesRep $rep
 */
class SalesRepProfile extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sales_rep_profile';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('rep_id, rep_profile_firstname, rep_profile_email', 'required'),
            array('rep_profile_firstname, rep_profile_email', 'required'),
            array('rep_profile_email', 'email'),
            array('rep_id', 'numerical', 'integerOnly' => true),
            array('rep_profile_firstname, rep_profile_lastname, rep_profile_email', 'length', 'max' => 255),
            array('rep_profile_phone', 'length', 'max' => 100),
            array('modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_profile_id, rep_id, rep_profile_firstname, rep_profile_lastname, rep_profile_email, rep_profile_phone, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'salesRep' => array(self::BELONGS_TO, 'SalesRep', 'rep_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rep_profile_id' => Myclass::t('Rep Profile'),
            'rep_id' => Myclass::t('Rep'),
            'rep_profile_firstname' => Myclass::t('Rep Profile Firstname'),
            'rep_profile_lastname' => Myclass::t('Rep Profile Lastname'),
            'rep_profile_email' => Myclass::t('Rep Profile Email'),
            'rep_profile_phone' => Myclass::t('Rep Profile Phone'),
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
        $criteria->compare('rep_id', $this->rep_id);
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
     * @return SalesRepProfile the static model class
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

}
