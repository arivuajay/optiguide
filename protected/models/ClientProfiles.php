<?php

/**
 * This is the model class for table "client_profiles".
 *
 * The followings are the available columns in table 'client_profiles':
 * @property integer $client_id
 * @property string $name
 * @property string $company
 * @property string $job_title
 * @property string $member_type
 * @property integer $category
 * @property string $address
 * @property string $local_number
 * @property string $country
 * @property string $region
 * @property string $ville
 * @property string $phonenumber1
 * @property string $phonenumber2
 * @property string $mobile_number
 * @property string $tollfree_number
 * @property string $fax
 * @property string $email
 * @property string $site_address
 * @property string $subscription
 * @property string $created_date
 * @property string $modified_date
 */
class ClientProfiles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client_profiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category', 'numerical', 'integerOnly'=>true),
			array('name, company, job_title, member_type, address, local_number, subscription', 'length', 'max'=>255),
			array('country, region, ville, phonenumber1, phonenumber2, mobile_number, tollfree_number, fax, email, site_address', 'length', 'max'=>55),
			array('created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('client_id, name, company, job_title, member_type, category, address, local_number, country, region, ville, phonenumber1, phonenumber2, mobile_number, tollfree_number, fax, email, site_address, subscription, created_date, modified_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'client_id' => Myclass::t('Client'),
			'name' => Myclass::t('Name'),
			'company' => Myclass::t('Company'),
			'job_title' => Myclass::t('Job Title'),
			'member_type' => Myclass::t('Member Type'),
			'category' => Myclass::t('Category'),
			'address' => Myclass::t('Address'),
			'local_number' => Myclass::t('Local Number'),
			'country' => Myclass::t('Country'),
			'region' => Myclass::t('Region'),
			'ville' => Myclass::t('Ville'),
			'phonenumber1' => Myclass::t('Phonenumber1'),
			'phonenumber2' => Myclass::t('Phonenumber2'),
			'mobile_number' => Myclass::t('Mobile Number'),
			'tollfree_number' => Myclass::t('Tollfree Number'),
			'fax' => Myclass::t('Fax'),
			'email' => Myclass::t('Email'),
			'site_address' => Myclass::t('Site Address'),
			'subscription' => Myclass::t('Subscription'),
			'created_date' => Myclass::t('Created Date'),
			'modified_date' => Myclass::t('Modified Date'),
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

		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('job_title',$this->job_title,true);
		$criteria->compare('member_type',$this->member_type,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('local_number',$this->local_number,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('ville',$this->ville,true);
		$criteria->compare('phonenumber1',$this->phonenumber1,true);
		$criteria->compare('phonenumber2',$this->phonenumber2,true);
		$criteria->compare('mobile_number',$this->mobile_number,true);
		$criteria->compare('tollfree_number',$this->tollfree_number,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('site_address',$this->site_address,true);
		$criteria->compare('subscription',$this->subscription,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);

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
	 * @return ClientProfiles the static model class
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
