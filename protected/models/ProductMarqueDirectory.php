<?php

/**
 * This is the model class for table "repertoire_produit_marque".
 *
 * The followings are the available columns in table 'repertoire_produit_marque':
 * @property integer $ID_LIEN_MARQUE
 * @property integer $ID_PRODUIT
 * @property integer $ID_MARQUE
 *
 * The followings are the available model relations:
 * @property RepertoireFournisseurProduit[] $repertoireFournisseurProduits
 * @property RepertoireMarque $iDMARQUE
 * @property RepertoireProduit $iDPRODUIT
 */
class ProductMarqueDirectory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_produit_marque';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_PRODUIT, ID_MARQUE', 'required'),
			array('ID_PRODUIT, ID_MARQUE', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_LIEN_MARQUE, ID_PRODUIT, ID_MARQUE', 'safe', 'on'=>'search'),
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
			'repertoireFournisseurProduits' => array(self::HAS_MANY, 'RepertoireFournisseurProduit', 'ID_LIEN_PRODUIT_MARQUE'),
			'marqueDirectory' => array(self::BELONGS_TO, 'MarqueDirectory', 'ID_MARQUE'),
			'productDirectory' => array(self::BELONGS_TO, 'ProductDirectory', 'ID_PRODUIT'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_LIEN_MARQUE' => Myclass::t('Id Lien Marque'),
			'ID_PRODUIT' => Myclass::t('Id Produit'),
			'ID_MARQUE' => Myclass::t('Id Marque'),
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

		$criteria->compare('ID_LIEN_MARQUE',$this->ID_LIEN_MARQUE);
		$criteria->compare('ID_PRODUIT',$this->ID_PRODUIT);
		$criteria->compare('ID_MARQUE',$this->ID_MARQUE);

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
	 * @return ProductMarqueDirectory the static model class
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
