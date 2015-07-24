<?php

/**
 * This is the model class for table "repertoire_fournisseur_produit".
 *
 * The followings are the available columns in table 'repertoire_fournisseur_produit':
 * @property integer $ID_LIEN_REPERTOIRE_PRODUIT
 * @property integer $ID_FOURNISSEUR
 * @property integer $ID_LIEN_PRODUIT_MARQUE
 *
 * The followings are the available model relations:
 * @property RepertoireProduitMarque $iDLIENPRODUITMARQUE
 * @property RepertoireFournisseurs $iDFOURNISSEUR
 */
class SupplierProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_fournisseur_produit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_FOURNISSEUR, ID_LIEN_PRODUIT_MARQUE', 'required'),
			array('ID_FOURNISSEUR, ID_LIEN_PRODUIT_MARQUE', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_LIEN_REPERTOIRE_PRODUIT, ID_FOURNISSEUR, ID_LIEN_PRODUIT_MARQUE', 'safe', 'on'=>'search'),
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
			'productMarqueDirectory' => array(self::BELONGS_TO, 'ProductMarqueDirectory', 'ID_LIEN_PRODUIT_MARQUE'),
			'suppliersDirectory'  => array(self::BELONGS_TO, 'SuppliersDirectory', 'ID_FOURNISSEUR'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_LIEN_REPERTOIRE_PRODUIT' => Myclass::t('Id Lien Repertoire Produit'),
			'ID_FOURNISSEUR' => Myclass::t('Id Fournisseur'),
			'ID_LIEN_PRODUIT_MARQUE' => Myclass::t('Id Lien Produit Marque'),
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

		$criteria->compare('ID_LIEN_REPERTOIRE_PRODUIT',$this->ID_LIEN_REPERTOIRE_PRODUIT);
		$criteria->compare('ID_FOURNISSEUR',$this->ID_FOURNISSEUR);
		$criteria->compare('ID_LIEN_PRODUIT_MARQUE',$this->ID_LIEN_PRODUIT_MARQUE);

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
	 * @return SupplierProducts the static model class
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
