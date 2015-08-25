<?php

/**
 * This is the model class for table "repertoire_fournisseurs".
 *
 * The followings are the available columns in table 'repertoire_fournisseurs':
 * @property integer $ID_FOURNISSEUR
 * @property string $COMPAGNIE
 * @property string $ID_CLIENT
 * @property integer $ID_TYPE_FOURNISSEUR
 * @property string $ADRESSE
 * @property string $ADRESSE2
 * @property integer $ID_VILLE
 * @property string $CODE_POSTAL
 * @property string $TELEPHONE
 * @property string $TELECOPIEUR
 * @property string $TITRE_TEL_SANS_FRAIS
 * @property string $TITRE_TEL_SANS_FRAIS_EN
 * @property string $TEL_SANS_FRAIS
 * @property string $TITRE_TEL_SECONDAIRE
 * @property string $TITRE_TEL_SECONDAIRE_EN
 * @property string $TEL_SECONDAIRE
 * @property string $COURRIEL
 * @property string $SITE_WEB
 * @property string $SUCCURSALES
 * @property string $ETABLI_DEPUIS
 * @property string $NB_EMPLOYES
 * @property string $PERSONNEL_NOM1
 * @property string $PERSONNEL_TITRE1
 * @property string $PERSONNEL_TITRE1_EN
 * @property string $PERSONNEL_NOM2
 * @property string $PERSONNEL_TITRE2
 * @property string $PERSONNEL_TITRE2_EN
 * @property string $PERSONNEL_NOM3
 * @property string $PERSONNEL_TITRE3
 * @property string $PERSONNEL_TITRE3_EN
 * @property string $DATE_MODIFICATION
 * @property string $REGIONS_FR
 * @property string $REGIONS_EN
 * @property integer $bAfficher_site
 * @property integer $iId_fichier
 *
 * The followings are the available model relations:
 * @property RepertoireFournisseurProduit[] $repertoireFournisseurProduits
 * @property RepertoireFournisseurType $iDTYPEFOURNISSEUR
 * @property ArchiveFichier $iIdFichier
 */
class SuppliersDirectory extends CActiveRecord {

