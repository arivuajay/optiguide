<?php

/**
 * This is the model class for table "rep_single_subscriptions".
 *
 * The followings are the available columns in table 'rep_single_subscriptions':
 * @property integer $rep_single_subscription_id
 * @property integer $rep_credential_id
 * @property integer $rep_subscription_type_id
 * @property string $purchase_type
 * @property double $rep_single_price
 * @property double $rep_single_tax
 * @property double $rep_single_total
 * @property string $rep_single_subscription_start
 * @property string $rep_single_subscription_end
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property RepCredentials $repCredential
 * @property RepSubscriptionTypes $repSubscriptionType
 */
class RepSingleSubscriptions extends CActiveRecord {
    
    const PURCHASE_TYPE_NEW = 'new';
    const PURCHASE_TYPE_RENEWAL = 'renewal';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rep_single_subscriptions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rep_credential_id, rep_single_price, rep_single_tax, rep_single_total, rep_single_subscription_start, rep_single_subscription_end', 'required'),
            array('rep_credential_id, rep_subscription_type_id', 'numerical', 'integerOnly' => true),
            array('rep_single_price, rep_single_tax, rep_single_total', 'numerical'),
            array('purchase_type', 'length', 'max'=>7),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_single_subscription_id, rep_credential_id, rep_subscription_type_id, purchase_type, rep_single_price, rep_single_tax, rep_single_total, rep_single_subscription_start, rep_single_subscription_end, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'repSubscriptionType' => array(self::BELONGS_TO, 'RepSubscriptionTypes', 'rep_subscription_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rep_single_subscription_id' => Myclass::t('Rep Single Subscription'),
            'rep_credential_id' => Myclass::t('Rep Credential'),
            'rep_subscription_type_id' => Myclass::t('Rep Subscription Type'),
            'purchase_type' => Myclass::t('Purchase Type'),
            'rep_single_price' => Myclass::t('Rep Single Price'),
            'rep_single_tax' => Myclass::t('Rep Single Tax'),
            'rep_single_total' => Myclass::t('Rep Single Total'),
            'rep_single_subscription_start' => Myclass::t('Rep Single Subscription Start'),
            'rep_single_subscription_end' => Myclass::t('Rep Single Subscription End'),
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

        $criteria->compare('rep_single_subscription_id', $this->rep_single_subscription_id);
        $criteria->compare('rep_credential_id', $this->rep_credential_id);
        $criteria->compare('rep_subscription_type_id', $this->rep_subscription_type_id);
        $criteria->compare('purchase_type',$this->purchase_type,true);
        $criteria->compare('rep_single_price', $this->rep_single_price);
        $criteria->compare('rep_single_tax', $this->rep_single_tax);
        $criteria->compare('rep_single_total', $this->rep_single_total);
        $criteria->compare('rep_single_subscription_start', $this->rep_single_subscription_start, true);
        $criteria->compare('rep_single_subscription_end', $this->rep_single_subscription_end, true);
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
     * @return RepSingleSubscriptions the static model class
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
    
    public function repSingleSubscriptionDetails($rep_credential_id){
        $criteria = new CDbCriteria;
        $criteria->addCondition("rep_credential_id = '$rep_credential_id'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function beforeSave() {
        if ($this->isNewRecord)
            $this->created_at = new CDbExpression('NOW()');

        $this->modified_at = new CDbExpression('NOW()');
        return parent::beforeSave();
    }
    
    public function repSinglePaymentTransactionLink($rep_credential_id, $rep_single_subscription_id) {
        $linkval = "<a href='javascript:void(0)' data-target='#rep-payment-modal' data-toggle='modal' class='payment_popup' id=" . $rep_credential_id . " data-single-subs-id = ".$rep_single_subscription_id." data-admin-subs-id = 0>View More</a>";
        return $linkval;
    }

}
