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
                    array('ID_REGION,NOM_VILLE,country', 'required'),
                    array('ID_REGION,country', 'numerical', 'integerOnly'=>true),
                    array('NOM_VILLE', 'length', 'max'=>255),
                    array('NOM_VILLE', 'my_required'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('ID_VILLE, ID_REGION, NOM_VILLE', 'safe', 'on'=>'search'),
            );
                
	}
        
        public function my_required($attribute_name,$params)
        {
            
            if(isset($this->ID_REGION) && isset($this->NOM_VILLE))
            {
               $cityid = ''; 
               if(isset($this->ID_VILLE))
               {
                  $cityid =  $this->ID_VILLE;
               }    
               $res = $this->checkregionexist($this->ID_REGION,$this->NOM_VILLE,$cityid); 
               if($res=="YES")
               {
                $this->addError($attribute_name,Myclass::t('APP51'));
               } 
	    }

	}
        
        public static function get_country_info($regionid)
        {
           // countryDirectory
           $get_cntrysql   =  RegionDirectory::model()->with("countryDirectory")->findByPk($regionid);
           $cntry_res      =  $get_cntrysql->countryDirectory;      
           return $cntry_res;
        }     
        
        public function checkregionexist($regid,$ctyname,$cityid)
        {
          $res = ''  ;
          $tblename  = $this->tableName(); 
          if($regid!='' && $ctyname!='')
          {    
            if($cityid!='')
            {
                $qstring = " and ID_VILLE!=".$cityid;
            }    
            $output    = $this->model()->findAllBySql("select * from ".$tblename." where ID_REGION=".$regid." and NOM_VILLE='".$ctyname."'".$qstring);
            $count_val = count($output);
          
            if($count_val>0){ $res = "YES";}else{ $res="NO";}
          }
          
          return $res;  
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
			'regionDirectory' => array(self::BELONGS_TO, 'RegionDirectory', 'ID_REGION'),                        
		);
                
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_VILLE' => Myclass::t('Id Ville'),
			'ID_REGION' => Myclass::t('Region'),
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
		$criteria->compare('ID_REGION',$this->ID_REGION);
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