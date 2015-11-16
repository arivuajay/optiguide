<?php

/**
 * This is the model class for table "{{poll_vote}}".
 *
 * The followings are the available columns in table '{{poll_vote}}':
 * @property string $id
 * @property string $choice_id
 * @property string $poll_id
 * @property string $user_id
 * @property string $ip_address
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property User $user
 * @property PollChoice $choice
 * @property Poll $poll
 */
class PollVote extends CActiveRecord
{
    public  $ID_RETAILER_TYPE,$ID_TYPE_FOURNISSEUR,$ID_TYPE_SPECIALISTE,$region,$ID_VILLE,$NOM_REGION_FR;
    /**
   * Returns the static model of the specified AR class.
   * @return PollVote the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'poll_vote';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('choice_id, poll_id', 'required','message'=> Myclass::t('OG149')),  
      array('region,ID_VILLE', 'required','message'=> Myclass::t('OG152')),
      array('choice_id, poll_id, user_id, timestamp', 'length', 'max'=>11),
      array('ip_address', 'length', 'max'=>16),
      array('ID_TYPE_SPECIALISTE,ID_RETAILER_TYPE,ID_TYPE_FOURNISSEUR,region,ID_VILLE,NOM_REGION_FR','safe'),  
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    return array(
      'user' => array(self::BELONGS_TO, 'User', 'user_id'),
      'pollChoice' => array(self::BELONGS_TO, 'PollChoice', 'choice_id'),
      'regionDirectory' => array(self::BELONGS_TO, 'RegionDirectory', 'region'),      
      'cityDirectory' => array(self::BELONGS_TO, 'CityDirectory', 'ID_VILLE'),  
      'professionalType' => array(self::BELONGS_TO, 'ProfessionalType', 'ID_TYPE_SPECIALISTE'),
      'retailerType' => array(self::BELONGS_TO, 'RetailerType', 'ID_RETAILER_TYPE'),
      'supplierType' => array(self::BELONGS_TO, 'SupplierType', 'ID_TYPE_FOURNISSEUR'),
      'poll' => array(self::BELONGS_TO, 'Poll', 'poll_id'),
    );
  }
  
   public function search($id) {
        // @todo Please modify the following code to remove attributes that should not be searched.
//echo $id; exit;
       
        $usrtype = Poll::model()->findByPk($id)->usertype;
        
       
        $criteria = new CDbCriteria;
        $criteria->addCondition("poll_id='$id'");
        if($usrtype=="1")
        {    
            // Professional
            $criteria->with  = array('regionDirectory','cityDirectory','professionalType');
        }else if($usrtype=="2")
        {
            // Supplier
            $criteria->with  = array('regionDirectory','cityDirectory','supplierType');
        }else if($usrtype=="3")
        {
            // Retailer
            $criteria->with  = array('regionDirectory','cityDirectory','retailerType');
        }else
        {
             $criteria->with  = array('regionDirectory','cityDirectory');
        }    
        //$criteria->together = true;
        $criteria->order = 'timestamp ASC';

        return new CActiveDataProvider($this, array(  
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }
    
    protected function afterFind() {
        /* Get selected region for current category information */
        $this->ID_VILLE = CityDirectory::model()->findByPk($this->ID_VILLE)->NOM_VILLE;
        $this->NOM_REGION_FR   = RegionDirectory::model()->findByPk($this->region)->NOM_REGION_FR;      
        return parent::afterFind();
    }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'choice_id' =>  Myclass::t('OG150'),
      'ID_TYPE_SPECIALISTE' => Myclass::t('OG102'),
      'region' => 'Province',
      'ID_VILLE' => Myclass::t('APP70'),
    );
  }

  /**
   * Before a PollVote is saved.
   */
  public function beforeSave()
  {
    $this->ip_address = $_SERVER['REMOTE_ADDR'];
    $this->timestamp = time();
    $this->user_id = Yii::app()->user->id;

    // Relation may not exist yet so find it normally
    $choice = PollChoice::model()->findByPk($this->choice_id);
    if ($choice) {
      $choice->votes += 1;
      $choice->save();
    }
    else {
      return FALSE;
    }

    return parent::beforeSave(); 
  }

  /**
   * After a PollVote is deleted.
   */
  public function afterDelete()
  {
    $this->choice->votes -= 1;
    $this->choice->save();

    parent::afterDelete();
  }

  
  /**
   * Before a PollVote is deleted.
   */
  public function beforeDelete()
  {
    if (!$this->poll->userCanCancelVote($this)) {
      return FALSE;
    }
    return parent::beforeDelete();
  }

}
