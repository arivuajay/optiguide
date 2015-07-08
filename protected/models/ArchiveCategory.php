<?php

/**
 * This is the model class for table "archive_categorie".
 *
 * The followings are the available columns in table 'archive_categorie':
 * @property integer $ID_CATEGORIE
 * @property string $NOM_CATEGORIE_FR
 * @property string $NOM_CATEGORIE_EN
 *
 * The followings are the available model relations:
 * @property ArchiveFichier[] $archiveFichiers
 */
class ArchiveCategory extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'archive_categorie';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('NOM_CATEGORIE_FR, NOM_CATEGORIE_EN', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID_CATEGORIE, NOM_CATEGORIE_FR, NOM_CATEGORIE_EN', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'archiveFichiers' => array(self::HAS_MANY, 'ArchiveFichier', 'ID_CATEGORIE'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID_CATEGORIE' => Myclass::t('Category ID'),
            'NOM_CATEGORIE_FR' => Myclass::t('Category Name Fr'),
            'NOM_CATEGORIE_EN' => Myclass::t('Category Name En'),
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

        $criteria->compare('ID_CATEGORIE', $this->ID_CATEGORIE);
        $criteria->compare('NOM_CATEGORIE_FR', $this->NOM_CATEGORIE_FR, true);
        $criteria->compare('NOM_CATEGORIE_EN', $this->NOM_CATEGORIE_EN, true);

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
     * @return ArchiveCategory the static model class
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
