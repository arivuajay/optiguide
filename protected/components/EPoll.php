<?php

//Yii::import('zii.widgets.CPortlet');

class EPoll extends CWidget {

  /**
   * @var integer the poll ID to load
   * Defaults to 0, which loads the latest poll
   */
  public $poll_id = 0;
  public $title;

  /**
   * @var integer the counter for generating implicit IDs.
   */
  private static $_pollCounter = 0;

  /**
   * @var string id of the widget.
   */
  private $_id;

  /**
   * @var Poll
   */
  private $_poll;

  /**
   * Returns the ID of the widget or generates a new one if requested.
   * @param boolean $autoGenerate whether to generate an ID if it is not set previously
   * @return string id of the widget.
   */
  public function getId($autoGenerate = TRUE)
  {
    if ($this->_id !== NULL)
      return $this->_id;
    else if ($autoGenerate)
      return $this->_id = 'Poll_'. self::$_pollCounter++;
  }


  /**
   * Initializes the portlet.
   */
  public function init()
  {

    $this->_poll = ($this->poll_id == 0) ? Poll::model()->latest()->find() : Poll::model()->findByPk($this->poll_id);
   
    if ($this->_poll) {
      $this->title = $this->_poll->title;
    }

    parent::init();
  }

  
  /**
   * Renders the portlet content.
   */
  public function run()
  {
    $model = $this->_poll;

    if ($model) {
      $userVote = $this->loadVote();
      $params = array('model' => $model, 'userVote' => $userVote);

      // Save a user's vote
      if (isset($_POST['PortletPollVote_choice_id'])) {
          
        $userVote->choice_id = $_POST['PortletPollVote_choice_id'];
        $userVote->poll_id = $model->id;
        $userVote->ID_TYPE_SPECIALISTE = isset($_POST['PollVote']['ID_TYPE_SPECIALISTE'])?$_POST['PollVote']['ID_TYPE_SPECIALISTE']:'0';
        $userVote->ID_TYPE_FOURNISSEUR = isset($_POST['PollVote']['ID_TYPE_FOURNISSEUR'])?$_POST['PollVote']['ID_TYPE_FOURNISSEUR']:'0';
        $userVote->ID_RETAILER_TYPE    = isset($_POST['PollVote']['ID_RETAILER_TYPE'])?$_POST['PollVote']['ID_RETAILER_TYPE']:'0';
        $userVote->region = isset($_POST['PollVote']['region'])?$_POST['PollVote']['region']:'0';
        $userVote->ID_VILLE = isset($_POST['PollVote']['ID_VILLE'])?$_POST['PollVote']['ID_VILLE']:'0';
        if ($userVote->save()) {
          // Prevent submit on refresh
          $route = Yii::app()->controller->route;
          Yii::app()->controller->redirect(Yii::app()->createUrl($route));
        }
      }

      // Force user to vote if needed
      if (Yii::app()->getModule('optiguide')->forceVote && $model->userCanVote()) {
        $view = 'vote';

        // Convert choices to form options list
        $choices = array();
        foreach ($model->choices as $choice) {
          $choices[$choice->id] = CHtml::encode($choice->label);
        }

        $params['choices'] = $choices;
        $params['Title']   = $this->title;
      }
      // Otherwise view the results
      else {
        $view = 'view';
        $userChoice = $this->loadChoice($userVote->choice_id);

        $params += array(
          'userVote' => $userVote,
          'userChoice' => $userChoice,
          'userCanCancel' => $model->userCanCancelVote($userVote),
          'Title' =>   $this->title,           
        );
      }
      
      $this->render($view, $params);
    }
  }


  /**
   * Returns the PollChoice model based on primary key or a new PollChoice instance.
   * @param integer the ID of the PollChoice to be loaded
   */
  public function loadChoice($choice_id)
  {
    if ($choice_id) {
      foreach ($this->_poll->choices as $choice) {
        if ($choice->id == $choice_id) return $choice;
      }
    }
    
    return new PollChoice;
  }


  /**
   * Returns the PollVote model based on primary key or a new PollVote instance.
   */
  public function loadVote()
  {
    $model = $this->_poll;
    $userId = (int) Yii::app()->user->id;
    $isGuest = Yii::app()->user->isGuest;

    foreach ($model->votes as $vote) {
        
      if ($vote->user_id == $userId) {
        if (Yii::app()->getModule('optiguide')->ipRestrict && $isGuest && $vote->ip_address != $_SERVER['REMOTE_ADDR'])
          continue;
        else
          return $vote;
      }
    }

    return new PollVote;
  }

}
