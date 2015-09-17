<?php

/**
 * This is the model class for table "mapping_reps".
 *
 * The followings are the available columns in table 'mapping_reps':
 * @property integer $id
 * @property integer $ID_FOURNISSEUR
 * @property integer $rep_credential_id
 */
class MappingReps extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mapping_reps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_FOURNISSEUR, rep_credential_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ID_FOURNISSEUR, rep_credential_id', 'safe', 'on'=>'search'),
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
			'id' => Myclass::t('ID'),
			'ID_FOURNISSEUR' => Myclass::t('Id Fournisseur'),
			'rep_credential_id' => Myclass::t('Rep Credential'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('ID_FOURNISSEUR',$this->ID_FOURNISSEUR);
		$criteria->compare('rep_credential_id',$this->rep_credential_id);

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
	 * @return MappingReps the static model class
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
