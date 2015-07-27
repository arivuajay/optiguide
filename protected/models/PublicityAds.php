<?php

/**
 * This is the model class for table "publicite_publicite".
 *
 * The followings are the available columns in table 'publicite_publicite':
 * @property integer $ID_PUBLICITE
 * @property integer $NO_PUB
 * @property string $LANGUE
 * @property string $TITRE
 * @property string $DATE_DEBUT
 * @property string $DATE_FIN
 * @property integer $ID_FICHIER
 * @property string $LIEN_URL
 * @property string $MOTS_CLES_RECHERCHE
 * @property integer $NB_IMPRESSIONS_FAITES
 * @property integer $NB_IMPRESSIONS
 * @property integer $PRIORITE
 * @property string $PRIX
 * @property integer $PAYE
 * @property string $CLIENT
 * @property integer $ZONE_AFFICHAGE
 * @property integer $ID_POSITION
 * @property integer $AFFICHER_ACCUEIL
 * @property string $DATE_AJOUT
 * @property integer $ACCUEIL_SECTION
 *
 * The followings are the available model relations:
 * @property PubliciteLienCategorie[] $publiciteLienCategories
 * @property PubliciteLienModule[] $publiciteLienModules
 * @property PubliciteLienRegion[] $publiciteLienRegions
 * @property ArchiveFichier $iDFICHIER
 * @property PubliciteZones $zONEAFFICHAGE
 */
class PublicityAds extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'publicite_publicite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DATE_DEBUT, DATE_FIN', 'required'),
			array('NO_PUB, ID_FICHIER, NB_IMPRESSIONS_FAITES, NB_IMPRESSIONS, PRIORITE, PAYE, ZONE_AFFICHAGE, ID_POSITION, AFFICHER_ACCUEIL, ACCUEIL_SECTION', 'numerical', 'integerOnly'=>true),
			array('LANGUE', 'length', 'max'=>2),
			array('TITRE, LIEN_URL, MOTS_CLES_RECHERCHE, CLIENT', 'length', 'max'=>255),
			array('PRIX', 'length', 'max'=>50),
			array('DATE_AJOUT', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_PUBLICITE, NO_PUB, LANGUE, TITRE, DATE_DEBUT, DATE_FIN, ID_FICHIER, LIEN_URL, MOTS_CLES_RECHERCHE, NB_IMPRESSIONS_FAITES, NB_IMPRESSIONS, PRIORITE, PRIX, PAYE, CLIENT, ZONE_AFFICHAGE, ID_POSITION, AFFICHER_ACCUEIL, DATE_AJOUT, ACCUEIL_SECTION', 'safe', 'on'=>'search'),
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
			'publiciteLienCategories' => array(self::HAS_MANY, 'PubliciteLienCategorie', 'ID_PUBLICITE'),
			'publiciteLienModules' => array(self::HAS_MANY, 'PubliciteLienModule', 'ID_PUBLICITE'),
			'publiciteLienRegions' => array(self::HAS_MANY, 'PubliciteLienRegion', 'ID_PUBLICITE'),
			'iDFICHIER' => array(self::BELONGS_TO, 'ArchiveFichier', 'ID_FICHIER'),
			'zONEAFFICHAGE' => array(self::BELONGS_TO, 'PubliciteZones', 'ZONE_AFFICHAGE'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_PUBLICITE' => Myclass::t('Id Publicite'),
			'NO_PUB' => Myclass::t('No. de publicité '),
			'LANGUE' => Myclass::t('Langue'),
			'TITRE' => Myclass::t('Titre'),
			'DATE_DEBUT' => Myclass::t('du'),
			'DATE_FIN' => Myclass::t('au'),
			'ID_FICHIER' => Myclass::t('Id Fichier'),
			'LIEN_URL' => Myclass::t('Lien Url'),
			'MOTS_CLES_RECHERCHE' => Myclass::t('Mots Cles Recherche'),
			'NB_IMPRESSIONS_FAITES' => Myclass::t('Nb Impressions Faites'),
			'NB_IMPRESSIONS' => Myclass::t('Nb Impressions'),
			'PRIORITE' => Myclass::t('Priorite'),
			'PRIX' => Myclass::t('Prix'),
			'PAYE' => Myclass::t('Est-ce payé ?'),
			'CLIENT' => Myclass::t('Client'),
			'ZONE_AFFICHAGE' => Myclass::t('Zone Affichage'),
			'ID_POSITION' => Myclass::t('Id Position'),
			'AFFICHER_ACCUEIL' => Myclass::t('Afficher Accueil'),
			'DATE_AJOUT' => Myclass::t('Date Ajout'),
			'ACCUEIL_SECTION' => Myclass::t('Accueil Section'),
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

		$criteria->compare('ID_PUBLICITE',$this->ID_PUBLICITE);
		$criteria->compare('NO_PUB',$this->NO_PUB);
		$criteria->compare('LANGUE',$this->LANGUE,true);
		$criteria->compare('TITRE',$this->TITRE,true);
		$criteria->compare('DATE_DEBUT',$this->DATE_DEBUT,true);
		$criteria->compare('DATE_FIN',$this->DATE_FIN,true);
		$criteria->compare('ID_FICHIER',$this->ID_FICHIER);
		$criteria->compare('LIEN_URL',$this->LIEN_URL,true);
		$criteria->compare('MOTS_CLES_RECHERCHE',$this->MOTS_CLES_RECHERCHE,true);
		$criteria->compare('NB_IMPRESSIONS_FAITES',$this->NB_IMPRESSIONS_FAITES);
		$criteria->compare('NB_IMPRESSIONS',$this->NB_IMPRESSIONS);
		$criteria->compare('PRIORITE',$this->PRIORITE);
		$criteria->compare('PRIX',$this->PRIX,true);
		$criteria->compare('PAYE',$this->PAYE);
		$criteria->compare('CLIENT',$this->CLIENT,true);
		$criteria->compare('ZONE_AFFICHAGE',$this->ZONE_AFFICHAGE);
		$criteria->compare('ID_POSITION',$this->ID_POSITION);
		$criteria->compare('AFFICHER_ACCUEIL',$this->AFFICHER_ACCUEIL);
		$criteria->compare('DATE_AJOUT',$this->DATE_AJOUT,true);
		$criteria->compare('ACCUEIL_SECTION',$this->ACCUEIL_SECTION);

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
	 * @return PublicityAds the static model class
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
