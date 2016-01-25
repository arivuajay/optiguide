<?php

/**
 * This is the model class for table "{{master_role}}".
 *
 * The followings are the available columns in table '{{master_role}}':
 * @property integer $Master_Role_ID
 * @property string $Role_Code
 * @property string $Description
 * @property string $is_Admin
 * @property string $Rank
 * @property integer $Active
 * @property string $Created_Date
 * @property string $Rowversion
 *
 * The followings are the available model relations:
 * @property AuthResources[] $authResources
 * @property User[] $users
 */
class MasterRole extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{master_role}}';
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        $user = Admin::model()->find('admin_id = :U', array(':U' => Yii::app()->user->id));
        //$rank = !empty($user) ? $user->roleMdl->Rank : 0;
        return array(
            'isActive' => array('condition' => "$alias.Active = '1'"),
          //  'slaves' => array('condition' => "$alias.Rank >= '$rank'"),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Role_Code, Description', 'required'),
            array('Role_Code', 'length', 'max' => 45),
            array('Description', 'length', 'max' => 100),
            array('is_Admin, Active', 'length', 'max' => 1),
            array('Rank', 'numerical', 'integerOnly' => TRUE, 'min' => 1, 'max' => 1000),
            array('Rowversion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Master_Role_ID, Role_Code, Description, is_Admin, Active, Created_Date, Rowversion, Rank', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'authResources' => array(self::HAS_MANY, 'AuthResources', 'Master_Role_ID'),
            'users' => array(self::HAS_MANY, 'Admin', 'role'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Master_Role_ID' => 'Master Role',
            'Role_Code' => 'Role Code',
            'Description' => 'Description',
            'is_Admin' => 'Is Admin',
            'Rank' => 'Rank',
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

        $criteria->compare('Master_Role_ID', $this->Master_Role_ID);
        $criteria->compare('Role_Code', $this->Role_Code, true);
        $criteria->compare('Description', $this->Description, true);
        $criteria->compare('is_Admin', $this->is_Admin, true);
        $criteria->compare('Active', $this->Active);
        $criteria->compare('Created_Date', $this->Created_Date, true);
        $criteria->compare('Rowversion', $this->Rowversion, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    public function dataProvider() {
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MasterRole the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
