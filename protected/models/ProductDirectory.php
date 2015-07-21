<?php

/**
 * This is the model class for table "repertoire_produit".
 *
 * The followings are the available columns in table 'repertoire_produit':
 * @property integer $ID_PRODUIT
 * @property integer $ID_SECTION
 * @property string $NOM_PRODUIT_FR
 * @property string $NOM_PRODUIT_EN
 *
 * The followings are the available model relations:
 * @property RepertoireSection $iDSECTION
 * @property RepertoireProduitMarque[] $repertoireProduitMarques
 */
class ProductDirectory extends CActiveRecord
{
        public $Marques1,$Marques2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_produit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_SECTION,NOM_PRODUIT_FR, NOM_PRODUIT_EN, Marques2', 'required'),
			array('ID_SECTION', 'numerical', 'integerOnly'=>true),
                       
			array('NOM_PRODUIT_FR, NOM_PRODUIT_EN', 'length', 'max'=>70),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
                        array('Marques1,Marques2','safe'),
			array('ID_PRODUIT, ID_SECTION, NOM_PRODUIT_FR, NOM_PRODUIT_EN', 'safe', 'on'=>'search'),
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
			'Sectiontbl' => array(self::BELONGS_TO, 'RepertoireSection', 'ID_SECTION'),
			'ProduitMarquestbl' => array(self::HAS_MANY, 'RepertoireProduitMarque', 'ID_PRODUIT'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_PRODUIT' => Myclass::t('Id Produit'),
			'ID_SECTION' => Myclass::t('Section'),
			'NOM_PRODUIT_FR' => Myclass::t('Nom Produit Fr'),
			'NOM_PRODUIT_EN' => Myclass::t('Nom Produit En'),
                        'Marques2' =>  Myclass::t('Marques disponibles'), 
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

		$criteria->compare('ID_PRODUIT',$this->ID_PRODUIT);
		$criteria->compare('ID_SECTION',$this->ID_SECTION);
		$criteria->compare('NOM_PRODUIT_FR',$this->NOM_PRODUIT_FR,true);
		$criteria->compare('NOM_PRODUIT_EN',$this->NOM_PRODUIT_EN,true);

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
	 * @return ProductDirectory the static model class
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
