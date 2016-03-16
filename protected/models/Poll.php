<?php

/**
 * This is the model class for table "{{poll}}".
 *
 * The followings are the available columns in table '{{poll}}':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property PollChoice[] $choices
 * @property PollVote[] $votes
 */
class Poll extends CActiveRecord
{
  public $labelerror,$Year;
  /**
   * @var integer representing a closed poll status
   */
  const STATUS_CLOSED = 0;

  /**
   * @var integer representing an open poll status
   */
  const STATUS_OPEN = 1;

  /**
   * Returns the static model of the specified AR class.
   * @return Poll the static model class
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
    return 'poll';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('title,title_FR,polldate,usertype', 'required'),
      array('status', 'numerical', 'integerOnly'=>true),
      array('title,title_FR', 'length', 'max'=>255),
      array('description,description_FR,labelerror,Year', 'safe'),    
      array('polldate', 'checkpollexist' ) ,
      array('title, description, status,title_FR,description_FR,', 'safe', 'on'=>'search'),
    );
  }  

  
   public function checkpollexist($attribute,$params='')
    {
      if($this->$attribute!='' && $this->usertype!='')
      {      
           $pdate = date("Y-m-d",strtotime($this->$attribute));   
           
           if($this->id!='')
           {                
               $count = Poll::model()->count( 'polldate=:pdate and usertype=:utype and id!=:pid', array(':pdate' => $pdate, ':utype'=> $this->usertype, ':pid'=>$this->id));
           }  else {
                $count = Poll::model()->count( 'polldate=:pdate and usertype=:utype', array(':pdate' => $pdate, ':utype'=> $this->usertype));
           }    
           
           if($count>0)
           {    
            $this->addError($attribute,'Sondage existe déjà pour le type d\'utilisateur sur ce mois.' );
           } 
      }        
    }
 
      
     protected function beforeValidate() 
     {       
        if(!isset($_POST['PollChoice']))
        {    
         $this->addError('labelerror', 'S\'il vous plaît ajouter quelques choices');
         
        } 
        
        if(count($_POST['PollChoice']) < 2)
        {
          $this->addError('labelerror', 'S\'il vous plaît ajouter atleast deux choices');           
        }    
            
        
        return parent::beforeValidate();
    }
 

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    return array(
      'choices' => array(self::HAS_MANY, 'PollChoice', 'poll_id'),
      'votes' => array(self::HAS_MANY, 'PollVote', 'poll_id'),
      'totalVotes' => array(self::STAT, 'PollChoice', 'poll_id', 'select' => 'SUM(votes)'),
    );
  }

  /** 
   * @return array additional query scopes
   */
  public function scopes()
  {
    return array(
      'open'=>array(
        'condition'=>'status='. self::STATUS_OPEN,
       ),  
      'closed'=>array(
        'condition'=>'status='. self::STATUS_CLOSED,
       ),  
       'latest'=>array(
        'order'=>'id DESC',
       ),  
    );  
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'title' => 'Title',
      'description' => 'Description',
      'status' => 'Status',
      'polldate' => "Poll Date", 
      'usertype' => 'User Type',
      'title_FR' => 'Titre',
      'description_FR' => 'La description',
    );
  }

  /**
   * @return array customized status labels
   */
  public function statusLabels()
  {
    return array(
      self::STATUS_CLOSED => 'Closed',
      self::STATUS_OPEN   => 'Open',
    );
  }

  /**
   * Returns the text label for the specified status.
   */
  public function getStatusLabel($status)
  {
    $labels = self::statusLabels();

    if (isset($labels[$status])) {
      return $labels[$status];
    }

    return $status;
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search()
  {
    $criteria=new CDbCriteria;

    $criteria->compare('title',$this->title,true);
    $criteria->compare('description',$this->description,true);
    $criteria->compare('status',$this->status);
    $criteria->compare('usertype',$this->usertype,true);
    $criteria->compare('polldate',$this->polldate,true);
    $criteria->compare('title_FR',$this->title_FR,true);
    $criteria->compare('description_FR',$this->description_FR,true);

    return new CActiveDataProvider($this, array(
       'criteria'=>$criteria,
       'sort'=>array(
            'defaultOrder'=>'polldate DESC',
        ),
        'pagination' => array(
               'pageSize' => PAGE_SIZE,
           )
    ));
  }

  /**
   * Determine if a user can vote on a Poll.
   */
  public function userCanVote()
  {
    if ($this->status == self::STATUS_CLOSED) return FALSE;

    // Setup global query attributes
    $where = array('and', 'poll_id=:poll_id', 'user_id=:user_id');
    $params = array(':poll_id' => $this->id, ':user_id' => (int) Yii::app()->user->id);

    // Add IP restricted attributes if needed
    if (Yii::app()->getModule('poll')->ipRestrict === TRUE && Yii::app()->user->isGuest) {
      $where[] = 'ip_address=:ip_address';
      $params[':ip_address'] = $_SERVER['REMOTE_ADDR'];
    }

    // Retrieve true/false if a vote exists on poll by user
    $result = (bool) Yii::app()->db->createCommand(array(
      'select' => 'id',
      'from'   => '{{poll_vote}}',
      'where'  => $where,
      'params' => $params,
    ))->queryRow();

    return !$result;
  }

  /**
   * Determine if a user can cancel their vote.
   * @param PollVote instance
   */
  public function userCanCancelVote($pollVote)
  {
    if (!$pollVote->id || $this->status == self::STATUS_CLOSED) {
      return FALSE;
    }

    $module = Yii::app()->getModule('poll');
    $isGuest = Yii::app()->user->isGuest;
    $guestsCanCancel = $module->ipRestrict && $module->allowGuestCancel;

    if (!$isGuest || ($isGuest && $guestsCanCancel)) {
      return TRUE;
    }

    return FALSE;
  }
}
