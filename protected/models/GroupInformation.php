<?php

/**
 * This is the model class for table "repertoire_renseignements_groupes".
 *
 * The followings are the available columns in table 'repertoire_renseignements_groupes':
 * @property integer $ID_GROUPE
 * @property integer $ID_SECTION
 * @property string $NOM_GROUPE
 * @property string $ADRESSE
 * @property string $ADRESSE2
 * @property integer $ID_VILLE
 * @property string $CODE_POSTAL
 * @property string $TELEPHONE
 * @property string $TELECOPIEUR
 * @property string $COURRIEL
 * @property string $SITE_WEB
 * @property string $PREFIXE_REPRESENTANT_FR
 * @property string $PREFIXE_REPRESENTANT_EN
 * @property string $NOM_REPRESENTANT
 * @property string $TITRE_REPRESENTANT_FR
 * @property string $TITRE_REPRESENTANT_EN
 *
 * The followings are the available model relations:
 * @property RepertoireRenseignementsSection $iDSECTION
 */
class GroupInformation extends CActiveRecord {

    public $country;
    public $region;
    public $category;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'repertoire_renseignements_groupes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_SECTION, NOM_GROUPE, ADRESSE, country,region, ID_VILLE', 'required'),
            array('ID_SECTION, country,region,ID_VILLE', 'numerical', 'integerOnly' => true),
            array('NOM_GROUPE, ADRESSE, ADRESSE2, COURRIEL, SITE_WEB, PREFIXE_REPRESENTANT_FR, PREFIXE_REPRESENTANT_EN, NOM_REPRESENTANT, TITRE_REPRESENTANT_FR, TITRE_REPRESENTANT_EN', 'length', 'max' => 255),
            array('CODE_POSTAL, TELEPHONE, TELECOPIEUR', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('country, region, category', 'safe'),
            array('COURRIEL', 'email'),
            array('ID_GROUPE, ID_SECTION, NOM_GROUPE, ADRESSE, ADRESSE2, ID_VILLE, CODE_POSTAL, TELEPHONE, TELECOPIEUR, COURRIEL, SITE_WEB, PREFIXE_REPRESENTANT_FR, PREFIXE_REPRESENTANT_EN, NOM_REPRESENTANT, TITRE_REPRESENTANT_FR, TITRE_REPRESENTANT_EN', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sectionInformation' => array(self::BELONGS_TO, 'SectionInformation', 'ID_SECTION'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID_GROUPE' => Myclass::t('APP56'),
            'ID_SECTION' => Myclass::t('APP84'),
            'NOM_GROUPE' => Myclass::t('APP55'),
            'ADRESSE' => Myclass::t('APP66'),
            'ADRESSE2' => Myclass::t('APP67'),
            'country' => Myclass::t('APP68'),
            'region' => Myclass::t('APP48'),
            'ID_VILLE' => Myclass::t('APP70'),
            'CODE_POSTAL' => Myclass::t('APP71'),
            'TELEPHONE' => Myclass::t('APP72'),
            'TELECOPIEUR' => Myclass::t('APP73'),
            'COURRIEL' => Myclass::t('APP75'),
            'SITE_WEB' => Myclass::t('APP76'),
            'PREFIXE_REPRESENTANT_FR' => Myclass::t('APP77'),
            'PREFIXE_REPRESENTANT_EN' => Myclass::t('APP78'),
            'NOM_REPRESENTANT' => Myclass::t('APP79'),
            'TITRE_REPRESENTANT_FR' => Myclass::t('APP80'),
            'TITRE_REPRESENTANT_EN' => Myclass::t('APP81'),
        );
    }

    public static function getallsections() {
        $criteria_reg = new CDbCriteria;
        $criteria_reg->order = 'SECTION_FR ASC';
        $get_sectnsql = SectionInformation::model()->findAll($criteria_reg);
        $sections = CHtml::listData($get_sectnsql, 'ID_SECTION', 'SECTION_FR');
        return $sections;
    }

    public function getsectionname() {
        $secid = Yii::app()->getRequest()->getQuery('id');
        $secname = '';

        $criteria = new CDbCriteria;
        $criteria->addCondition('ID_SECTION = :secid');
        $criteria->params = array(':secid' => (int) $secid);
        if ($secid != '') {
            $secinfos = SectionInformation::model()->find($criteria);
            $secname = $secinfos->SECTION_FR;
        }
        return $secname;
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

        $criteria->compare('ID_GROUPE', $this->ID_GROUPE);
        /* get the search params */
        $secid = Yii::app()->getRequest()->getQuery('id');

        if ($secid != '') {
            $criteria->compare('ID_SECTION', $secid);
        } else {
            $criteria->compare('ID_SECTION', $this->ID_SECTION);
        }
        $criteria->compare('NOM_GROUPE', $this->NOM_GROUPE, true);
        $criteria->compare('ADRESSE', $this->ADRESSE, true);
        $criteria->compare('ADRESSE2', $this->ADRESSE2, true);
        $criteria->compare('ID_VILLE', $this->ID_VILLE);
        $criteria->compare('CODE_POSTAL', $this->CODE_POSTAL, true);
        $criteria->compare('TELEPHONE', $this->TELEPHONE, true);
        $criteria->compare('TELECOPIEUR', $this->TELECOPIEUR, true);
        $criteria->compare('COURRIEL', $this->COURRIEL, true);
        $criteria->compare('SITE_WEB', $this->SITE_WEB, true);
        $criteria->compare('PREFIXE_REPRESENTANT_FR', $this->PREFIXE_REPRESENTANT_FR, true);
        $criteria->compare('PREFIXE_REPRESENTANT_EN', $this->PREFIXE_REPRESENTANT_EN, true);
        $criteria->compare('NOM_REPRESENTANT', $this->NOM_REPRESENTANT, true);
        $criteria->compare('TITRE_REPRESENTANT_FR', $this->TITRE_REPRESENTANT_FR, true);
        $criteria->compare('TITRE_REPRESENTANT_EN', $this->TITRE_REPRESENTANT_EN, true);

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
     * @return GroupInformation the static model class
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