    public $country, $region, $archivecat,$IDSECTION,$Products1,$Products2,$ID_SECTION,$PROD_SERVICE;
    static $NOM_TABLE = 'Fournisseurs';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'repertoire_fournisseurs';
    }
    
    public static function getproducts($sess_product_ids)
    {        
        $lang = Yii::app()->session['language'];
        if($lang=="EN")
        {
            $lstr = "EN";
        }else
        {
            $lstr = "FR";
        }    
        $criteria = new CDbCriteria;
        $criteria->addInCondition("ID_PRODUIT", $sess_product_ids);
        $criteria->order = "NOM_PRODUIT_".$lstr." ASC";
        $data_products = ProductDirectory::model()->with("sectionDirectory")->findAll($criteria);

        return $data_products;
    }        

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_TYPE_FOURNISSEUR,COMPAGNIE, ADRESSE,ID_VILLE,CODE_POSTAL,TELEPHONE,country,region', 'required'),
            array('ID_TYPE_FOURNISSEUR, ID_VILLE, bAfficher_site, iId_fichier,country,region', 'numerical', 'integerOnly' => true),
            array('COMPAGNIE, ADRESSE, ADRESSE2, TITRE_TEL_SANS_FRAIS, TITRE_TEL_SANS_FRAIS_EN, TITRE_TEL_SECONDAIRE, TITRE_TEL_SECONDAIRE_EN, COURRIEL, SITE_WEB, SUCCURSALES, PERSONNEL_NOM1, PERSONNEL_TITRE1, PERSONNEL_TITRE1_EN, PERSONNEL_NOM2, PERSONNEL_TITRE2, PERSONNEL_TITRE2_EN, PERSONNEL_NOM3, PERSONNEL_TITRE3, PERSONNEL_TITRE3_EN', 'length', 'max' => 255),
            array('ID_CLIENT', 'length', 'max' => 8),
            array('CODE_POSTAL, TELEPHONE, TELECOPIEUR, TEL_SANS_FRAIS, TEL_SECONDAIRE, ETABLI_DEPUIS', 'length', 'max' => 20),
            array('NB_EMPLOYES', 'length', 'max' => 10),
            array('REGIONS_FR, REGIONS_EN', 'length', 'max' => 1000),
            array('COURRIEL','email'),
            array('SITE_WEB','url'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('country,region,archivecat,IDSECTION,Products1,Products2,ID_SECTION,PROD_SERVICE', 'safe'),
            array('ID_FOURNISSEUR, COMPAGNIE, ID_CLIENT, ID_TYPE_FOURNISSEUR, ADRESSE, ADRESSE2, ID_VILLE, CODE_POSTAL, TELEPHONE, TELECOPIEUR, TITRE_TEL_SANS_FRAIS, TITRE_TEL_SANS_FRAIS_EN, TEL_SANS_FRAIS, TITRE_TEL_SECONDAIRE, TITRE_TEL_SECONDAIRE_EN, TEL_SECONDAIRE, COURRIEL, SITE_WEB, SUCCURSALES, ETABLI_DEPUIS, NB_EMPLOYES, PERSONNEL_NOM1, PERSONNEL_TITRE1, PERSONNEL_TITRE1_EN, PERSONNEL_NOM2, PERSONNEL_TITRE2, PERSONNEL_TITRE2_EN, PERSONNEL_NOM3, PERSONNEL_TITRE3, PERSONNEL_TITRE3_EN, DATE_MODIFICATION, REGIONS_FR, REGIONS_EN, bAfficher_site, iId_fichier', 'safe', 'on' => 'search'),
            array('TELEPHONE, TELECOPIEUR, TEL_SANS_FRAIS, TEL_SECONDAIRE', 'phoneNumber'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'repertoireFournisseurProduits' => array(self::HAS_MANY, 'RepertoireFournisseurProduit', 'ID_FOURNISSEUR'),
            'supplierType' => array(self::BELONGS_TO, 'SupplierType', 'ID_TYPE_FOURNISSEUR'),
            'archiveFichier' => array(self::BELONGS_TO, 'ArchiveFichier', 'iId_fichier'),
            'userDirectory' => array(self::HAS_MANY, 'UserDirectory', 'ID_RELATION'),
            'paymentTransaction' => array(self::HAS_MANY, 'PaymentTransaction', 'user_id'),
            
        );
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID_FOURNISSEUR' => Myclass::t('Id Fournisseur'),
            'COMPAGNIE' => Myclass::t('OG063','','og'),
            'ID_CLIENT' => Myclass::t('ID'),
            'ID_TYPE_FOURNISSEUR' => Myclass::t('OG102'),
            'ADRESSE' => Myclass::t('APP66'),
            'ADRESSE2' => Myclass::t('APP67'),
            'ID_VILLE' => Myclass::t('APP70'),
            'CODE_POSTAL' => Myclass::t('APP71'),
            'TELEPHONE' => Myclass::t('APP72'),
            'TELECOPIEUR' => Myclass::t('APP73'),
            'TITRE_TEL_SANS_FRAIS' => Myclass::t('Titre Tel Sans Frais'),
            'TITRE_TEL_SANS_FRAIS_EN' => Myclass::t('Titre Tel Sans Frais En'),
            'TEL_SANS_FRAIS' => Myclass::t('OG068','','og'),
            'TITRE_TEL_SECONDAIRE' => Myclass::t('Titre Tel Secondaire'),
            'TITRE_TEL_SECONDAIRE_EN' => Myclass::t('Titre Tel Secondaire En'),
            'TEL_SECONDAIRE' => Myclass::t('OG069','','og'),
            'COURRIEL' => Myclass::t('APP75'),
            'SITE_WEB' => Myclass::t('APP76'),
            'SUCCURSALES' => Myclass::t('OG130'),
            'ETABLI_DEPUIS' => Myclass::t('OG128'),
            'NB_EMPLOYES' => Myclass::t('OG129'),
            'PERSONNEL_NOM1' => Myclass::t('APP2'),
            'PERSONNEL_TITRE1' => Myclass::t('OG132'),
            'PERSONNEL_TITRE1_EN' => Myclass::t('OG133'),
            'PERSONNEL_NOM2' => Myclass::t('APP2'),
            'PERSONNEL_TITRE2' => Myclass::t('OG132'),
            'PERSONNEL_TITRE2_EN' => Myclass::t('OG133'),
            'PERSONNEL_NOM3' => Myclass::t('APP2'),
            'PERSONNEL_TITRE3' => Myclass::t('OG132'),
            'PERSONNEL_TITRE3_EN' => Myclass::t('OG133'),
            'DATE_MODIFICATION' => Myclass::t('Date Modification'),
            'REGIONS_FR' => Myclass::t('En français'),
            'REGIONS_EN' => Myclass::t('En anglais'),
            'bAfficher_site' => Myclass::t('Afficher sur le site'),
            'iId_fichier' => Myclass::t('Fichier'),
            'archivecat'  => Myclass::t('Archive category'),
            'country'     => Myclass::t('APP68'),
            'region'      => Myclass::t('APP48'),
            'IDSECTION'  => Myclass::t('APP84'),
            'Products'   => Myclass::t('Products'),
            'USR'       => Myclass::t('ID'),
           // 'paymenttype' => Myclass::t('OG137'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('ID_FOURNISSEUR', $this->ID_FOURNISSEUR);
        $criteria->compare('COMPAGNIE', $this->COMPAGNIE, true);
        $criteria->compare('ID_CLIENT', $this->ID_CLIENT, true);
        $criteria->compare('t.ID_TYPE_FOURNISSEUR', $this->ID_TYPE_FOURNISSEUR);
        $criteria->compare('ADRESSE', $this->ADRESSE, true);
        $criteria->compare('ADRESSE2', $this->ADRESSE2, true);
        $criteria->compare('ID_VILLE', $this->ID_VILLE);
        $criteria->compare('CODE_POSTAL', $this->CODE_POSTAL, true);
        $criteria->compare('TELEPHONE', $this->TELEPHONE, true);
        $criteria->compare('TELECOPIEUR', $this->TELECOPIEUR, true);
        $criteria->compare('TITRE_TEL_SANS_FRAIS', $this->TITRE_TEL_SANS_FRAIS, true);
        $criteria->compare('TITRE_TEL_SANS_FRAIS_EN', $this->TITRE_TEL_SANS_FRAIS_EN, true);
        $criteria->compare('TEL_SANS_FRAIS', $this->TEL_SANS_FRAIS, true);
        $criteria->compare('TITRE_TEL_SECONDAIRE', $this->TITRE_TEL_SECONDAIRE, true);
        $criteria->compare('TITRE_TEL_SECONDAIRE_EN', $this->TITRE_TEL_SECONDAIRE_EN, true);
        $criteria->compare('TEL_SECONDAIRE', $this->TEL_SECONDAIRE, true);
        $criteria->compare('COURRIEL', $this->COURRIEL, true);
        $criteria->compare('SITE_WEB', $this->SITE_WEB, true);
        $criteria->compare('SUCCURSALES', $this->SUCCURSALES, true);
        $criteria->compare('ETABLI_DEPUIS', $this->ETABLI_DEPUIS, true);
        $criteria->compare('NB_EMPLOYES', $this->NB_EMPLOYES, true);
        $criteria->compare('PERSONNEL_NOM1', $this->PERSONNEL_NOM1, true);
        $criteria->compare('PERSONNEL_TITRE1', $this->PERSONNEL_TITRE1, true);
        $criteria->compare('PERSONNEL_TITRE1_EN', $this->PERSONNEL_TITRE1_EN, true);
        $criteria->compare('PERSONNEL_NOM2', $this->PERSONNEL_NOM2, true);
        $criteria->compare('PERSONNEL_TITRE2', $this->PERSONNEL_TITRE2, true);
        $criteria->compare('PERSONNEL_TITRE2_EN', $this->PERSONNEL_TITRE2_EN, true);
        $criteria->compare('PERSONNEL_NOM3', $this->PERSONNEL_NOM3, true);
        $criteria->compare('PERSONNEL_TITRE3', $this->PERSONNEL_TITRE3, true);
        $criteria->compare('PERSONNEL_TITRE3_EN', $this->PERSONNEL_TITRE3_EN, true);
        $criteria->compare('DATE_MODIFICATION', $this->DATE_MODIFICATION, true);
        $criteria->compare('REGIONS_FR', $this->REGIONS_FR, true);
        $criteria->compare('REGIONS_EN', $this->REGIONS_EN, true);
        $criteria->compare('bAfficher_site', $this->bAfficher_site);
        $criteria->compare('iId_fichier', $this->iId_fichier);
        
        $criteria->with  = 'supplierType';
        $criteria->order = 'supplierType.TYPE_FOURNISSEUR_FR ASC, t.COMPAGNIE ASC';

        return new CActiveDataProvider($this, array(           
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SuppliersDirectory the static model class
     */
    public static function model($className = __CLASS__) {
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
