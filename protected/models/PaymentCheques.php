<?php

/**
 * This is the model class for table "payment_cheques".
 *
 * The followings are the available columns in table 'payment_cheques':
 * @property integer $cheque_id
 * @property integer $payment_transaction_id
 * @property string $cheque_num
 * @property string $cheque_account_name
 * @property string $cheque_bank
 * @property string $cheque_account_type
 * @property string $cheque_date
 * @property double $cheque_price
 * @property string $notes
 * @property string $created_date
 */
class PaymentCheques extends CActiveRecord
{
    public $subscription_type,$pay_type,$profile,$logo,$rep_expire_month;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment_cheques';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('cheque_num, cheque_account_name, cheque_bank, cheque_date, cheque_price', 'required' , 'on'=>'bycheque'),
			array('payment_transaction_id', 'numerical', 'integerOnly'=>true),
			array('cheque_price', 'numerical'),
			array('cheque_num, cheque_account_name, cheque_bank, cheque_account_type', 'length', 'max'=>255),
			array('cheque_date, notes, created_date,subscription_type,pay_type,profile,logo,rep_expire_month', 'safe'),
                        array('profile,logo','Checkatleast'), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cheque_id, payment_transaction_id, cheque_num, cheque_account_name, cheque_bank, cheque_account_type, cheque_date, cheque_price, notes, created_date', 'safe', 'on'=>'search'),
		);
	}
        
         public function Checkatleast($attribute_name, $params)
        {
          
            if ($this->profile==0 && $this->logo==0)
            {
               $this->addError('logo',"Please select atleast one subscription.");
               return false;
            }

            return true;
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cheque_id' => Myclass::t('Cheque'),
			'payment_transaction_id' => Myclass::t('Payment Transaction'),
			'cheque_num' => Myclass::t('Cheque Number'),
			'cheque_account_name' => Myclass::t('Cheque Account Name'),
			'cheque_bank' => Myclass::t('Cheque Bank'),
			'cheque_account_type' => Myclass::t('Cheque Account Type'),
			'cheque_date' => Myclass::t('Cheque Date'),
			'cheque_price' => Myclass::t('Cheque Price'),
			'notes' => Myclass::t('Notes'),
			'created_date' => Myclass::t('Created Date'),
                        'rep_expire_month'=>'Expirent mois pour',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cheque_id',$this->cheque_id);
		$criteria->compare('payment_transaction_id',$this->payment_transaction_id);
		$criteria->compare('cheque_num',$this->cheque_num,true);
		$criteria->compare('cheque_account_name',$this->cheque_account_name,true);
		$criteria->compare('cheque_bank',$this->cheque_bank,true);
		$criteria->compare('cheque_account_type',$this->cheque_account_type,true);
		$criteria->compare('cheque_date',$this->cheque_date,true);
		$criteria->compare('cheque_price',$this->cheque_price);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => PAGE_SIZE,
                        )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentCheques the static model class
	 */
	public static function model($className=__CLASS__)
	{
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
