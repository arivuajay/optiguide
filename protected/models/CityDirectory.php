<?php

/**
 * This is the model class for table "repertoire_ville".
 *
 * The followings are the available columns in table 'repertoire_ville':
 * @property integer $ID_VILLE
 * @property integer $ID_REGION
 * @property string $NOM_VILLE
 *
 * The followings are the available model relations:
 * @property RepertoireRetailer[] $repertoireRetailers
 * @property RepertoireRegion $iDREGION
 */
class CityDirectory extends CActiveRecord
{
    
    public $country;
    public $REGION;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_ville';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('REGION,NOM_VILLE,country', 'required'),
			array('REGION,country', 'numerical', 'integerOnly'=>true),
			array('NOM_VILLE', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_VILLE, ID_REGION, NOM_VILLE', 'safe', 'on'=>'search'),
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
			'repertoireRetailers' => array(self::HAS_MANY, 'RepertoireRetailer', 'ID_VILLE'),
			'iDREGION' => array(self::BELONGS_TO, 'RegionDirectory', 'ID_REGION'),
                        //'country' => array(self::BELONGS_TO, 'CountryDirectory', 'ID_PAYS')
		);
                
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_VILLE' => Myclass::t('Id Ville'),
			'REGION' => Myclass::t('Region'),
			'NOM_VILLE' => Myclass::t('Nom Ville'),
                        'country'   => Myclass::t('Country'),
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

		$criteria->compare('ID_VILLE',$this->ID_VILLE);
		$criteria->compare('REGION',$this->ID_REGION);
		$criteria->compare('NOM_VILLE',$this->NOM_VILLE,true);

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
	 * @return CityDirectory the static model class
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
