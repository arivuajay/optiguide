<?php

class PollController extends Controller
{
  /**
   * @return array action filters
   */
  public function filters()
  {
    
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules()
  {
    return array(
      array('allow',
        'actions'=>array(''),
        'users'=>array('*'),
      ),
      array('allow',
        'actions'=>array('index','view', 'vote','create','update','admin','delete','export','Print'),
        'users'=>array('@'),
        'expression'=> 'AdminIdentity::checkAccess()',
      ),
      array('deny',
        'users'=>array('*'),
      ),
    );
  }
  
  function actionPrint()
        {

                $data = Vouchers::model()->findAll('status=:status', array(':status'=>1));

                $fields = array(
                                'voucher_no',
                                'first_name',
                                'last_name',
                                'purchase_date',
                                'date_used',
                                'barcode'
                );
                
                ExcelExporter::sendAsXLS('Vouchers', $data, 'List of Vouchers', true, $fields); 
        }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);

    if (Yii::app()->getModule('poll')->forceVote && $model->userCanVote()) {
      $this->redirect(array('vote', 'id' => $model->id)); 
    }
    else {        
      $userVote = $this->loadVote($model);
      $userChoice = $this->loadChoice($model, $userVote->choice_id);
      
      $exportresult = Yii::app()->request->getQuery('exportresult','0'); 
      if($exportresult=="1")
      {    
        $exportForm = new PollExportForm($model);       
        $exportForm->export(); 
      }   
      
      // define the variable to “LIMIT” the query        
//        $page = Yii::app()->request->getParam('page');
//        $page = isset($page) ? $page : 1;
//        $limit = 0;
//
//        if ($page > 1) {
//            $offset = $page - 1;
//            $limit = LISTPERPAGE * $offset;
//        }
   
        // Get all records list  with limit
//        $votes_query = Yii::app()->db->createCommand() //this query contains all the data
//                ->select('pc.label,rst.TYPE_SPECIALISTE_FR,rr.NOM_REGION_FR,rv.NOM_VILLE,pv.timestamp')
//                ->from(array('poll_vote pv', 'poll_choice pc', 'repertoire_specialiste_type AS rst', 'repertoire_ville AS rv', 'repertoire_region AS rr'))
//                ->where("pc.id=pv.choice_id AND pv.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND pv.ID_VILLE = rv.ID_VILLE AND pv.region = rr.ID_REGION AND  pv.poll_id='" . $id ."'")
//                ->order('pv.timestamp')
//                ->limit(LISTPERPAGE, $limit) // the trick is here!
//                ->queryAll();
//
//        // Get total counts of records    
//        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
//                ->select('count(*) as count')
//                ->from(array('poll_vote pv', 'poll_choice pc', 'repertoire_specialiste_type AS rst', 'repertoire_ville AS rv', 'repertoire_region AS rr'))
//                ->where("pc.id=pv.choice_id AND pv.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND pv.ID_VILLE = rv.ID_VILLE AND pv.region = rr.ID_REGION AND  pv.poll_id='" . $id ."'")
//                ->queryScalar(); // do not LIMIT it, this must count all items!
//        // the pagination itself      
//        $pages = new CPagination($item_count);
//        $pages->setPageSize(LISTPERPAGE);
      
       $vmodel = new PollVote('search');
       $vmodel->unsetAttributes();  // clear any default values
       if (isset($_GET['ProfessionalDirectory']))
       $vmodel->attributes = $_GET['ProfessionalDirectory'];
     
      $vsearchmodel = $vmodel->search($model->id);

      $this->render('view', array(
        'model' => $model,
        'userVote' => $userVote,
        'userChoice' => $userChoice,
        'userCanCancel' => $model->userCanCancelVote($userVote),
//        'item_count' => $item_count,
//        'page_size' => LISTPERPAGE,
//        'pages' => $pages,
        'vmodel' =>   $vsearchmodel
      ));
    }
  }
  
  

  /**
   * Vote on a poll.
   * If vote is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to vote on
   */
  public function actionVote($id)
  {
    $model = $this->loadModel($id);
    $vote = new PollVote;

    if (!$model->userCanVote())
      $this->redirect(array('view', 'id' => $model->id));

    if (isset($_POST['PollVote'])) {
      $vote->attributes = $_POST['PollVote'];
      $vote->poll_id = $model->id;
      if ($vote->save())
        $this->redirect(array('view', 'id' => $model->id));
    }

    // Convert choices to form options list
    $choices = array();
    foreach ($model->choices as $choice) {
      $choices[$choice->id] = CHtml::encode($choice->label);
    }

    $this->render('vote', array(
      'model' => $model,
      'vote' => $vote,
      'choices' => $choices,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new Poll;    
    $choices = array();
    
    $this->performAjaxValidation($model);

    if (isset($_POST['Poll'])) {
      $model->attributes = $_POST['Poll'];

      // Setup poll choices
      if (isset($_POST['PollChoice']))
      {
        foreach ($_POST['PollChoice'] as $id => $choice) {
          $pollChoice = new PollChoice;
          $pollChoice->attributes = $choice;
          $choices[$id] = $pollChoice;
        }
        
      }
      
        $polldate = isset($_POST['Poll']['polldate'])?$_POST['Poll']['polldate']:"";
        if($polldate!='')
        {    
            $model->polldate =  date("Y-m-d",strtotime($polldate));      
        }  
      
        $model->usertype = 1;
     
        if ( $model->validate()) {
         $model->save();
        // Save any poll choices too
        foreach ($choices as $choice) {
          $choice->poll_id = $model->id;
          $choice->save();
        }
        Yii::app()->user->setFlash('success', 'Sondages créé avec succès!!!');
        $this->redirect(array('index'));
      }
      
    }

    $this->render('create', array(
      'model' => $model,
      'choices' => $choices,
    ));
  }
  


  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $choices = $model->choices;
    $this->performAjaxValidation($model);

    if (isset($_POST['Poll'])) {
      $model->attributes = $_POST['Poll'];

      // Setup poll choices
      $choices = array();
      if (isset($_POST['PollChoice'])) {
        foreach ($_POST['PollChoice'] as $id => $choice) {
          $pollChoice = $this->loadChoice($model, $choice['id']);
          $pollChoice->attributes = $choice;
          $choices[$id] = $pollChoice;
        }
         
        $polldate = $_POST['Poll']['polldate'];
        $model->polldate =  date("Y-m-d",strtotime($polldate));      
      }
      $model->usertype = 1;
      if ($model->save()) {
        // Save any poll choices too
        foreach ($choices as $choice) {
          $choice->poll_id = $model->id;
          $choice->save();
        }

        $this->redirect(array('index'));
      }
    }

    $this->render('update',array(
      'model'=>$model,
      'choices'=>$choices,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    // we only allow deletion via POST request
    $this->loadModel($id)->delete();
    
    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if(!isset($_GET['ajax'])){
        Yii::app()->user->setFlash('success', 'Sondage Supprimé avec succès!!');
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $model=new Poll('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['Poll']))
      $model->attributes=$_GET['Poll'];

    $this->render('index',array(
      'model'=>$model,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model=new Poll('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['Poll']))
      $model->attributes=$_GET['Poll'];

    $this->render('admin',array(
      'model'=>$model,
    ));
  }

  /**
   * Export the results of a Poll.
   */
  public function actionExport($id)
  {
   
    $model = $this->loadModel($id);
    $exportForm = new PollExportForm($model);
    $cform = $exportForm->cform();

    if ($cform->submitted('submit') && $cform->validate()) {
      $exportForm->export(); 
    }

    $this->render('export', array(
      'model' => $model,
      'exportForm' => $exportForm, 
      'cform' => $cform,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model=Poll::model()->with('choices','votes')->findByPk($id);
    if($model===null)
      throw new CHttpException(404,'The requested page does not exist.');
    return $model;
  }

  /**
   * Returns the PollChoice model based on primary key or a new PollChoice instance.
   * @param Poll the Poll model 
   * @param integer the ID of the PollChoice to be loaded
   */
  public function loadChoice($poll, $choice_id)
  {
    if ($choice_id) {
      foreach ($poll->choices as $choice) {
        if ($choice->id == $choice_id) return $choice;
      }
    }

    return new PollChoice;
  }

  /**
   * Returns the PollVote model based on primary key or a new PollVote instance.
   * @param object the Poll model 
   */
  public function loadVote($model)
  {
    $userId = (int) Yii::app()->user->id;
    $isGuest = Yii::app()->user->isGuest;

    foreach ($model->votes as $vote) {
      if ($vote->user_id == $userId) {
        if (Yii::app()->getModule('poll')->ipRestrict && $isGuest && $vote->ip_address != $_SERVER['REMOTE_ADDR'])
          continue;
        else
          return $vote;
      }
    }

    return new PollVote;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if(isset($_POST['ajax']) && $_POST['ajax']==='poll-form')
    {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
