<?php

/**
 * This is the model class for table "repertoire_renseignements_section".
 *
 * The followings are the available columns in table 'repertoire_renseignements_section':
 * @property integer $ID_SECTION
 * @property integer $ID_CATEGORIE
 * @property string $SECTION_FR
 * @property string $SECTION_EN
 *
 * The followings are the available model relations:
 * @property RepertoireRenseignementsGroupes[] $repertoireRenseignementsGroupes
 * @property RepertoireRenseignementsCategorie $iDCATEGORIE
 */
class SectionInformation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_renseignements_section';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_CATEGORIE, SECTION_FR, SECTION_EN', 'required'),
                         array('SECTION_FR, SECTION_EN', 'unique'),
			array('ID_CATEGORIE', 'numerical', 'integerOnly'=>true),
			array('SECTION_FR, SECTION_EN', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_SECTION, ID_CATEGORIE, SECTION_FR, SECTION_EN', 'safe', 'on'=>'search'),
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
			'groupInformation' => array(self::HAS_MANY, 'GroupInformation', 'ID_SECTION'),
			'categoryInformation' => array(self::BELONGS_TO, 'CategoryInformation', 'ID_CATEGORIE'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'ID_SECTION'   => Myclass::t('APP50'),
                'ID_CATEGORIE' => Myclass::t('APP69'),
                'SECTION_FR'   => Myclass::t('APP51'),
                'SECTION_EN'   => Myclass::t('APP52'),
            );
	}
        
        public static function get_allcategory()
        {
           
           // countryDirectory
           $get_catsql   =  CategoryInformation::model()->findAll(array("order"=>"CATEGORIE_FR"));
           $cat_res      = CHtml::listData($get_catsql, 'ID_CATEGORIE', 'CATEGORIE_FR'); 
           return $cat_res;
        } 
        
        public function getcategoryname()
        {
            $catid = Yii::app()->getRequest()->getQuery('id');   
            $catname = '';
            
            $criteria=new CDbCriteria;
            $criteria->addCondition('ID_CATEGORIE = :catid');
            $criteria->params = array(':catid' => (int)$catid);
            if($catid!='')
            {    
                $catinfos = CategoryInformation::model()->find($criteria);
                $catname = $catinfos->CATEGORIE_FR;
            } 
            return $catname;
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
                
                $criteria->compare('ID_SECTION',$this->ID_SECTION);

                /* get the search params*/
                $catid = Yii::app()->getRequest()->getQuery('id');            
		
                if($catid!='')
                {    
                    $criteria->compare('ID_CATEGORIE',$catid);
                }else
                {
                    $criteria->compare('ID_CATEGORIE',$this->ID_CATEGORIE);
                }    
		$criteria->compare('SECTION_FR',$this->SECTION_FR,true);
		$criteria->compare('SECTION_EN',$this->SECTION_EN,true);

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
	 * @return SectionInformation the static model class
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
