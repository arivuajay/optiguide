<?php

/**
 * This is the model class for table "classified_categories".
 *
 * The followings are the available columns in table 'classified_categories':
 * @property integer $classified_category_id
 * @property string $classified_category_name_EN
 * @property string $classified_category_name_FR
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Classifieds[] $classifieds
 */
class ClassifiedCategories extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'classified_categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('classified_category_name_EN, classified_category_name_FR', 'required'),
            array('classified_category_name_EN, classified_category_name_FR', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('classified_category_id, classified_category_name_EN, classified_category_name_FR, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'classifieds' => array(self::HAS_MANY, 'Classifieds', 'classified_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'classified_category_id' => Myclass::t('OGO208', '', 'og'),
            'classified_category_name_EN' => Myclass::t('OGO212', '', 'og'),
            'classified_category_name_FR' => Myclass::t('OGO212', '', 'og'),
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

        $criteria->compare('classified_category_id', $this->classified_category_id);
        $criteria->compare('classified_category_name_EN', $this->classified_category_name_EN, true);
        $criteria->compare('classified_category_name_FR', $this->classified_category_name_FR, true);
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
     * @return ClassifiedCategories the static model class
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
