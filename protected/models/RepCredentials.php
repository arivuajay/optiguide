<?php

/**
 * This is the model class for table "rep_credentials".
 *
 * The followings are the available columns in table 'rep_credentials':
 * @property integer $rep_credential_id
 * @property string $rep_username
 * @property string $rep_password
 * @property string $rep_role
 * @property integer $rep_parent_id
 * @property string $rep_status
 * @property string $rep_expiry_date
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property RepSingleSubscriptions[] $repSingleSubscriptions
 */
class RepCredentials extends CActiveRecord {

    public $subscription_type_id;
    public $no_of_accounts_purchase = 1;
    public $old_password;
    public $new_password;
    public $confirm_password;

    const ROLE_SINGLE = 'single';
    const ROLE_ADMIN = 'admin';
    const NAME_TABLE = 'rep_credential';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rep_credentials';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subscription_type_id', 'required', 'on' => 'step1', 'message' => 'Select the subscription'),
            array('rep_username, rep_password, no_of_accounts_purchase', 'required', 'on' => 'step2'),
            array('rep_username, rep_password', 'required', 'on' => 'update'),
            array('rep_username', 'unique'),
            array('rep_username, rep_password', 'required', 'on' => 'create_new_rep_account'),
            array('no_of_accounts_purchase', 'numerical', 'integerOnly' => true),
            array('rep_parent_id', 'numerical', 'integerOnly' => true),
            array('rep_username, rep_password', 'length', 'max' => 255),
            array('rep_role', 'length', 'max' => 6),
            array('rep_status', 'length', 'max' => 1),
            array('subscription_type_id, no_of_accounts_purchase', 'safe'),
            array('old_password, new_password, confirm_password', 'required', 'on' => 'changePwd'),
            array('old_password', 'findPasswords', 'on' => 'changePwd'),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'changePwd'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rep_credential_id, rep_username, rep_password, rep_role, rep_parent_id, rep_status, rep_expiry_date, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    //matching the old password with your existing password.
    public function findPasswords($attribute, $params) {
        $user = $this->model()->findByPk(Yii::app()->user->id);
        if ($user->rep_password != $this->old_password)
            $this->addError($attribute, 'Old password is incorrect.');
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'repAdminSubscribers' => array(self::HAS_MANY, 'RepAdminSubscribers', 'rep_credential_id'),
            'repAdminSubscriptions' => array(self::HAS_MANY, 'RepAdminSubscriptions', 'rep_credential_id'),
            'repCredentialProfiles' => array(self::HAS_ONE, 'RepCredentialProfiles', 'rep_credential_id'),
            'repSingleSubscriptions' => array(self::HAS_MANY, 'RepSingleSubscriptions', 'rep_credential_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rep_credential_id' => Myclass::t('Rep Credential'),
            'rep_username' => Myclass::t('Username'),
            'rep_password' => Myclass::t('Password'),
            'rep_role' => Myclass::t('Rep Role'),
            'rep_parent_id' => Myclass::t('Rep Parent'),
            'rep_status' => Myclass::t('Rep Status'),
            'rep_expiry_date' => Myclass::t('Rep Expiry Date'),
            'created_at' => Myclass::t('Created At'),
            'modified_at' => Myclass::t('Modified At'),
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

        $criteria->compare('rep_credential_id', $this->rep_credential_id);
        $criteria->compare('rep_username', $this->rep_username, true);
        $criteria->compare('rep_password', $this->rep_password, true);
        $criteria->compare('rep_role', $this->rep_role, true);
        $criteria->compare('rep_parent_id', $this->rep_parent_id);
        $criteria->compare('rep_status', $this->rep_status, true);
        $criteria->compare('rep_expiry_date', $this->rep_expiry_date, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RepCredentials the static model class
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

    public function beforeSave() {
        if ($this->isNewRecord)
            $this->created_at = new CDbExpression('NOW()');

        $this->modified_at = new CDbExpression('NOW()');
        return parent::beforeSave();
    }

    public function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            $umodel = new UserDirectory();
            $umodel->LANGUE = Yii::app()->session['language'];
            $umodel->NOM_UTILISATEUR = $this->rep_username;
            $umodel->USR = Myclass::getRandomString(8);
            $umodel->PWD = Myclass::getRandomString(8);
            $umodel->NOM_TABLE = self::NAME_TABLE;
            $umodel->sGuid = Myclass::getGuid();
            $umodel->MUST_VALIDATE = 0;
            $umodel->ID_RELATION = $this->rep_credential_id;
            $umodel->save(false);
        }
    }

    public function scopes() {
        return array(
            'rep_admin_subscribers' => array(
                'condition' => 'rep_parent_id = :PARENT_ID',
                'params' => array(':PARENT_ID' => Yii::app()->user->id),
            ),
        );
    }

    public function getRepAdminActiveAccountsCount() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'rep_parent_id = :admin_id AND rep_expiry_date >= :today';
        $criteria->params = array(
            ':admin_id' => Yii::app()->user->id,
            ':today' => date("Y-m-d"),
        );
        $result = $this->model()->count($criteria);
        return $result;
    }

}
