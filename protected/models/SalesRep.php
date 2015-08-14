<?php

/**
 * This is the model class for table "sales_rep".
 *
 * The followings are the available columns in table 'sales_rep':
 * @property integer $rep_id
 * @property string $rep_username
 * @property string $rep_password
 * @property string $rep_status
 * @property string $rep_role
 * @property integer $rep_parent_id
 * @property integer $rep_subscription_type_id
 * @property integer $rep_subscribed
 * @property string $rep_subscription_end
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property SalesRepSubscriptionTypes $repSubscriptionType
 * @property SalesRepProfile[] $salesRepProfiles
 */
class SalesRep extends CActiveRecord {
    
    const ROLE_SINGLE = 'single';
    const ROLE_COMPANY = 'company';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sales_rep';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rep_username, rep_password, rep_subscription_type_id', 'required'),
            array('rep_username', 'unique'),
            array('rep_username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u'),
            array('rep_parent_id, rep_subscription_type_id, rep_subscribed', 'numerical', 'integerOnly' => true),
            array('rep_username, rep_password', 'length', 'max' => 255),
            array('rep_status', 'length', 'max' => 1),
            array('rep_role', 'length', 'max' => 7),
            array('modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_id, rep_username, rep_password, rep_status, rep_role, rep_parent_id, rep_subscription_type_id, rep_subscribed, rep_subscription_end, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'repSubscriptionType' => array(self::BELONGS_TO, 'SalesRepSubscriptionTypes', 'rep_subscription_type_id'),
            'salesRepProfile' => array(self::HAS_ONE, 'SalesRepProfile', 'rep_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rep_id' => Myclass::t('Rep'),
            'rep_username' => Myclass::t('Rep Username'),
            'rep_password' => Myclass::t('Rep Password'),
            'rep_status' => Myclass::t('Rep Status'),
            'rep_role' => Myclass::t('Rep Role'),
            'rep_parent_id' => Myclass::t('Rep Parent'),
            'rep_subscription_type_id' => Myclass::t('Rep Subscription Type'),
            'rep_subscribed' => Myclass::t('Rep Subscribed'),
            'rep_subscription_end' => Myclass::t('Rep Subscription End'),
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

        $criteria->compare('rep_id', $this->rep_id);
        $criteria->compare('rep_username', $this->rep_username, true);
        $criteria->compare('rep_password', $this->rep_password, true);
        $criteria->compare('rep_status', $this->rep_status, true);
        $criteria->compare('rep_role', $this->rep_role, true);
        $criteria->compare('rep_parent_id', $this->rep_parent_id);
        $criteria->compare('rep_subscription_type_id', $this->rep_subscription_type_id);
        $criteria->compare('rep_subscribed', $this->rep_subscribed);
        $criteria->compare('rep_subscription_end', $this->rep_subscription_end, true);
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
     * @return SalesRep the static model class
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
