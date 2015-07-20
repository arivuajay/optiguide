<?php

/**
 * This is the model class for table "repertoire_retailer_type".
 *
 * The followings are the available columns in table 'repertoire_retailer_type':
 * @property integer $ID_RETAILER_TYPE
 * @property string $NOM_TYPE_FR
 * @property string $NOM_TYPE_EN
 * @property integer $ORDRE
 */
class RetailerType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_retailer_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOM_TYPE_FR, NOM_TYPE_EN, ORDRE', 'required'),
			array('ORDRE', 'numerical', 'integerOnly'=>true),
			array('NOM_TYPE_FR, NOM_TYPE_EN', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_RETAILER_TYPE, NOM_TYPE_FR, NOM_TYPE_EN, ORDRE', 'safe', 'on'=>'search'),
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
                    'retailerGroup'      => array(self::HAS_MANY, 'RetailerGroup', 'ID_RETAILER_TYPE'),                     
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_RETAILER_TYPE' => Myclass::t('Id Retailer Type'),
			'NOM_TYPE_FR' => Myclass::t('Nom Type Fr'),
			'NOM_TYPE_EN' => Myclass::t('Nom Type En'),
			'ORDRE' => Myclass::t('Ordre'),
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

		$criteria->compare('ID_RETAILER_TYPE',$this->ID_RETAILER_TYPE);
		$criteria->compare('NOM_TYPE_FR',$this->NOM_TYPE_FR,true);
		$criteria->compare('NOM_TYPE_EN',$this->NOM_TYPE_EN,true);
		$criteria->compare('ORDRE',$this->ORDRE);

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
	 * @return RetailerType the static model class
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
