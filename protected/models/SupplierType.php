<?php

/**
 * This is the model class for table "repertoire_fournisseur_type".
 *
 * The followings are the available columns in table 'repertoire_fournisseur_type':
 * @property integer $ID_TYPE_FOURNISSEUR
 * @property string $TYPE_FOURNISSEUR_FR
 * @property string $TYPE_FOURNISSEUR_EN
 *
 * The followings are the available model relations:
 * @property RepertoireFournisseurs[] $repertoireFournisseurs
 */
class SupplierType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_fournisseur_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TYPE_FOURNISSEUR_FR, TYPE_FOURNISSEUR_EN', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_TYPE_FOURNISSEUR, TYPE_FOURNISSEUR_FR, TYPE_FOURNISSEUR_EN', 'safe', 'on'=>'search'),
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
			'suppliersDirectory' => array(self::HAS_MANY, 'SuppliersDirectory', 'ID_TYPE_FOURNISSEUR'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_TYPE_FOURNISSEUR' => Myclass::t('Id Type Fournisseur'),
			'TYPE_FOURNISSEUR_FR' => Myclass::t('Type Fournisseur Fr'),
			'TYPE_FOURNISSEUR_EN' => Myclass::t('Type Fournisseur En'),
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

		$criteria->compare('ID_TYPE_FOURNISSEUR',$this->ID_TYPE_FOURNISSEUR);
		$criteria->compare('TYPE_FOURNISSEUR_FR',$this->TYPE_FOURNISSEUR_FR,true);
		$criteria->compare('TYPE_FOURNISSEUR_EN',$this->TYPE_FOURNISSEUR_EN,true);

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
	 * @return SupplierType the static model class
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
