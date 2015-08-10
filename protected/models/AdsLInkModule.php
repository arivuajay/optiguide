<?php

/**
 * This is the model class for table "publicite_lien_module".
 *
 * The followings are the available columns in table 'publicite_lien_module':
 * @property integer $ID_PUB_MODULE
 * @property integer $ID_PUBLICITE
 * @property integer $ID_MODULE
 *
 * The followings are the available model relations:
 * @property PubliciteModules $iDMODULE
 * @property PublicitePublicite $iDPUBLICITE
 */
class AdsLInkModule extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'publicite_lien_module';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_PUBLICITE, ID_MODULE', 'required'),
			array('ID_PUBLICITE, ID_MODULE', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID_PUB_MODULE, ID_PUBLICITE, ID_MODULE', 'safe', 'on'=>'search'),
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
			'iDMODULE' => array(self::BELONGS_TO, 'PubliciteModules', 'ID_MODULE'),
			'iDPUBLICITE' => array(self::BELONGS_TO, 'PublicitePublicite', 'ID_PUBLICITE'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_PUB_MODULE' => Myclass::t('Id Pub Module'),
			'ID_PUBLICITE' => Myclass::t('Id Publicite'),
			'ID_MODULE' => Myclass::t('Id Module'),
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

		$criteria->compare('ID_PUB_MODULE',$this->ID_PUB_MODULE);
		$criteria->compare('ID_PUBLICITE',$this->ID_PUBLICITE);
		$criteria->compare('ID_MODULE',$this->ID_MODULE);

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
	 * @return AdsLInkModule the static model class
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
