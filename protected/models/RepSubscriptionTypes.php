<?php

/**
 * This is the model class for table "rep_subscription_types".
 *
 * The followings are the available columns in table 'rep_subscription_types':
 * @property integer $rep_subscription_type_id
 * @property string $rep_subscription_name
 * @property double $rep_subscription_price
 * @property string $rep_subscription_description
 * @property integer $rep_subscription_min
 * @property integer $rep_subscription_max
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property RepSingleSubscriptions[] $repSingleSubscriptions
 */
class RepSubscriptionTypes extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rep_subscription_types';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rep_subscription_name, rep_subscription_price, rep_subscription_min, rep_subscription_max, created_at, modified_at', 'required'),
            array('rep_subscription_min, rep_subscription_max', 'numerical', 'integerOnly' => true),
            array('rep_subscription_price', 'numerical'),
            array('rep_subscription_name', 'length', 'max' => 100),
            array('rep_subscription_description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_subscription_type_id, rep_subscription_name, rep_subscription_price, rep_subscription_description, rep_subscription_min, rep_subscription_max, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'repAdminSubscriptions' => array(self::HAS_MANY, 'RepAdminSubscriptions', 'rep_subscription_type_id'),
            'repSingleSubscriptions' => array(self::HAS_MANY, 'RepSingleSubscriptions', 'rep_subscription_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rep_subscription_type_id' => Myclass::t('OR665', '', 'or'),
            'rep_subscription_name' => Myclass::t('OR704', '', 'or'),
            'rep_subscription_price' => Myclass::t('OR705', '', 'or'),
            'rep_subscription_description' => Myclass::t('OR706', '', 'or'),
            'rep_subscription_min' => Myclass::t('OR707', '', 'or'),
            'rep_subscription_max' => Myclass::t('OR708', '', 'or'),
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

        $criteria->compare('rep_subscription_type_id', $this->rep_subscription_type_id);
        $criteria->compare('rep_subscription_name', $this->rep_subscription_name, true);
        $criteria->compare('rep_subscription_price', $this->rep_subscription_price);
        $criteria->compare('rep_subscription_description', $this->rep_subscription_description, true);
        $criteria->compare('rep_subscription_min', $this->rep_subscription_min);
        $criteria->compare('rep_subscription_max', $this->rep_subscription_max);
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
     * @return RepSubscriptionTypes the static model class
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

    public function findByAccountMembers($no_of_accounts) {
        if ($no_of_accounts == 1) {
            $max = 1;
        } elseif ($no_of_accounts <= 5) {
            $max = 5;
        } elseif ($no_of_accounts <= 10) {
            $max = 10;
        } elseif ($no_of_accounts >= 11) {
            $max = 0;
        }
        $type = $this->model()->find('rep_subscription_max = :max', array(':max' => $max));
        return $type;
    }

}
