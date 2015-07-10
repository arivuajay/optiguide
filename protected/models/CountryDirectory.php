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
        public $repertoireRegion_count;
        
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
                        array('NOM_PAYS_FR, NOM_PAYS_EN', 'required'),
                        array('NOM_PAYS_FR, NOM_PAYS_EN', 'unique'),
			array('NOM_PAYS_FR, NOM_PAYS_EN', 'length', 'max'=>255),
                    
			// The following rule is used by search().
                        			// @todo Please remove those attributes that should not be searched.
			array('ID_PAYS, NOM_PAYS_FR, NOM_PAYS_EN, repertoireRegion_count', 'safe', 'on'=>'search'),
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
			'repertoireRegions'      => array(self::HAS_MANY, 'RegionDirectory', 'ID_PAYS'),  
                        'repertoireRegionCount' => array(self::STAT, 'RegionDirectory', 'ID_PAYS'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_PAYS' => Myclass::t('APP48'),
			'NOM_PAYS_FR' => Myclass::t('APP49'),
			'NOM_PAYS_EN' => Myclass::t('APP50'),
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
                
               // sub query to retrieve the count of posts
                $region_table = RegionDirectory::model()->tableName();
                $region_count_sql = "(select count(*) from $region_table pt where pt.ID_PAYS = t.ID_PAYS)";

                // select
                $criteria->select = array(
                    '*',
                    $region_count_sql . " as repertoireRegion_count",
                );

                // where
               //$criteria->compare($region_count_sql, $this->repertoireRegion_count);
            
		$criteria->compare('ID_PAYS',$this->ID_PAYS);
                $criteria->compare('NOM_PAYS_FR',$this->NOM_PAYS_FR,true);                       
                $criteria->compare('NOM_PAYS_EN',$this->NOM_PAYS_EN,true);
                //$criteria->together = true;
               
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,     
                        'sort'=>array
                        (
                         'defaultOrder'=>'NOM_PAYS_EN ASC',
                         'attributes' => array(                               
                             // order by
                                'repertoireRegion_count' => array(
                                    'asc'  => 'repertoireRegion_count ASC',
                                    'desc' => 'repertoireRegion_count DESC',
                                ),
                               '*',
                            ),                         
                         
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
