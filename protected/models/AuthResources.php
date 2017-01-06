<?php

/**
 * This is the model class for table "{{auth_resources}}".
 *
 * The followings are the available columns in table '{{auth_resources}}':
 * @property integer $Master_Resource_ID
 * @property integer $Master_User_ID
 * @property integer $Master_Role_ID
 * @property integer $Master_Society_ID
 * @property integer $Master_Module_ID
 * @property integer $Master_Screen_ID
 * @property string $Master_Task_ADD
 * @property string $Master_Task_SEE
 * @property string $Master_Task_UPT
 * @property string $Master_Task_DEL
 * @property integer $Active
 * @property string $Created_Date
 * @property string $Rowversion
 *
 * The followings are the available model relations:
 * @property MasterRole $masterRole
 * @property User $masterUser
 * @property MasterModule $masterModule
 * @property MasterScreen $masterScreen
 */
class AuthResources extends RActiveRecord {
    
    public $id;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{auth_resources}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Master_Module_ID, Master_Screen_ID', 'required'),
            array('Master_Role_ID, Master_Module_ID, Master_Screen_ID, Active', 'numerical', 'integerOnly' => true),
            array('Master_Task_ADD, Master_Task_SEE, Master_Task_UPT, Master_Task_DEL', 'length', 'max' => 1),
            array('Rowversion, Created_By, Updated_By', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Master_Resource_ID, Master_User_ID, Master_Role_ID, Master_Module_ID, Master_Screen_ID, Master_Task_ADD, Master_Task_SEE, Master_Task_UPT, Master_Task_DEL, Active, Created_Date, Rowversion', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'masterRole' => array(self::BELONGS_TO, 'MasterRole', 'Master_Role_ID'),
            'masterUser' => array(self::BELONGS_TO, 'Admin', 'Master_User_ID'),
            'masterModule' => array(self::BELONGS_TO, 'MasterModule', 'Master_Module_ID'),         
            'masterScreen' => array(self::BELONGS_TO, 'MasterScreen', 'Master_Screen_ID'),
            //'createdBy' => array(self::BELONGS_TO, 'User', 'Created_By'),
            //'updatedBy' => array(self::BELONGS_TO, 'User', 'Updated_By'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Master_Resource_ID' => 'Master Resource',
            'Master_User_ID' => 'Master User',
            'Master_Role_ID' => 'Master Role',
            'Master_Module_ID' => 'Master Module',
            'Master_Screen_ID' => 'Master Screen',
            'Master_Task_ADD' => 'Master Task Add',
            'Master_Task_SEE' => 'Master Task See',
            'Master_Task_UPT' => 'Master Task Upt',
            'Master_Task_DEL' => 'Master Task Del',
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

        $criteria->compare('Master_Resource_ID', $this->Master_Resource_ID);        
        $criteria->compare('Master_Role_ID', $this->Master_Role_ID);        
        $criteria->compare('Master_Module_ID', $this->Master_Module_ID);
        $criteria->compare('Master_Screen_ID', $this->Master_Screen_ID);
        $criteria->compare('Master_Task_ADD', $this->Master_Task_ADD, true);
        $criteria->compare('Master_Task_SEE', $this->Master_Task_SEE, true);
        $criteria->compare('Master_Task_UPT', $this->Master_Task_UPT, true);
        $criteria->compare('Master_Task_DEL', $this->Master_Task_DEL, true);
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
     * @return AuthResources the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
