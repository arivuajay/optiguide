<?php

/**
 * This is the model class for table "archive_fichier".
 *
 * The followings are the available columns in table 'archive_fichier':
 * @property integer $ID_FICHIER
 * @property integer $ID_CATEGORIE
 * @property string $FICHIER
 * @property string $TITRE_FICHIER_FR
 * @property string $TITRE_FICHIER_EN
 * @property string $MOTS_CLE
 * @property string $EXTENSION
 * @property string $DATE_DEPOT
 * @property integer $DISPONIBLE
 *
 * The followings are the available model relations:
 * @property ArchiveCategorie $iDCATEGORIE
 * @property MailingMailing[] $mailingMailings
 * @property MailingMailing[] $mailingMailings1
 * @property MailingMailing[] $mailingMailings2
 * @property MailingMailing[] $mailingMailings3
 * @property MailingMailing[] $mailingMailings4
 * @property MailingMailing[] $mailingMailings5
 * @property MailingMailing[] $mailingMailings6
 * @property MailingMailing[] $mailingMailings7
 * @property MailingMailing[] $mailingMailings8
 * @property MailingMailing[] $mailingMailings9
 * @property MailingMailing[] $mailingMailings10
 * @property NouvelleNouvelle[] $nouvelleNouvelles
 * @property PublicitePublicite[] $publicitePublicites
 * @property RepertoireFournisseurs[] $repertoireFournisseurs
 */
class ArchiveFichier extends CActiveRecord
{
        const IMAGE_SIZE = 2;
        const ACCESS_TYPES = 'jpg,png,jpeg,gif,pdf,html,bmp';
        const ACCESS_TYPES_WID = 'jpeg|jpg|gif|png|pdf|html|bmp';
         public $image;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'archive_fichier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_CATEGORIE,TITRE_FICHIER_FR,TITRE_FICHIER_EN', 'required'),
			array('ID_CATEGORIE, DISPONIBLE', 'numerical', 'integerOnly'=>true),
			array('TITRE_FICHIER_FR, TITRE_FICHIER_EN', 'length', 'max'=>255),
			array('MOTS_CLE', 'length', 'max'=>500),
			array('EXTENSION', 'length', 'max'=>5),
                       // array('FICHIER', 'file', 'allowEmpty'=>false , 'types'=>  self::ACCESS_TYPES, 'maxSize' => 1024 * 1024 * self::IMAGE_SIZE, 'tooLarge' => 'File should be smaller than ' . self::IMAGE_SIZE . 'MB'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_FICHIER, ID_CATEGORIE, FICHIER, TITRE_FICHIER_FR, TITRE_FICHIER_EN, MOTS_CLE, EXTENSION, DATE_DEPOT, DISPONIBLE', 'safe', 'on'=>'search'),
                        array('image', 'file','allowEmpty'=>true, 'types'=>self::ACCESS_TYPES ,'safe' => false),
                        array('image', 'file','allowEmpty'=>false, 'types'=>self::ACCESS_TYPES ,'safe' => false , 'on'=>'create'),
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
			'archiveCategory' => array(self::BELONGS_TO, 'ArchiveCategory', 'ID_CATEGORIE'),
			'mailingMailings' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub1'),
			'mailingMailings1' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub2'),
			'mailingMailings2' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub7'),
			'mailingMailings3' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub3'),
			'mailingMailings4' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub4'),
			'mailingMailings5' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub5'),
			'mailingMailings6' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub6'),
			'mailingMailings7' => array(self::HAS_MANY, 'MailingMailing', 'iId_fichier_html'),
			'mailingMailings8' => array(self::HAS_MANY, 'MailingMailing', 'iId_fichier_friend_html'),
			'mailingMailings9' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_pub_no4'),
			'mailingMailings10' => array(self::HAS_MANY, 'MailingMailing', 'id_fichier_catalogue'),
			'nouvelleNouvelles' => array(self::HAS_MANY, 'NouvelleNouvelle', 'ID_FICHIER'),
			'publicitePublicites' => array(self::HAS_MANY, 'PublicitePublicite', 'ID_FICHIER'),
			'repertoireFournisseurs' => array(self::HAS_MANY, 'RepertoireFournisseurs', 'iId_fichier'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_FICHIER' => Myclass::t('Id Fichier'),
			'ID_CATEGORIE' => Myclass::t('OG009','','og'),
			'image' => Myclass::t('Fichier'),
			'TITRE_FICHIER_FR' => Myclass::t('Titre en Français'),
			'TITRE_FICHIER_EN' => Myclass::t('Titre en Anglais'),
			'MOTS_CLE' => Myclass::t('Mots Cle'),
			'EXTENSION' => Myclass::t('Extension'),
			'DATE_DEPOT' => Myclass::t('Date Depot'),
			'DISPONIBLE' => Myclass::t('Mettre l\'archive active'),                       
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

		$criteria->compare('ID_FICHIER',$this->ID_FICHIER);		
                /* get the search params*/
                $catid = Yii::app()->getRequest()->getQuery('id');    
                if($catid!='')
                {                      
                    $criteria->addCondition('archiveCategory.ID_CATEGORIE = :catid');
                    $criteria->params = array(':catid' => (int)$catid);
                }else
                {                   
                    $criteria->addCondition('archiveCategory.ID_CATEGORIE = :catid');
                    $criteria->params = array(':catid' => (int)$this->ID_CATEGORIE);
                }   

		$criteria->compare('FICHIER',$this->FICHIER,true);
		$criteria->compare('TITRE_FICHIER_FR',$this->TITRE_FICHIER_FR,true);
		$criteria->compare('TITRE_FICHIER_EN',$this->TITRE_FICHIER_EN,true);
		$criteria->compare('MOTS_CLE',$this->MOTS_CLE,true);
		$criteria->compare('EXTENSION',$this->EXTENSION,true);
		$criteria->compare('DATE_DEPOT',$this->DATE_DEPOT,true);
		$criteria->compare('DISPONIBLE',$this->DISPONIBLE);
                
                $criteria->with = array(
                  "archiveCategory" => array(
                    'alias' => 'archiveCategory', 
                    'select' => 'archiveCategory.NOM_CATEGORIE_FR'
                  )
                );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'defaultOrder'=>'TITRE_FICHIER_FR ASC',
                          ),
                        'pagination' => array(
                            'pageSize' => PAGE_SIZE,
                        )
		));
	}
        
         public static function get_allcategory()
        {
           $lang = "FR";
           if (Yii::app()->session['language'] == "EN") 
           {
               $lang = "EN";
           }      
           $get_catsql   =  ArchiveCategory::model()->findAll(array("condition"=>"NOM_CATEGORIE_$lang!=''","order"=>"NOM_CATEGORIE_".$lang));
           $cat_res      = CHtml::listData($get_catsql, 'ID_CATEGORIE', 'NOM_CATEGORIE_'.$lang); 
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
                $catinfos = ArchiveCategory::model()->find($criteria);
                $catname = $catinfos->NOM_CATEGORIE_FR;
            } 
            return $catname;
        }       

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArchiveFichier the static model class
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
