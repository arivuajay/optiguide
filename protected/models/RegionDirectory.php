<?php

/**
 * This is the model class for table "repertoire_region".
 *
 * The followings are the available columns in table 'repertoire_region':
 * @property integer $ID_REGION
 * @property integer $ID_PAYS
 * @property string $NOM_REGION_FR
 * @property string $NOM_REGION_EN
 * @property string $ABREVIATION_FR
 * @property string $ABREVIATION_EN
 *
 * The followings are the available model relations:
 * @property LienMailingRegion[] $lienMailingRegions
 * @property PubliciteLienRegion[] $publiciteLienRegions
 * @property RepertoirePays $iDPAYS
 * @property RepertoireVille[] $repertoireVilles
 */
class RegionDirectory extends CActiveRecord {

    public $fullname;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'repertoire_region';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID_PAYS, NOM_REGION_FR, NOM_REGION_EN, ABREVIATION_FR, ABREVIATION_EN', 'required'),
            array('ID_PAYS', 'numerical', 'integerOnly' => true),
            array('NOM_REGION_FR, NOM_REGION_EN', 'length', 'max' => 255),
            array('ABREVIATION_FR, ABREVIATION_EN', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('NOM_PAYS_FR,federal_rates,provincial_rates,taxt_type', 'safe'),
            array('ID_REGION, ID_PAYS, NOM_REGION_FR, NOM_REGION_EN, ABREVIATION_FR, ABREVIATION_EN, fullname', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                $criteria = array(
                    'condition' => 'ID_PAYS=:country_id AND NOM_REGION_EN=:region_name_en',
                    'params' => array(
                        ':country_id' => $this->ID_PAYS,
                        ':region_name_en' => $this->NOM_REGION_EN
                    )
                );
            } else {
                $criteria = array(
                    'condition' => 'ID_REGION<>:region_id AND ID_PAYS=:country_id AND NOM_REGION_EN=:region_name_en',
                    'params' => array(
                        ':region_id' => $this->ID_REGION,
                        ':country_id' => $this->ID_PAYS,
                        ':region_name_en' => $this->NOM_REGION_EN
                    )
                );
            }

            $validator = CValidator::createValidator('unique', $this, 'NOM_REGION_FR', array(
                        'criteria' => $criteria
            ));
            $this->getValidatorList()->insertAt(0, $validator);
            return true;
        }
        return false;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lienMailingRegions' => array(self::HAS_MANY, 'LienMailingRegion', 'id_region'),
            'publiciteLienRegions' => array(self::HAS_MANY, 'PubliciteLienRegion', 'ID_REGION'),
            'countryDirectory' => array(self::BELONGS_TO, 'CountryDirectory', 'ID_PAYS'),
            'cityDirectory' => array(self::HAS_MANY, 'CityDirectory', 'ID_REGION'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID_REGION' => Myclass::t('APP101'),
            'ID_PAYS' => Myclass::t('APP68'),
            'NOM_REGION_FR' => Myclass::t('APP102'),
            'NOM_REGION_EN' => Myclass::t('APP103'),
            'ABREVIATION_FR' => Myclass::t('APP104'),
            'ABREVIATION_EN' => Myclass::t('APP105'),
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

        $criteria->compare('ID_REGION', $this->ID_REGION);
        $criteria->compare('ID_PAYS', $this->ID_PAYS);
        $criteria->compare('NOM_REGION_FR', $this->NOM_REGION_FR, true);
        $criteria->compare('NOM_REGION_EN', $this->NOM_REGION_EN, true);
        $criteria->compare('ABREVIATION_FR', $this->ABREVIATION_FR, true);
        $criteria->compare('ABREVIATION_EN', $this->ABREVIATION_EN, true);

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
     * @return RegionDirectory the static model class
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

}
