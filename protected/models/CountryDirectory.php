<?php

/**
 * This is the model class for table "repertoire_pays".
 *
 * The followings are the available columns in table 'repertoire_pays':
 * @property integer $ID_PAYS
 * @property string $NOM_PAYS_FR
 * @property string $NOM_PAYS_EN
 *
 * The followings are the available model relations:
 * @property RepertoireRegion[] $repertoireRegions
 */
class CountryDirectory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_pays';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOM_PAYS_FR, NOM_PAYS_EN', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_PAYS, NOM_PAYS_FR, NOM_PAYS_EN', 'safe', 'on'=>'search'),
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
			'repertoireRegions' => array(self::HAS_MANY, 'RepertoireRegion', 'ID_PAYS'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_PAYS' => Myclass::t('Id Pays'),
			'NOM_PAYS_FR' => Myclass::t('Nom Pays Fr'),
			'NOM_PAYS_EN' => Myclass::t('Nom Pays En'),
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

		$criteria->compare('ID_PAYS',$this->ID_PAYS);
		$criteria->compare('NOM_PAYS_FR',$this->NOM_PAYS_FR,true);
		$criteria->compare('NOM_PAYS_EN',$this->NOM_PAYS_EN,true);

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
	 * @return CountryDirectory the static model class
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
