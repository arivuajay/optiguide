<?php

/**
 * This is the model class for table "{{master_screen}}".
 *
 * The followings are the available columns in table '{{master_screen}}':
 * @property integer $Master_Screen_ID
 * @property integer $Module_ID
 * @property string $Screen_code
 * @property string $Description
 * @property integer $Active
 * @property string $Created_Date
 * @property string $Rowversion
 *
 * The followings are the available model relations:
 * @property AuthResources[] $authResources
 * @property MasterModule $module
 */
class MasterScreen extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{master_screen}}';
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        return array(
            'isActive' => array('condition' => "$alias.Active = '1'"),
        );
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Module_ID, Screen_code, Active, Created_Date', 'required'),
            array('Module_ID, Active', 'numerical', 'integerOnly' => true),
            array('Screen_code', 'length', 'max' => 45),
            array('Description', 'length', 'max' => 100),
            array('Rowversion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Master_Screen_ID, Module_ID, Screen_code, Description, Active, Created_Date, Rowversion', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'authResources' => array(self::HAS_MANY, 'AuthResources', 'Master_Screen_ID'),
            'module' => array(self::BELONGS_TO, 'MasterModule', 'Module_ID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Master_Screen_ID' => 'Master Screen',
            'Module_ID' => 'Module',
            'Screen_code' => 'Screen Code',
            'Description' => 'Description',
            'Active' => 'Active',
            'Created_Date' => 'Created Date',
            'Rowversion' => 'Rowversion',
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

        $criteria->compare('Master_Screen_ID', $this->Master_Screen_ID);
        $criteria->compare('Module_ID', $this->Module_ID);
        $criteria->compare('Screen_code', $this->Screen_code, true);
        $criteria->compare('Description', $this->Description, true);
        $criteria->compare('Active', $this->Active);
        $criteria->compare('Created_Date', $this->Created_Date, true);
        $criteria->compare('Rowversion', $this->Rowversion, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MasterScreen the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
