<?php

/**
 * This is the model class for table "repertoire_retailer_groupe".
 *
 * The followings are the available columns in table 'repertoire_retailer_groupe':
 * @property integer $ID_GROUPE
 * @property integer $ID_RETAILER_TYPE
 * @property string $NOM_GROUPE
 */
class RetailerGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_retailer_groupe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_GROUPE, ID_RETAILER_TYPE, NOM_GROUPE', 'required'),
			array('ID_GROUPE, ID_RETAILER_TYPE', 'numerical', 'integerOnly'=>true),
			array('NOM_GROUPE', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_GROUPE, ID_RETAILER_TYPE, NOM_GROUPE', 'safe', 'on'=>'search'),
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
                    'retailerType'      => array(self::BELONGS_TO, 'RetailerType', 'ID_RETAILER_TYPE'),                 
                    'retailerDirectory' => array(self::HAS_MANY, 'RetailerDirectory', 'ID_GROUPE'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_GROUPE' => Myclass::t('Id Groupe'),
			'ID_RETAILER_TYPE' => Myclass::t('Id Retailer Type'),
			'NOM_GROUPE' => Myclass::t('Nom Groupe'),
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

		$criteria->compare('ID_GROUPE',$this->ID_GROUPE);
		$criteria->compare('ID_RETAILER_TYPE',$this->ID_RETAILER_TYPE);
		$criteria->compare('NOM_GROUPE',$this->NOM_GROUPE,true);

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
	 * @return RetailerGroup the static model class
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
