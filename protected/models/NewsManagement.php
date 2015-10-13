<?php

/**
 * This is the model class for table "nouvelle_nouvelle".
 *
 * The followings are the available columns in table 'nouvelle_nouvelle':
 * @property integer $ID_NOUVELLE
 * @property string $LANGUE
 * @property string $TITRE
 * @property string $SYNOPSYS
 * @property string $TEXTE
 * @property integer $ID_FICHIER
 * @property string $LIEN_URL
 * @property string $LIEN_TITRE
 * @property integer $HIERARCHIE
 * @property string $DATE_AJOUT1
 * @property integer $AFFICHER_SITE
 * @property integer $AFFICHER_SECTION
 * @property integer $AFFICHER_ACCUEIL
 * @property string $DATE_AJOUT2
 *
 * The followings are the available model relations:
 * @property LienMailingRecipientNews[] $lienMailingRecipientNews
 * @property ArchiveFichier $iDFICHIER
 */
class NewsManagement extends CActiveRecord {

    public $archivecat;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nouvelle_nouvelle';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('TITRE, SYNOPSYS, TEXTE', 'required'),
            array('ID_FICHIER, HIERARCHIE, AFFICHER_SITE, AFFICHER_SECTION, AFFICHER_ACCUEIL', 'numerical', 'integerOnly' => true),
            array('LANGUE', 'length', 'max' => 2),
            array('TITRE, LIEN_URL, LIEN_TITRE', 'length', 'max' => 255),
            array('SYNOPSYS', 'length', 'max' => 500),
            array('TEXTE', 'length', 'max' => 5000),
            array('DATE_AJOUT2,archivecat', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID_NOUVELLE, LANGUE, TITRE, SYNOPSYS, TEXTE, ID_FICHIER, LIEN_URL, LIEN_TITRE, HIERARCHIE, DATE_AJOUT1, AFFICHER_SITE, AFFICHER_SECTION, AFFICHER_ACCUEIL, DATE_AJOUT2', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lienMailingRecipientNews' => array(self::HAS_MANY, 'LienMailingRecipientNews', 'iId_news'),
            'iDFICHIER' => array(self::BELONGS_TO, 'ArchiveFichier', 'ID_FICHIER'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID_NOUVELLE' => Myclass::t('Id Nouvelle'),
            'LANGUE' => Myclass::t('Langue'),
            'TITRE' => Myclass::t('Titre'),
            'SYNOPSYS' => Myclass::t('Résumé'),
            'TEXTE' => Myclass::t('Texte complet'),
            'ID_FICHIER' => Myclass::t('Image reliée Fichier'),
            'LIEN_URL' => Myclass::t('Adresse web'),
            'LIEN_TITRE' => Myclass::t('Titre de l\'adresse web'),
            'HIERARCHIE' => Myclass::t('Hierarchie'),
            'DATE_AJOUT1' => Myclass::t('Début de l\'affichage'),
            'AFFICHER_SITE' => Myclass::t('Activer la nouvelle'),
            'AFFICHER_SECTION' => Myclass::t('Afficher où'),
            'AFFICHER_ACCUEIL' => Myclass::t('Afficher en accueil'),
            'DATE_AJOUT2' => Myclass::t('Fin de l\'affichage'),
            'archivecat' => Myclass::t('Image reliée Catégorie '),
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

        $criteria->compare('ID_NOUVELLE', $this->ID_NOUVELLE);
        $criteria->compare('LANGUE', $this->LANGUE, true);
        $criteria->compare('TITRE', $this->TITRE, true);
        $criteria->compare('SYNOPSYS', $this->SYNOPSYS, true);
        $criteria->compare('TEXTE', $this->TEXTE, true);
        $criteria->compare('ID_FICHIER', $this->ID_FICHIER);
        $criteria->compare('LIEN_URL', $this->LIEN_URL, true);
        $criteria->compare('LIEN_TITRE', $this->LIEN_TITRE, true);
        $criteria->compare('HIERARCHIE', $this->HIERARCHIE);
        $criteria->compare('DATE_AJOUT1', $this->DATE_AJOUT1, true);
        $criteria->compare('AFFICHER_SITE', $this->AFFICHER_SITE);
        $criteria->compare('AFFICHER_SECTION', $this->AFFICHER_SECTION);
        $criteria->compare('AFFICHER_ACCUEIL', $this->AFFICHER_ACCUEIL);
        $criteria->compare('DATE_AJOUT2', $this->DATE_AJOUT2, true);

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
     * @return NewsManagement the static model class
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
        $current_date = date("Y-m-d");
        return array(
            'latest' => array(
                'order' => 'DATE_AJOUT1 DESC, TITRE ASC',
                'limit' => 3,
                'condition' => 'DATE_AJOUT1 <= "' . $current_date . '" AND DATE_AJOUT2 >= "' . $current_date . '" AND LANGUE = :LN',
                'params' => array(':LN' => Yii::app()->session['language']),
            ),
             'latest_rep' => array(
                'order' => 'DATE_AJOUT1 DESC, TITRE ASC',
                'limit' => 5,
                'condition' => 'DATE_AJOUT1 <= "' . $current_date . '" AND DATE_AJOUT2 >= "' . $current_date . '" AND LANGUE = :LN',
                'params' => array(':LN' => Yii::app()->session['language']),
            ),
        );
        
    }

}
