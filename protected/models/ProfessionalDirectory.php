<?php

/**
 * This is the model class for table "repertoire_specialiste".
 *
 * The followings are the available columns in table 'repertoire_specialiste':
 * @property integer $ID_SPECIALISTE
 * @property string $ID_CLIENT
 * @property string $PREFIXE_FR
 * @property string $PREFIXE_EN
 * @property string $PRENOM
 * @property string $NOM
 * @property integer $ID_TYPE_SPECIALISTE
 * @property string $TYPE_AUTRE
 * @property string $BUREAU
 * @property string $ADRESSE
 * @property string $ADRESSE2
 * @property integer $ID_VILLE
 * @property string $CODE_POSTAL
 * @property string $TELEPHONE
 * @property string $TELEPHONE2
 * @property string $TELECOPIEUR
 * @property string $TELECOPIEUR2
 * @property string $SITE_WEB
 * @property string $COURRIEL
 * @property string $DATE_MODIFICATION
 */
class ProfessionalDirectory extends CActiveRecord {

    public $country;
    public $TYPESPECIALISTEFR;
    public $region;
    static $NOM_TABLE = 'Professionnels';
    

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'repertoire_specialiste';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_TYPE_SPECIALISTE, PRENOM, ID_CLIENT, NOM ,country, region, ID_VILLE', 'required'),
            array('ID_TYPE_SPECIALISTE, country, region, ID_VILLE', 'numerical', 'integerOnly' => true),
            array('ID_CLIENT', 'length', 'max' => 8),
            array('PREFIXE_FR, PREFIXE_EN, PRENOM, NOM, TYPE_AUTRE, BUREAU, ADRESSE, ADRESSE2, SITE_WEB, COURRIEL', 'length', 'max' => 255),
            array('CODE_POSTAL, TELEPHONE, TELEPHONE2, TELECOPIEUR, TELECOPIEUR2', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('country,region', 'safe'),
            array('ID_SPECIALISTE, TYPESPECIALISTEFR , ID_CLIENT, PREFIXE_FR, PREFIXE_EN, PRENOM, NOM, ID_TYPE_SPECIALISTE, TYPE_AUTRE, BUREAU, ADRESSE, ADRESSE2, ID_VILLE, CODE_POSTAL, TELEPHONE, TELEPHONE2, TELECOPIEUR, TELECOPIEUR2, SITE_WEB, COURRIEL, DATE_MODIFICATION', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'professionalType' => array(self::BELONGS_TO, 'ProfessionalType', 'ID_TYPE_SPECIALISTE'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID_SPECIALISTE' => Myclass::t('Id Specialiste'),
            'ID_TYPE_SPECIALISTE' => Myclass::t('Type de professionnel'),
            'ID_CLIENT' => Myclass::t('ID'),
            'PREFIXE_FR' => Myclass::t('Préfixe en français'),
            'PREFIXE_EN' => Myclass::t('Préfixe en anglais'),
            'PRENOM' => Myclass::t('Prénom'),
            'NOM' => Myclass::t('Nom'),
            'BUREAU' => Myclass::t('Bureau '),
            'ID_VILLE' => Myclass::t('Ville'),
            'ADRESSE' => Myclass::t('Adresse'),
            'ADRESSE2' => Myclass::t('Adresse (suite)'),
            'CODE_POSTAL' => Myclass::t('Code Postal'),
            'TELEPHONE' => Myclass::t('Téléphone #1'),
            'TELEPHONE2' => Myclass::t('Téléphone #2'),
            'TELECOPIEUR' => Myclass::t('Télécopieur #1'),
            'TELECOPIEUR2' => Myclass::t('Telecopieur2'),
            'SITE_WEB' => Myclass::t('Site Web'),
            'COURRIEL' => Myclass::t('Courriel'),
            'DATE_MODIFICATION' => Myclass::t('Date Modification'),
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
        
        
        $criteria->compare('ID_SPECIALISTE', $this->ID_SPECIALISTE);
        $criteria->compare('ID_CLIENT', $this->ID_CLIENT, true);
        $criteria->compare('PREFIXE_FR', $this->PREFIXE_FR, true);
        $criteria->compare('PREFIXE_EN', $this->PREFIXE_EN, true);
        $criteria->compare('PRENOM', $this->PRENOM, true);
        $criteria->compare('NOM', $this->NOM, true);
        $criteria->compare('ID_TYPE_SPECIALISTE', $this->ID_TYPE_SPECIALISTE, true);
        $criteria->compare('TYPE_AUTRE', $this->TYPE_AUTRE, true);
        $criteria->compare('BUREAU', $this->BUREAU, true);
        $criteria->compare('ADRESSE', $this->ADRESSE, true);
        $criteria->compare('ADRESSE2', $this->ADRESSE2, true);
        $criteria->compare('ID_VILLE', $this->ID_VILLE);
        $criteria->compare('CODE_POSTAL', $this->CODE_POSTAL, true);
        $criteria->compare('TELEPHONE', $this->TELEPHONE, true);
        $criteria->compare('TELEPHONE2', $this->TELEPHONE2, true);
        $criteria->compare('TELECOPIEUR', $this->TELECOPIEUR, true);
        $criteria->compare('TELECOPIEUR2', $this->TELECOPIEUR2, true);
        $criteria->compare('SITE_WEB', $this->SITE_WEB, true);
        $criteria->compare('COURRIEL', $this->COURRIEL, true);
        $criteria->compare('DATE_MODIFICATION', $this->DATE_MODIFICATION, true);
     

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
     * @return ProfessionalDirectory the static model class
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
