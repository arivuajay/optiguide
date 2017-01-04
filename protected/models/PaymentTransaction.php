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

    public $COMPAGNIE, $rep_username, $credit_card, $exp_month, $exp_year, $cvv2;

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
        Yii::import('ext.validators.ECCValidator');

        return array(
            array('user_id,total_price,tax,subscription_price,payment_status,payer_email,verify_sign', 'safe'),
            array('txn_type,item_name,ipn_track_id,created_at,updated_at, credit_card, exp_date, cvv2', 'safe'),
            array('txn_id,payment_type,receiver_email,NOMTABLE,expirydate,invoice_number,total,pay_type,subscription_type, rep_temp_id', 'safe'),
            array('credit_card, exp_month, exp_year, cvv2', 'required', 'on' => 'paypal_advance'),
            array('credit_card', 'ext.validators.ECCValidator'),
            array('exp_month', 'validateMonth', 'on' => 'paypal_advance'),
            array('exp_year', 'validateYear', 'on' => 'paypal_advance'),
            array('cvv2', 'numerical', 'integerOnly' => true),
            array('cvv2', 'length', 'max' => 3),
            array('COMPAGNIE', 'safe', 'on' => 'search')
        );
    }

    public function validateMonth($attribute, $params) {
        if ($this->$attribute != '') {
            if (is_scalar($this->exp_month))
                $creditCardExpiredMonth = intval($this->exp_month);

            if (is_integer($creditCardExpiredMonth) && $creditCardExpiredMonth >= 1 && $creditCardExpiredMonth <= 12) {
                return true;
            } else {
                $this->addError($attribute, Myclass::t('OR654', '', 'or'));
            }
        }
    }

    public function validateYear($attribute, $params) {
        if ($this->$attribute != '') {
            $currentYear = intval(date('Y'));
            if (is_scalar($this->exp_year))
                $creditCardExpiredYear = intval($this->exp_year);

            if (is_integer($creditCardExpiredYear) && $creditCardExpiredYear > $currentYear && $creditCardExpiredYear < $currentYear + 10) {
                return true;
            } else {
                $this->addError($attribute, Myclass::t('OR655', '', 'or'));
            }
        }
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
            'pay_type' => Myclass::t('OG196'),
            'receiver_email' => 'Récepteur Email',
            'txn_type' => 'Type de Txn',
            'item_name' => 'Nom de l\'abonnement',
            'created_at' => Myclass::t('OG195'),
            'updated_at' => 'Updated At',
            'NOMTABLE' => 'Type d\'utilisateur',
            'expirydate' => Myclass::t('OG143'),
            'invoice_number' => Myclass::t('OG144'),
            'credit_card' => Myclass::t('OG184'),
            'exp_month' => Myclass::t('Exp Month'),
            'exp_year' => Myclass::t('Exp Year'),
            'cvv2' => Myclass::t('CVV'),
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

    public function search_supplier($id) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->addCondition("user_id = '$id'");
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

    public function search_sales_rep($id) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->addCondition("user_id = '$id'");
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
        $criteria->addCondition("NOMTABLE = '" . RepCredentials::NAME_TABLE . "'");
        $criteria->with = "repCredentials";
        $criteria->together = true;
        $criteria->order = 'id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTransactionUserName($payment_transaction_id) {
        $payment_transaction = $this->model()->findByPk($payment_transaction_id);
        if ($payment_transaction['user_id']) {
            $rep_credential = $payment_transaction->repCredentials;
            return $rep_credential['rep_username'];
        } elseif ($payment_transaction['rep_temp_id']) {
            $rep_temp = RepTemp::model()->findByPk($payment_transaction['rep_temp_id']);
            $user_info = unserialize($rep_temp['rep_temp_value']);
            $rep_username = $user_info['step2']['RepCredentials']['rep_username'];
            return $rep_username;
        }
    }

    public function getTransactionUserDetails($payment_transaction_id) {
        $payment_transaction = $this->model()->findByPk($payment_transaction_id);
        $rep = array();
        if ($payment_transaction['user_id']) {
            $rep_credential = RepCredentials::model()->findByPK($payment_transaction['user_id']);
            $rep['rep_credential'] = $rep_credential;
            $rep['rep_credential_profile'] = $rep_credential->repCredentialProfiles;
        } elseif ($payment_transaction['rep_temp_id']) {
            $rep_temp = RepTemp::model()->findByPk($payment_transaction['rep_temp_id']);
            $user_info = unserialize($rep_temp['rep_temp_value']);
            $rep['rep_credential'] = $user_info['step2']['RepCredentials'];
            $rep['rep_credential_profile'] = $user_info['step2']['RepCredentialProfiles'];
        }
        return $rep;
    }

    public function getTransactionPayTypeName($pay_type) {
        if ($pay_type == 1)
            return "Standard Paypal";
        elseif ($pay_type == 2)
            return "Advance Paypal";
    }

    public function getPaymentdesc() {
        $singlesub_id = $this->rep_single_subscription_id;
        $adminsub_id = $this->rep_admin_subscription_id;

        $paymentdesc = $this->item_name;

        if ($singlesub_id) {
            $havetrans = RepSingleSubscriptions::model()->findByPk($singlesub_id);
            if ($havetrans) {
                $rep_single_no_of_months = $havetrans->rep_single_no_of_months;

                if ($rep_single_no_of_months == 12)
                    $duration = "1 Year";
                else
                    $duration = $rep_single_no_of_months . " Month";

                $paymentdesc .= " ( Single Account , " . $duration . " )";
            }
        }else if ($adminsub_id) {
            $havetrans = RepAdminSubscriptions::model()->findByPk($adminsub_id);
            if ($havetrans) {
                $no_of_accounts_purchased = $havetrans->no_of_accounts_purchased . " accounts";
                $rep_admin_no_of_months = $havetrans->rep_admin_no_of_months;

                if ($rep_admin_no_of_months == 12)
                    $duration = "1 Year";
                else
                    $duration = $rep_admin_no_of_months . " Month";

                $paymentdesc .= " ( " . $no_of_accounts_purchased . " , " . $duration . " )";
            }
        }

        return $paymentdesc;
    }

}
