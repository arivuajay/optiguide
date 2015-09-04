<?php

/**
 * This is the model class for table "calendrier_calendrier".
 *
 * The followings are the available columns in table 'calendrier_calendrier':
 * @property integer $ID_EVENEMENT
 * @property string $LANGUE
 * @property string $DATE_AJOUT1
 * @property string $DATE_AJOUT2
 * @property string $TITRE
 * @property string $TEXTE
 * @property string $LIEN_URL
 * @property string $LIEN_TITRE
 * @property integer $AFFICHER_SITE
 * @property integer $AFFICHER_ACCUEIL
 * @property integer $AFFICHER_ARCHIVE
 * @property integer $ID_PAYS
 * @property integer $ID_REGION
 * @property integer $ID_VILLE
 */
class CalenderEvent extends CActiveRecord {
    
    public $EVENT_MONTH;
    public $EVENT_YEAR;
    public $Year,$Emplacement,$keyword;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'calendrier_calendrier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
          //  array('DATE_AJOUT1, DATE_AJOUT2, TITRE, AFFICHER_ACCUEIL, AFFICHER_ARCHIVE', 'required'),
             array('DATE_AJOUT1, DATE_AJOUT2, TITRE, TEXTE', 'required'),
            array('AFFICHER_SITE, AFFICHER_ACCUEIL, AFFICHER_ARCHIVE, ID_PAYS, ID_REGION, ID_VILLE', 'numerical', 'integerOnly' => true),
            array('LANGUE', 'length', 'max' => 2),
            array('TITRE, LIEN_URL, LIEN_TITRE', 'length', 'max' => 255),
            array('TEXTE', 'length', 'max' => 5000),
            array('EVENT_MONTH, EVENT_YEAR', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Year,Emplacement,keyword', 'safe'),
            array('ID_EVENEMENT, LANGUE, DATE_AJOUT1, DATE_AJOUT2, TITRE, TEXTE, LIEN_URL, LIEN_TITRE, AFFICHER_SITE, AFFICHER_ACCUEIL, AFFICHER_ARCHIVE, ID_PAYS, ID_REGION, ID_VILLE, EVENT_MONTH, EVENT_YEAR', 'safe', 'on' => 'search'),
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
            'ID_EVENEMENT' => Myclass::t('Id Evenement'),
            'LANGUE' => Myclass::t('Langue'),
            'DATE_AJOUT1' => Myclass::t('Date de début'),
            'DATE_AJOUT2' => Myclass::t('Date de fin'),
            'TITRE' => Myclass::t('Titre'),
            'TEXTE' => Myclass::t('Texte'),
            'LIEN_URL' => Myclass::t('Adresse web'),
            'LIEN_TITRE' => Myclass::t('Titre de l\'adresse web'),
            'AFFICHER_SITE' => Myclass::t('Afficher Site'),
            'AFFICHER_ACCUEIL' => Myclass::t('Afficher Accueil'),
            'AFFICHER_ARCHIVE' => Myclass::t('Afficher Archive'),
            'ID_PAYS' => Myclass::t('Id Pays'),
            'ID_REGION' => Myclass::t('Id Region'),
            'ID_VILLE' => Myclass::t('Id Ville'),
            'Year'      => Myclass::t('Année'),
            'Keyword'   =>  Myclass::t('Mot clé')
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
        
      // search year and keyword 
      // echo $this->Year;
      // echo $this->keyword;  

        $criteria->compare('ID_EVENEMENT', $this->ID_EVENEMENT);
        $criteria->compare('LANGUE', $this->LANGUE, true);
        $criteria->compare('DATE_AJOUT1',$this->Year, true);
        $criteria->compare('DATE_AJOUT2', $this->DATE_AJOUT2, true);
        $criteria->compare('TITRE', $this->keyword, true);
        $criteria->compare('TEXTE', $this->TEXTE, true);
        $criteria->compare('LIEN_URL', $this->LIEN_URL, true);
        $criteria->compare('LIEN_TITRE', $this->LIEN_TITRE, true);
        $criteria->compare('AFFICHER_SITE', $this->AFFICHER_SITE);
        $criteria->compare('AFFICHER_ACCUEIL', $this->AFFICHER_ACCUEIL);
        $criteria->compare('AFFICHER_ARCHIVE', $this->AFFICHER_ARCHIVE);
        $criteria->compare('ID_PAYS', $this->ID_PAYS);
        $criteria->compare('ID_REGION', $this->ID_REGION);
        $criteria->compare('ID_VILLE', $this->ID_VILLE);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
             'defaultOrder'=>'DATE_AJOUT1 DESC',
             ),
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CalenderEvent the static model class
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
        $current_month = date("m", strtotime($current_date));
        $current_year = date("Y", strtotime($current_date));
        return array(
            'currentMonthYear' => array(
               // 'condition' => 'LANGUE = :LN AND MONTH(DATE_AJOUT1) = :MN AND YEAR(DATE_AJOUT1) = :YR',
               // 'params' => array(':LN' => Yii::app()->session['language'], ':MN' => $current_month, ':YR' => $current_year),
                'condition' => 'LANGUE = :LN',
                'params' => array(':LN' => Yii::app()->session['language']),
            ),
        );
    }

}
