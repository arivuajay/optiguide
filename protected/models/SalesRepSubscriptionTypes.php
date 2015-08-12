<?php

/**
 * This is the model class for table "sales_rep_subscription_types".
 *
 * The followings are the available columns in table 'sales_rep_subscription_types':
 * @property integer $rep_subscription_type_id
 * @property string $rep_subscription_type_name
 * @property double $rep_subscription_type_amount
 * @property string $rep_subscription_type_description
 * @property integer $rep_subscription_type_max
 * @property string $rep_subscription_type_status
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property SalesRep[] $salesReps
 */
class SalesRepSubscriptionTypes extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sales_rep_subscription_types';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rep_subscription_type_name, rep_subscription_type_amount, rep_subscription_type_max, created_at', 'required'),
            array('rep_subscription_type_max', 'numerical', 'integerOnly' => true),
            array('rep_subscription_type_amount', 'numerical'),
            array('rep_subscription_type_name', 'length', 'max' => 255),
            array('rep_subscription_type_status', 'length', 'max' => 1),
            array('rep_subscription_type_description, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_subscription_type_id, rep_subscription_type_name, rep_subscription_type_amount, rep_subscription_type_description, rep_subscription_type_max, rep_subscription_type_status, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'salesReps' => array(self::HAS_MANY, 'SalesRep', 'rep_subscription_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rep_subscription_type_id' => Myclass::t('Rep Subscription Type'),
            'rep_subscription_type_name' => Myclass::t('Rep Subscription Type Name'),
            'rep_subscription_type_amount' => Myclass::t('Rep Subscription Type Amount'),
            'rep_subscription_type_description' => Myclass::t('Rep Subscription Type Description'),
            'rep_subscription_type_max' => Myclass::t('Rep Subscription Type Max'),
            'rep_subscription_type_status' => Myclass::t('Rep Subscription Type Status'),
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

        $criteria->compare('rep_subscription_type_id', $this->rep_subscription_type_id);
        $criteria->compare('rep_subscription_type_name', $this->rep_subscription_type_name, true);
        $criteria->compare('rep_subscription_type_amount', $this->rep_subscription_type_amount);
        $criteria->compare('rep_subscription_type_description', $this->rep_subscription_type_description, true);
        $criteria->compare('rep_subscription_type_max', $this->rep_subscription_type_max);
        $criteria->compare('rep_subscription_type_status', $this->rep_subscription_type_status, true);
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
     * @return SalesRepSubscriptionTypes the static model class
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
