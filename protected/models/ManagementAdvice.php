<?php

/**
 * This is the model class for table "saviezvous_saviezvous".
 *
 * The followings are the available columns in table 'saviezvous_saviezvous':
 * @property integer $ID_CONSEIL
 * @property string $LANGUE
 * @property string $TITRE
 * @property string $SYNOPSYS
 * @property string $TEXTE
 * @property string $LIEN_URL
 * @property string $LIEN_TITRE
 * @property integer $AFFICHER_SITE
 */
class ManagementAdvice extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'saviezvous_saviezvous';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('TITRE,SYNOPSYS,AFFICHER_SITE', 'required'),
            array('AFFICHER_SITE', 'numerical', 'integerOnly' => true),
            array('LANGUE', 'length', 'max' => 2),
            array('TITRE, LIEN_URL, LIEN_TITRE', 'length', 'max' => 255),
            array('SYNOPSYS', 'length', 'max' => 500),
            array('TEXTE', 'length', 'max' => 5000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID_CONSEIL, LANGUE, TITRE, SYNOPSYS, TEXTE, LIEN_URL, LIEN_TITRE, AFFICHER_SITE', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID_CONSEIL' => Myclass::t('Id Conseil'),
            'LANGUE' => Myclass::t('Langue'),
            'TITRE' => Myclass::t('Titre'),
            'SYNOPSYS' => Myclass::t('Résumé'),
            'TEXTE' => Myclass::t('Texte complet'),
            'LIEN_URL' => Myclass::t('Titre de l\'adresse web'),
            'LIEN_TITRE' => Myclass::t('Adresse web'),
            'AFFICHER_SITE' => Myclass::t('Activer le conseil'),
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

        $criteria->compare('ID_CONSEIL', $this->ID_CONSEIL);
        $criteria->compare('LANGUE', $this->LANGUE, true);
        $criteria->compare('TITRE', $this->TITRE, true);
        $criteria->compare('SYNOPSYS', $this->SYNOPSYS, true);
        $criteria->compare('TEXTE', $this->TEXTE, true);
        $criteria->compare('LIEN_URL', $this->LIEN_URL, true);
        $criteria->compare('LIEN_TITRE', $this->LIEN_TITRE, true);
        $criteria->compare('AFFICHER_SITE', $this->AFFICHER_SITE);

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
     * @return ManagementAdvice the static model class
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

    public function scopes() {
        return array(
            'random' => array(
                'order' => 'rand()',
                'condition' => 'LANGUE = :LN',
                'params' => array(':LN' => Yii::app()->session['language']),
            ),
        );
    }

}
