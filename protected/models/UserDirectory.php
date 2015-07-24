<?php

/**
 * This is the model class for table "repertoire_utilisateurs".
 *
 * The followings are the available columns in table 'repertoire_utilisateurs':
 * @property integer $ID_UTILISATEUR
 * @property string $LANGUE
 * @property string $PREFIXE
 * @property string $NOM_UTILISATEUR
 * @property string $USR
 * @property string $PWD
 * @property string $COURRIEL
 * @property integer $ABONNE_MAILING
 * @property integer $ABONNE_PROMOTION
 * @property integer $ABONNE_TRANSITION
 * @property integer $IS_FIRST_LOG
 * @property string $NOM_TABLE
 * @property integer $ID_RELATION
 * @property integer $MUST_VALIDATE
 * @property string $sGuid
 * @property integer $bSubscription_envision
 * @property integer $bSubscription_envue
 */
class UserDirectory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'repertoire_utilisateurs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
            return array(
                    array('LANGUE,NOM_UTILISATEUR,USR, PWD', 'required'),
                    array('USR', 'unique', 'message'=>'This Nom d\'usager is already in use'),                  
                    array('ABONNE_MAILING, ABONNE_PROMOTION, ABONNE_TRANSITION, IS_FIRST_LOG, ID_RELATION, MUST_VALIDATE, bSubscription_envision, bSubscription_envue', 'numerical', 'integerOnly'=>true),
                    array('PREFIXE, NOM_TABLE', 'length', 'max'=>50),
                    array('USR', 'length', 'max'=>8),
                    array('NOM_UTILISATEUR, USR, PWD, COURRIEL, sGuid', 'length', 'max'=>255),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                   // array('USR', 'safe', 'readOnly'=>true , 'on'=>'update'),
                    array('ID_UTILISATEUR, LANGUE, PREFIXE, NOM_UTILISATEUR, USR, PWD, COURRIEL, ABONNE_MAILING, ABONNE_PROMOTION, ABONNE_TRANSITION, IS_FIRST_LOG, NOM_TABLE, ID_RELATION, MUST_VALIDATE, sGuid, bSubscription_envision, bSubscription_envue', 'safe', 'on'=>'search'),
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
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_UTILISATEUR' => Myclass::t('Id Utilisateur'),
			'LANGUE' => Myclass::t('Langue'),
			'PREFIXE' => Myclass::t('Préfixe'),
			'NOM_UTILISATEUR' => Myclass::t('Nom du destinataire '),
			'USR' => Myclass::t('Nom dusager'),
			'PWD' => Myclass::t('Mot de passe'),
			'COURRIEL' => Myclass::t('Courriel'),
			'ABONNE_MAILING' => Myclass::t('Abonné à la liste de diffusion '),
			'ABONNE_PROMOTION' => Myclass::t('Abonné aux OPTI-PROMOS '),
			'ABONNE_TRANSITION' => Myclass::t('Abonné à Transitions'),
                        'bSubscription_envision' => Myclass::t('Abonné à Envision'),
			'bSubscription_envue' => Myclass::t('Abonné à Envue'),
                        'MUST_VALIDATE' => Myclass::t('Confirmation'),
                    
			'IS_FIRST_LOG' => Myclass::t('Is First Log'),
			'NOM_TABLE' => Myclass::t('Nom Table'),
			'ID_RELATION' => Myclass::t('Id Relation'),
			'sGuid' => Myclass::t('S Guid'),
			
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

		$criteria->compare('ID_UTILISATEUR',$this->ID_UTILISATEUR);
		$criteria->compare('LANGUE',$this->LANGUE,true);
		$criteria->compare('PREFIXE',$this->PREFIXE,true);
		$criteria->compare('NOM_UTILISATEUR',$this->NOM_UTILISATEUR,true);
		$criteria->compare('USR',$this->USR,true);
		$criteria->compare('PWD',$this->PWD,true);
		$criteria->compare('COURRIEL',$this->COURRIEL,true);
		$criteria->compare('ABONNE_MAILING',$this->ABONNE_MAILING);
		$criteria->compare('ABONNE_PROMOTION',$this->ABONNE_PROMOTION);
		$criteria->compare('ABONNE_TRANSITION',$this->ABONNE_TRANSITION);
		$criteria->compare('IS_FIRST_LOG',$this->IS_FIRST_LOG);
		$criteria->compare('NOM_TABLE',$this->NOM_TABLE,true);
		$criteria->compare('ID_RELATION',$this->ID_RELATION);
		$criteria->compare('MUST_VALIDATE',$this->MUST_VALIDATE);
		$criteria->compare('sGuid',$this->sGuid,true);
		$criteria->compare('bSubscription_envision',$this->bSubscription_envision);
		$criteria->compare('bSubscription_envue',$this->bSubscription_envue);

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
	 * @return UserDirectory the static model class
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
