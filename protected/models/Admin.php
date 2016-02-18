<?php

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $admin_id
 * @property string $admin_name
 * @property string $admin_password
 * @property string $admin_status
 * @property string $admin_email
 * @property string $created_date
 * @property string $admin_last_login
 * @property integer $admin_login_ip
 */
class Admin extends CActiveRecord {

    public $current_password, $re_password,$org_password;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{app_admin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('admin_name, admin_username, org_password, admin_email,role', 'required'),
//			array('admin_login_ip', 'numerical', 'integerOnly'=>true),
            array('admin_name,admin_username, admin_email', 'required', 'on' => 'update'),
            array('admin_email', 'email'),
            array('admin_username,admin_email','unique'),
            array('admin_email', 'required', 'on' => 'forgotpassword'),
            array('admin_password,current_password,re_password', 'required', 'on' => 'changepassword'),
            array('current_password', 'compare', 'compareAttribute' => 're_password', 'on' => 'changepassword'),
            array('admin_password', 'equalPasswords', 'on' => 'changepassword'),
            array('admin_name, admin_password, admin_email', 'length', 'max' => 255),
            array('admin_status', 'length', 'max' => 1),
            array('admin_last_login,org_password,role', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('admin_id, admin_name, admin_password, admin_status, admin_email, created_date, admin_last_login, admin_login_ip', 'safe', 'on' => 'search'),
        );
 
    }

    public function equalPasswords($attribute, $params) {
        $admin = Admin::model()->findByPk(Yii::app()->user->id);
        if ($this->$attribute != "" && $admin->admin_password != Myclass::encrypt($this->$attribute)) {
            $this->addError($attribute, Myclass::t('APP12'));
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'authResources' => array(self::HAS_MANY, 'AuthResources', 'Master_User_ID'),
            'roleMdl' => array(self::BELONGS_TO, 'MasterRole', 'role'),
           
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'admin_id' => Myclass::t('APP1'),
            'admin_name' => Myclass::t('APP2'),
            'admin_username' => Myclass::t('APP3'),
            'admin_password' => 'Mot de passe actuel',
            'admin_status' => Myclass::t('APP5'),
            'admin_email' => Myclass::t('APP6'),
            'current_password' => 'Nouveau mot de passe',
            're_password' => 'Retapez le nouveau mot de passe',
            'created_date' => Myclass::t('APP9'),
            'admin_last_login' => Myclass::t('APP10'),
            'admin_login_ip' => Myclass::t('APP11'),
            'role' => 'role',    
            'org_password' => Myclass::t('APP4'),
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

        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('admin_name', $this->admin_name, true);
        $criteria->compare('admin_password', $this->admin_password, true);
        $criteria->compare('admin_status', $this->admin_status, true);
        $criteria->compare('admin_email', $this->admin_email, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('admin_last_login', $this->admin_last_login, true);
        $criteria->compare('admin_login_ip', $this->admin_login_ip);
        if($this->role){
            $criteria->condition = "role=:role_type and role != 1";
        $criteria->params=(array(':role_type'=>$this->role));
        }else{
          $criteria->condition = "role != 1";   
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Admin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}