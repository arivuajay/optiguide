<?php

/**
 * This is the model class for table "repertoire_retailer".
 *
 * The followings are the available columns in table 'repertoire_retailer':
 * @property integer $ID_RETAILER
 * @property string $ID_CLIENT
 * @property string $COMPAGNIE
 * @property integer $ID_VILLE
 * @property string $ADRESSE
 * @property string $ADRESSE2
 * @property string $CODE_POSTAL
 * @property string $TELEPHONE
 * @property string $TELEPHONE2
 * @property string $TELECOPIEUR
 * @property string $TELECOPIEUR2
 * @property string $URL
 * @property string $COURRIEL
 * @property string $TEL_1800
 * @property string $DATE_MODIFICATION
 * @property integer $ID_RETAILER_TYPE
 * @property integer $ID_GROUPE
 * @property string $GROUPE
 * @property string $HEAD_OFFICE_NAME
 * @property integer $CATEGORY_1
 * @property integer $CATEGORY_2
 * @property integer $CATEGORY_3
 * @property integer $CATEGORY_4
 * @property integer $CATEGORY_5
 *
 * The followings are the available model relations:
 * @property RepertoireVille $iDVILLE
 */
class RetailerDirectory extends CActiveRecord
{
    
        public $country,$region,$uaccess_search,$searchcat;
        static $NOM_TABLE = 'Detaillants';
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'repertoire_retailer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('COMPAGNIE, ID_RETAILER_TYPE, ID_GROUPE, country, region, ID_VILLE,CODE_POSTAL, TELEPHONE', 'required'),
			array('ID_VILLE, ID_RETAILER_TYPE, ID_GROUPE, CATEGORY_1, CATEGORY_2, CATEGORY_3, CATEGORY_4, CATEGORY_5', 'numerical', 'integerOnly'=>true),
			array('ID_CLIENT', 'length', 'max'=>10),
			array('COMPAGNIE, ADRESSE, ADRESSE2, URL, COURRIEL, GROUPE, HEAD_OFFICE_NAME', 'length', 'max'=>255),
			array('CODE_POSTAL, TELEPHONE, TELEPHONE2, TELECOPIEUR, TELECOPIEUR2, TEL_1800', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.    
                        array('CATEGORY_1,CATEGORY_2,CATEGORY_3,CATEGORY_4,CATEGORY_5','Checkatleast'),                     
                        array('Categories,uaccess_search,searchcat','safe'),
                        array('COURRIEL','email'),
                        array('URL', 'url'),
			array('uaccess_search,ID_RETAILER, ID_CLIENT, COMPAGNIE, ID_VILLE, ADRESSE, ADRESSE2, CODE_POSTAL, TELEPHONE, TELEPHONE2, TELECOPIEUR, TELECOPIEUR2, URL, COURRIEL, TEL_1800, DATE_MODIFICATION, ID_RETAILER_TYPE, ID_GROUPE, GROUPE, HEAD_OFFICE_NAME, CATEGORY_1, CATEGORY_2, CATEGORY_3, CATEGORY_4, CATEGORY_5', 'safe', 'on'=>'search'),
                        array('TELEPHONE, TELEPHONE2, TELECOPIEUR, TELECOPIEUR2,TEL_1800', 'phoneNumber'),
		);
	}
        
        public function Checkatleast($attribute_name, $params)
        {
          
            if ($this->CATEGORY_1==0 && $this->CATEGORY_2==0 && $this->CATEGORY_3==0 && $this->CATEGORY_4==0 && $this->CATEGORY_5==0)
            {
               $this->addError('CATEGORY_5',Myclass::t('OG122'));
               return false;
            }

            return true;
        }
        
        /** 
        * check the format of the phone number entered
        * @param string $attribute the name of the attribute to be validated
        * @param array $params options specified in the validation rule
        */
        public function phoneNumber($attribute,$params='')
        {
          if($this->$attribute!='' && preg_match("/[A-Za-z]+/",$this->$attribute)==1)
          {            
                $this->addError($attribute,'Invalid Format.' );          
          }        
        }

        
      
                
        public static function getcounts($id)
        {
            
           // RetailerType::model()->findAll()    ;
            return $id;
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'iDVILLE'       => array(self::BELONGS_TO, 'RepertoireVille', 'ID_VILLE'),
                        'retailerType'  => array(self::BELONGS_TO, 'RetailerType', 'ID_RETAILER_TYPE'),                 
                        'retailerGroup' => array(self::BELONGS_TO, 'RetailerGroup', 'ID_GROUPE'),                     
                        'userDirectory' => array(self::HAS_MANY, 'UserDirectory', 'ID_RELATION' , 'condition' => 'NOM_TABLE = "Detaillants"'),
                        'cntUsr'        => array(self::STAT, 'UserDirectory',  'ID_RELATION', 'condition' => 'NOM_TABLE = "Detaillants"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_RETAILER' => Myclass::t('Type'),
			'ID_CLIENT' => Myclass::t('ID'),
			'COMPAGNIE' => Myclass::t('OG101'),
			'ID_VILLE' => Myclass::t('APP70'),
			'ADRESSE' => Myclass::t('APP66'),
			'ADRESSE2' => Myclass::t('APP67'),
			'CODE_POSTAL' => Myclass::t('APP71'),
			'TELEPHONE' => Myclass::t('APP72'),
			'TELEPHONE2' => Myclass::t('APP72')." #2",
			'TELECOPIEUR' => Myclass::t('APP73'),
			'TELECOPIEUR2' => Myclass::t('Telecopieur2'),
			'URL' => Myclass::t('OG103'),
			'COURRIEL' => Myclass::t('APP75'),
			'TEL_1800' => Myclass::t('Téléphone sans frais'),
			'DATE_MODIFICATION' => Myclass::t('Date Modification'),
			'ID_RETAILER_TYPE' => Myclass::t('OG102'),
			'ID_GROUPE' => Myclass::t('OG121'),
			'GROUPE' => Myclass::t('Groupe'),
			'HEAD_OFFICE_NAME' => Myclass::t('OG127'),
			'CATEGORY_1' => Myclass::t('OG105'),
			'CATEGORY_2' => Myclass::t('OG106'),
			'CATEGORY_3' => Myclass::t('OG107'),
			'CATEGORY_4' => Myclass::t('OG108'),
			'CATEGORY_5' => Myclass::t('OG109'),    
                        'Categories' => Myclass::t('Catégories'),
                        'region'     => Myclass::t('APP48'),
                        'country'    => Myclass::t('APP68'),
                        'USR'       => Myclass::t('ID')
                        
                        
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
              
		$criteria->compare('ID_RETAILER',$this->ID_RETAILER);
		$criteria->compare('ID_CLIENT',$this->ID_CLIENT,true);
		$criteria->compare('COMPAGNIE',$this->COMPAGNIE,true);
		$criteria->compare('ID_VILLE',$this->ID_VILLE);
		$criteria->compare('ADRESSE',$this->ADRESSE,true);
		$criteria->compare('ADRESSE2',$this->ADRESSE2,true);
		$criteria->compare('CODE_POSTAL',$this->CODE_POSTAL,true);
		$criteria->compare('TELEPHONE',$this->TELEPHONE,true);
		$criteria->compare('TELEPHONE2',$this->TELEPHONE2,true);
		$criteria->compare('TELECOPIEUR',$this->TELECOPIEUR,true);
		$criteria->compare('TELECOPIEUR2',$this->TELECOPIEUR2,true);
		$criteria->compare('URL',$this->URL,true);
		$criteria->compare('COURRIEL',$this->COURRIEL,true);
		$criteria->compare('TEL_1800',$this->TEL_1800,true);
		$criteria->compare('DATE_MODIFICATION',$this->DATE_MODIFICATION,true);
		$criteria->compare('ID_RETAILER_TYPE',$this->ID_RETAILER_TYPE);
		$criteria->compare('ID_GROUPE',$this->ID_GROUPE);
		$criteria->compare('GROUPE',$this->GROUPE,true);
		$criteria->compare('HEAD_OFFICE_NAME',$this->HEAD_OFFICE_NAME,true);
		$criteria->compare('CATEGORY_1',$this->CATEGORY_1);
		$criteria->compare('CATEGORY_2',$this->CATEGORY_2);
		$criteria->compare('CATEGORY_3',$this->CATEGORY_3);
		$criteria->compare('CATEGORY_4',$this->CATEGORY_4);
		$criteria->compare('CATEGORY_5',$this->CATEGORY_5);
                
              //  $criteria->with = array( 'userDirectory' );
              //  $criteria->compare('userDirectory.MUST_VALIDATE',$this->uaccess_search,true);
                               
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
	 * @return RetailerDirectory the static model class
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
        
        protected function afterFind() {
        /* Get selected region for current category information */
        $this->region = CityDirectory::model()->findByPk($this->ID_VILLE)->ID_REGION;
        $this->country = RegionDirectory::model()->findByPk($this->region)->ID_PAYS;
        return parent::afterFind();
    }
}
