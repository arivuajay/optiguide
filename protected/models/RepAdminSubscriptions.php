<?php

/**
 * This is the model class for table "rep_admin_subscriptions".
 *
 * The followings are the available columns in table 'rep_admin_subscriptions':
 * @property integer $rep_admin_subscription_id
 * @property integer $rep_credential_id
 * @property integer $rep_subscription_type_id
 * @property string $purchase_type
 * @property integer $no_of_accounts_purchased
 * @property integer $rep_admin_old_active_accounts
 * @property integer $no_of_accounts_used
 * @property integer $no_of_accounts_remaining
 * @property double $rep_admin_per_account_price
 * @property double $rep_admin_total_price
 * @property double $rep_admin_tax
 * @property double $rep_admin_grand_total
 * @property string $rep_admin_subscription_start
 * @property string $rep_admin_subscription_end
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property RepSubscriptionTypes $repSubscriptionType
 * @property RepCredentials $repCredential
 */
class RepAdminSubscriptions extends CActiveRecord {

    const PURCHASE_TYPE_NEW = 'new';
    const PURCHASE_TYPE_RENEWAL = 'renewal';

    public $total_no_of_accounts_purchased;
    public $total_no_of_accounts_used;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rep_admin_subscriptions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rep_credential_id, rep_subscription_type_id, no_of_accounts_purchased, rep_admin_per_account_price, rep_admin_total_price, rep_admin_tax, rep_admin_grand_total, rep_admin_subscription_start, rep_admin_subscription_end, created_at, modified_at', 'required'),
            array('rep_credential_id, rep_subscription_type_id, no_of_accounts_purchased, rep_admin_old_active_accounts, no_of_accounts_used, no_of_accounts_remaining', 'numerical', 'integerOnly' => true),
            array('rep_admin_per_account_price, rep_admin_total_price, rep_admin_tax, rep_admin_grand_total', 'numerical'),
            array('purchase_type', 'length', 'max' => 7),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_admin_subscription_id, rep_credential_id, rep_subscription_type_id, purchase_type,  no_of_accounts_purchased, rep_admin_old_active_accounts, no_of_accounts_used, no_of_accounts_remaining, rep_admin_per_account_price, rep_admin_total_price, rep_admin_tax, rep_admin_grand_total, rep_admin_subscription_start, rep_admin_subscription_end, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'repAdminSubscribers' => array(self::HAS_MANY, 'RepAdminSubscribers', 'rep_admin_subscription_id'),
            'repSubscriptionType' => array(self::BELONGS_TO, 'RepSubscriptionTypes', 'rep_subscription_type_id'),
            'repCredential' => array(self::BELONGS_TO, 'RepCredentials', 'rep_credential_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rep_admin_subscription_id' => Myclass::t('Rep Admin Subscription'),
            'rep_credential_id' => Myclass::t('Rep Credential'),
            'rep_subscription_type_id' => Myclass::t('Rep Subscription Type'),
            'purchase_type' => Myclass::t('Purchase Type'),
            'no_of_accounts_purchased' => Myclass::t('No Of Accounts Purchased'),
            'rep_admin_old_active_accounts' => Myclass::t('Old active accounts'),
            'no_of_accounts_used' => Myclass::t('No Of Accounts Used'),
            'no_of_accounts_remaining' => Myclass::t('No Of Accounts Remaining'),
            'rep_admin_per_account_price' => Myclass::t('Rep Admin Per Account Price'),
            'rep_admin_total_price' => Myclass::t('Rep Admin Total Price'),
            'rep_admin_tax' => Myclass::t('Rep Admin Tax'),
            'rep_admin_grand_total' => Myclass::t('Rep Admin Grand Total'),
            'rep_admin_subscription_start' => Myclass::t('Rep Admin Subscription Start'),
            'rep_admin_subscription_end' => Myclass::t('Rep Admin Subscription End'),
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

        $criteria->compare('rep_admin_subscription_id', $this->rep_admin_subscription_id);
        $criteria->compare('rep_credential_id', $this->rep_credential_id);
        $criteria->compare('rep_subscription_type_id', $this->rep_subscription_type_id);
        $criteria->compare('purchase_type', $this->purchase_type, true);
        $criteria->compare('no_of_accounts_purchased', $this->no_of_accounts_purchased);
        $criteria->compare('rep_admin_old_active_accounts', $this->rep_admin_old_active_accounts);
        $criteria->compare('no_of_accounts_used', $this->no_of_accounts_used);
        $criteria->compare('no_of_accounts_remaining', $this->no_of_accounts_remaining);
        $criteria->compare('rep_admin_per_account_price', $this->rep_admin_per_account_price);
        $criteria->compare('rep_admin_total_price', $this->rep_admin_total_price);
        $criteria->compare('rep_admin_tax', $this->rep_admin_tax);
        $criteria->compare('rep_admin_grand_total', $this->rep_admin_grand_total);
        $criteria->compare('rep_admin_subscription_start', $this->rep_admin_subscription_start, true);
        $criteria->compare('rep_admin_subscription_end', $this->rep_admin_subscription_end, true);
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
     * @return RepAdminSubscriptions the static model class
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

    //Check Admin Current Plan for add a new subscribers.
    public function getCurrentPlan() {
        $criteria = new CDbCriteria;
        $criteria->join = "INNER JOIN rep_admin_subscriptions t2 ON(t.rep_admin_subscription_id = t2.rep_admin_subscription_id)";
        $criteria->condition = 't.rep_credential_id = :admin_id AND t.purchase_type = :type AND t.no_of_accounts_remaining > :rema AND t.rep_admin_subscription_start <= :today AND t.rep_admin_subscription_end >= :today AND t.no_of_accounts_used < t2.no_of_accounts_purchased';
        $criteria->params = array(
            ':admin_id' => Yii::app()->user->id,
            ':type' => self::PURCHASE_TYPE_NEW,
            ':rema' => 0,
            ':today' => date("Y-m-d")
        );
        $admin_current_plan = $this->model()->find($criteria);
        return $admin_current_plan;
    }

    public function getTotalNoOfAccountsPurchased() {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(no_of_accounts_purchased) as total_no_of_accounts_purchased';
        $criteria->condition = 'rep_credential_id = :admin_id AND purchase_type = :type';
        $criteria->params = array(
            ':admin_id' => Yii::app()->user->id,
            ':type' => self::PURCHASE_TYPE_NEW,
        );
        $result = $this->model()->findAll($criteria);
        return $result[0]['total_no_of_accounts_purchased'];
    }

    public function getTotalNoOfAccountsUsed() {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(no_of_accounts_used) as total_no_of_accounts_used';
        $criteria->condition = 'rep_credential_id = :admin_id AND purchase_type = :type';
        $criteria->params = array(
            ':admin_id' => Yii::app()->user->id,
            ':type' => self::PURCHASE_TYPE_NEW,
        );
        $result = $this->model()->findAll($criteria);
        return $result[0]['total_no_of_accounts_used'];
    }

    public function canBuyMoreAccounts() {
        $total_no_of_accounts_purchased = $this->getTotalNoOfAccountsPurchased();
        $total_no_of_accounts_used = $this->getTotalNoOfAccountsUsed();
        if($total_no_of_accounts_purchased == $total_no_of_accounts_used){
            return true;
        } 
        return false;
    }

}
