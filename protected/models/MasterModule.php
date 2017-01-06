<?php

/**
 * This is the model class for table "{{master_module}}".
 *
 * The followings are the available columns in table '{{master_module}}':
 * @property integer $Master_Module_ID
 * @property string $Module_Code
 * @property string $Description
 * @property string $Active
 * @property string $Created_Date
 * @property string $Rowversion
 *
 * The followings are the available model relations:
 * @property AuthResources[] $authResources
 * @property MasterScreen[] $masterScreens
 */
class MasterModule extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{master_module}}';
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
            array('Module_Code, Created_Date', 'required'),
            array('Module_Code', 'length', 'max' => 45),
            array('Description', 'length', 'max' => 100),
            array('Active', 'length', 'max' => 1),
            array('Rowversion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Master_Module_ID, Module_Code, Description, Active, Created_Date, Rowversion', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'authResources' => array(self::HAS_MANY, 'AuthResources', 'Master_Module_ID'),
            'masterScreens' => array(self::HAS_MANY, 'MasterScreen', 'Module_ID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Master_Module_ID' => 'Master Module',
            'Module_Code' => 'Module Code',
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

        $criteria->compare('Master_Module_ID', $this->Master_Module_ID);
        $criteria->compare('Module_Code', $this->Module_Code, true);
        $criteria->compare('Description', $this->Description, true);
        $criteria->compare('Active', $this->Active, true);
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
     * @return MasterModule the static model class
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

}
