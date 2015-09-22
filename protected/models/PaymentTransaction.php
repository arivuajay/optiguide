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
 * @property string $rep_temp_id
 */
class PaymentTransaction extends CActiveRecord {

    public $COMPAGNIE, $rep_username;

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
            array('user_id,total_price,tax,subscription_price,payment_status,payer_email,verify_sign', 'safe'),
            array('txn_type,item_name,ipn_track_id,created_at,updated_at', 'safe'),
            array('txn_id,payment_type,receiver_email,NOMTABLE,expirydate,invoice_number,total,pay_type,subscription_type, rep_temp_id', 'safe'),
            array('COMPAGNIE', 'safe', 'on' => 'search')
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'suppliersDirectory' => array(self::BELONGS_TO, 'SuppliersDirectory', 'user_id'),
            'repCredentials' => array(self::BELONGS_TO, 'RepCredentials', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => Myclass::t('APP2'),
            'total_price' => Myclass::t('OG138'),
            'payment_status' => Myclass::t('OG140'),
            'payer_email' => Myclass::t('OG141'),
            'verify_sign' => 'Vérifiez Connexion',
            'txn_id' => 'Txn Id',
            'payment_type' => Myclass::t('OG142'),
            'receiver_email' => 'Récepteur Email',
            'txn_type' => 'Type de Txn',
            'item_name' => 'Nom de l\'abonnement',
            'created_at' => 'Reçu le',
            'updated_at' => 'Updated At',
            'NOMTABLE' => 'Type d\'utilisateur',
            'expirydate' => Myclass::t('OG143'),
            'invoice_number' => Myclass::t('OG144'),
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
        $criteria->compare('total_price', $this->total_price, true);
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
        $criteria->compare('suppliersDirectory.COMPAGNIE', $this->COMPAGNIE, true);
        $criteria->addCondition("NOMTABLE = 'suppliers'");
        $criteria->with = "suppliersDirectory";
        $criteria->together = true;
        $criteria->order = 'id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchrep() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('total_price', $this->total_price, true);
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
        $criteria->compare('repCredentials.rep_username', $this->rep_username, true);
        $criteria->addCondition("NOMTABLE = 'rep_credentials'");
        $criteria->with = "repCredentials";
        $criteria->together = true;
        $criteria->order = 'id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
