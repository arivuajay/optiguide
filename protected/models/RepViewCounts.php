<?php

/**
 * This is the model class for table "rep_view_counts".
 *
 * The followings are the available columns in table 'rep_view_counts':
 * @property integer $id
 * @property integer $rep_credential_id
 * @property integer $ID_SPECIALISTE
 * @property integer $ID_RETAILER
 * @property string $view_date
 */
class RepViewCounts extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rep_view_counts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rep_credential_id, ID_SPECIALISTE, ID_RETAILER', 'numerical', 'integerOnly' => true),
            array('view_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, rep_credential_id, ID_SPECIALISTE, ID_RETAILER, view_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Myclass::t('ID'),
            'rep_credential_id' => Myclass::t('OR664', '', 'or'),
            'ID_SPECIALISTE' => Myclass::t('OR709', '', 'or'),
            'ID_RETAILER' => Myclass::t('OR692', '', 'or'),
            'view_date' => Myclass::t('OR710', '', 'or'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('rep_credential_id', $this->rep_credential_id);
        $criteria->compare('ID_SPECIALISTE', $this->ID_SPECIALISTE);
        $criteria->compare('ID_RETAILER', $this->ID_RETAILER);
        $criteria->compare('view_date', $this->view_date, true);

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
     * @return RepViewCounts the static model class
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
