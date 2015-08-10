<?php

/**
 * This is the model class for table "publicite_lien_region".
 *
 * The followings are the available columns in table 'publicite_lien_region':
 * @property integer $ID_PUB_REGION
 * @property integer $ID_PUBLICITE
 * @property integer $ID_REGION
 *
 * The followings are the available model relations:
 * @property PublicitePublicite $iDPUBLICITE
 * @property RepertoireRegion $iDREGION
 */
class AdsLInkRegion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'publicite_lien_region';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_PUBLICITE, ID_REGION', 'required'),
			array('ID_PUBLICITE, ID_REGION', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_PUB_REGION, ID_PUBLICITE, ID_REGION', 'safe', 'on'=>'search'),
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
			'iDPUBLICITE' => array(self::BELONGS_TO, 'PublicitePublicite', 'ID_PUBLICITE'),
			'iDREGION' => array(self::BELONGS_TO, 'RepertoireRegion', 'ID_REGION'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_PUB_REGION' => Myclass::t('Id Pub Region'),
			'ID_PUBLICITE' => Myclass::t('Id Publicite'),
			'ID_REGION' => Myclass::t('Id Region'),
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

		$criteria->compare('ID_PUB_REGION',$this->ID_PUB_REGION);
		$criteria->compare('ID_PUBLICITE',$this->ID_PUBLICITE);
		$criteria->compare('ID_REGION',$this->ID_REGION);

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
	 * @return AdsLInkRegion the static model class
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
