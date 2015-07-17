<?php

/**
 * This is the model class for table "repertoire_specialiste_type".
 *
 * The followings are the available columns in table 'repertoire_specialiste_type':
 * @property integer $ID_TYPE_SPECIALISTE
 * @property string $TYPE_SPECIALISTE_FR
 * @property string $TYPE_SPECIALISTE_EN
 * @property integer $iOrder
 *
 * The followings are the available model relations:
 * @property LienMailingSpecialistetype[] $lienMailingSpecialistetypes
 */
class ProfessionalType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_specialiste_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(                     
                        array('TYPE_SPECIALISTE_FR, TYPE_SPECIALISTE_EN', 'required'),
                        array('TYPE_SPECIALISTE_FR, TYPE_SPECIALISTE_EN', 'unique'),
			array('iOrder', 'numerical', 'integerOnly'=>true),
			array('TYPE_SPECIALISTE_FR, TYPE_SPECIALISTE_EN', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_TYPE_SPECIALISTE, TYPE_SPECIALISTE_FR, TYPE_SPECIALISTE_EN, iOrder', 'safe', 'on'=>'search'),
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
			'lienMailingSpecialistetypes' => array(self::HAS_MANY, 'LienMailingSpecialistetype', 'id_specialialistetype'),
                        'professionalDirectory' => array(self::HAS_MANY, 'ProfessionalDirectory', 'ID_TYPE_SPECIALISTE'),  
                        'professionalCount' => array(self::STAT, 'ProfessionalDirectory', 'ID_TYPE_SPECIALISTE'),
                    
		);
	}
        
       
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_TYPE_SPECIALISTE' => Myclass::t('Id Type Specialiste'),
			'TYPE_SPECIALISTE_FR' => Myclass::t('Typefranais'),
			'TYPE_SPECIALISTE_EN' => Myclass::t('Type en anglais'),
			'iOrder' => Myclass::t('I Order'),
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

		$criteria->compare('ID_TYPE_SPECIALISTE',$this->ID_TYPE_SPECIALISTE);
		$criteria->compare('TYPE_SPECIALISTE_FR',$this->TYPE_SPECIALISTE_FR,true);
		$criteria->compare('TYPE_SPECIALISTE_EN',$this->TYPE_SPECIALISTE_EN,true);
		$criteria->compare('iOrder',$this->iOrder);

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
	 * @return ProfessionalType the static model class
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
