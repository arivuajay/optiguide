<?php

/**
 * This is the model class for table "export_datas".
 *
 * The followings are the available columns in table 'export_datas':
 * @property integer $id
 * @property string $attachment_file
 * @property string $user_type
 * @property string $created
 */
class ExportDatas extends CActiveRecord
{
        
        public $P_type,$R_type,$S_type,$language,$EN,$FR,$subscriptions,$Optipromo,$Optinews,$Envision_print,$Envision_digital,$Envue_print,$Envue_digital,$province,$ptype,$export_type;
        public $country,$region,$cat_type_id,$category,$ID_GROUPE,$psection,$S_section,$Etype;
        public $CATEGORY_1,$CATEGORY_2,$CATEGORY_3,$CATEGORY_4,$CATEGORY_5,$status;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'export_datas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(			
			array('attachment_file', 'length', 'max'=>255),
			array('user_type', 'length', 'max'=>55),
                        array('Optipromo , Optinews , Envision_print ,Envision_digital,Envue_print,Envue_digital,province,ptype,cat_type_id,category,ID_GROUPE' , 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, attachment_file, user_type, created, language, EN, FR,subscriptions,export_type,Etype', 'safe', 'on'=>'search'),
                        array('Etype,psection','safe'),
                        array('export_type', 'checknotempty'),
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
        
        public function checknotempty($attribute_name, $params) 
        {
            if ($this->export_type == 2 && $this->country == '') 
            {
                $this->addError('province', "S'il vous plaît choisir une province.");
                return false;
            }
          
            if($this->Etype=="supplier" && $this->export_type == 3)
            {                
                if ($this->psection == '' && $this->ptype == '') 
                {
                    $this->addError('psection', "S'il vous plaît choisir un type ou de la section .");
                    return false;
                }
                
            }elseif ($this->export_type == 3 && $this->ptype == '') 
            {
                $this->addError('ptype', "S'il vous plaît choisir un type");
                return false;
            }
           
            return true;
        }        
    

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'id' => Myclass::t('ID'),
                    'attachment_file' => Myclass::t('Fichier exporté'),
                    'user_type' => Myclass::t('Type d\'utilisateur'),
                    'created' => Myclass::t('date de création'),
                    'EN' => 'English',
                    'FR' => 'Français',
                    'P_type' => 'Type de professionnel',
                    'R_type' => 'Type de détaillant',
                    'S_type' => 'Fournisseur Type',                    
                    'C_type' => Myclass::t('Catégorie'),
                    'category' => Myclass::t('Catégorie Nom'),
                    'export_type' => 'Type d\'exportation',
                    'country' => "Pays",
                    'region' => "Province",
                    'ID_GROUPE' => 'Regroupement',
                    'S_section' => 'Fournisseur Section',
                    'Etype' => "Exportype",
                    'CATEGORY_1' => Myclass::t('OG105'),
                    'CATEGORY_2' => Myclass::t('OG106'),
                    'CATEGORY_3' => Myclass::t('OG107'),
                    'CATEGORY_4' => Myclass::t('OG108'),
                    'CATEGORY_5' => Myclass::t('OG109'),
                    'Categories' => Myclass::t('Catégories'),
                    'status' => "Status",
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
	public function search($utype)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('attachment_file',$this->attachment_file,true);
		$criteria->condition = "user_type = '$utype'";
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
                    'sort'=>array(
                        'defaultOrder'=>'id DESC',
                      ),
                    'criteria'=>$criteria,
                    'pagination' => array(
                        'pageSize' => PAGE_SIZE,
                    )
		));
	}
        
        
        protected function afterFind() {
            /* Get selected region for current category information */
            $this->country = RegionDirectory::model()->findByPk($this->region)->ID_PAYS;
            return parent::afterFind();
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExportDatas the static model class
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
