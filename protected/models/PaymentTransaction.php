<?php

/**
 * This is the model class for table "payment_transaction".
 *
 * The followings are the available columns in table 'payment_transaction':
 * @property integer $id
 * @property integer $user_id
 * @property string $total_price
 * @property string $tax
 * @property string $subscription_price
 * @property string $payment_status
 * @property string $payer_email
 * @property string $verify_sign
 * @property string $txn_id
 * @property string $payment_type
 * @property string $receiver_email
 * @property string $txn_type
 * @property string $item_name
 * @property string $ipn_track_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $NOMTABLE
 * @property string $expirydate
 * @property string $invoice_number
 * @property string $pay_type
 * @property string $subscription_type
 */
class PaymentTransaction extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentTransaction the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'payment_transaction';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(  
            array('user_id,total_price,tax,subscription_price,payment_status,payer_email,verify_sign','safe'),
            array('txn_type,item_name,ipn_track_id,created_at,updated_at','safe'),
            array('txn_id,payment_type,receiver_email,NOMTABLE,expirydate,invoice_number,total,pay_type,subscription_type' , 'safe'),            
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'total_price' => 'Mc Gross',
            'payment_status' => 'Payment Status',
            'payer_email' => 'Payer Email',
            'verify_sign' => 'Verify Sign',
            'txn_id' => 'Txn',
            'payment_type' => 'Payment Type',
            'receiver_email' => 'Receiver Email',
            'txn_type' => 'Txn Type',
            'item_name' => 'Item Name',           
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'NOMTABLE'  => 'NOMTABLE',
            'expirydate' => 'expirydate',
            'invoice_number' => 'invoice_number'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('total_price', $this->mc_gross, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payer_email', $this->payer_email, true);
        $criteria->compare('verify_sign', $this->verify_sign, true);
        $criteria->compare('txn_id', $this->txn_id, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('receiver_email', $this->receiver_email, true);
        $criteria->compare('txn_type', $this->txn_type, true);
        $criteria->compare('item_name', $this->item_name, true);        
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
  
}