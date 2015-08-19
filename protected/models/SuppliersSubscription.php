<?php

/**
 * This is the model class for table "suppliers_subscription".
 *
 * The followings are the available columns in table 'suppliers_subscription':
 * @property integer $id
 * @property integer $ID_FOURNISSEUR
 * @property integer $payment_type
 * @property integer $subscription_type
 * @property string $txnid
 * @property string $firstname
 * @property string $lastname
 * @property double $amount
 */
class SuppliersSubscription extends CActiveRecord
{
        public $TITRE_FICHIER,$image,$ID_CATEGORIE;
        const IMAGE_SIZE = 2;
        const ACCESS_TYPES = 'jpg,png,jpeg,gif';
        const ACCESS_TYPES_WID = 'jpeg|jpg|gif|png';
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suppliers_subscription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('payment_type, subscription_type', 'required'),
                        array('TITRE_FICHIER,ID_CATEGORIE', 'required' , 'on'=>'type2'),
			array('ID_FOURNISSEUR, payment_type, subscription_type', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('txnid, firstname, lastname', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ID_FOURNISSEUR, payment_type, subscription_type, txnid, invoice_number,firstname, lastname, amount,expirydate,status,createddate,TITRE_FICHIER,ID_CATEGORIE,image', 'safe', 'on'=>'search'),
                        array('image', 'file','allowEmpty'=>false, 'types'=>self::ACCESS_TYPES ,'safe' => false, 'on'=>'type2'),
		);
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
			'id' => Myclass::t('ID'),
			'ID_FOURNISSEUR' => Myclass::t('Id Fournisseur'),
			'payment_type' => Myclass::t('OGO105','','og'),
			'subscription_type' => Myclass::t('OGO106','','og'),
			'txnid' => Myclass::t('Txnid'),
			'firstname' => Myclass::t('Firstname'),
			'lastname' => Myclass::t('Lastname'),
			'amount' => Myclass::t('OGO107','','og'),
                        'TITRE_FICHIER' => Myclass::t('OGO108','','og'),
                        'ID_CATEGORIE' => Myclass::t('OG009','','og'),
                        'image' => Myclass::t('OGO109','','og'),
                    
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

		$criteria->compare('id',$this->id);
		$criteria->compare('ID_FOURNISSEUR',$this->ID_FOURNISSEUR);
		$criteria->compare('payment_type',$this->payment_type);
		$criteria->compare('subscription_type',$this->subscription_type);
		$criteria->compare('txnid',$this->txnid,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('amount',$this->amount);

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
	 * @return SuppliersSubscription the static model class
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
