<?php

/**
 * This is the model class for table "repertoire_marque".
 *
 * The followings are the available columns in table 'repertoire_marque':
 * @property integer $ID_MARQUE
 * @property string $NOM_MARQUE
 * @property integer $AFFICHAGE
 *
 * The followings are the available model relations:
 * @property RepertoireProduitMarque[] $repertoireProduitMarques
 */
class MarqueDirectory extends CActiveRecord
{
    
        public $products,$ID_SECTION,$PROD_SERVICE;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_marque';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('NOM_MARQUE', 'required'),
                        array('NOM_MARQUE', 'unique'),
			//array('AFFICHAGE', 'numerical', 'integerOnly'=>true),
			array('NOM_MARQUE', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
                        array('products,ID_SECTION,PROD_SERVICE','safe'),
			array('ID_MARQUE, NOM_MARQUE, AFFICHAGE', 'safe', 'on'=>'search'),
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
                        'productMarqueDirectory'    => array(self::HAS_MANY, 'ProductMarqueDirectory', 'ID_MARQUE'),
		);
	}
        
        public function scopes() {
            $alias = $this->getTableAlias(false, false);
            return array(
                'isActive' => array('condition' => "$alias.AFFICHAGE = '1'"),
            );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_MARQUE' => Myclass::t('Id Marque'),
			'NOM_MARQUE' => Myclass::t('Nom Marque'),
			'AFFICHAGE' => Myclass::t('Affichage'),
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

		$criteria->compare('ID_MARQUE',$this->ID_MARQUE);
		$criteria->compare('NOM_MARQUE',$this->NOM_MARQUE,true);
		$criteria->compare('AFFICHAGE',$this->AFFICHAGE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'defaultOrder'=>'NOM_MARQUE ASC',
                          ),
                        'pagination' => array(
                            'pageSize' => PAGE_SIZE,
                        )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MarqueDirectory the static model class
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
