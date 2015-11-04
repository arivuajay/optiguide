<?php

/**
 * This is the model class for table "classifieds".
 *
 * The followings are the available columns in table 'classifieds':
 * @property integer $classified_id
 * @property integer $classified_category_id
 * @property string $language
 * @property string $classified_title
 * @property string $classified_message
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property ClassifiedCategories $classifiedCategory
 */
class Classifieds extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'classifieds';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('classified_category_id, classified_title, classified_message', 'required'),
            array('classified_category_id', 'numerical', 'integerOnly' => true),
            array('language', 'length', 'max' => 2),
            array('classified_title', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('classified_id, classified_category_id, language, classified_title, classified_message, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'classifiedCategory' => array(self::BELONGS_TO, 'ClassifiedCategories', 'classified_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'classified_id' => Myclass::t('OGO206', '', 'og'),
            'classified_category_id' => Myclass::t('OGO208', '', 'og'),
            'language' => Myclass::t('OG159'),
            'classified_title' => Myclass::t('OGO213', '', 'og'),
            'classified_message' => Myclass::t('OGO211', '', 'og'),
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

        $criteria->compare('classified_id', $this->classified_id);
        $criteria->compare('classified_category_id', $this->classified_category_id);
        $criteria->compare('language', $this->language, true);
        $criteria->compare('classified_title', $this->classified_title, true);
        $criteria->compare('classified_message', $this->classified_message, true);
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
     * @return Classifieds the static model class
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

}
