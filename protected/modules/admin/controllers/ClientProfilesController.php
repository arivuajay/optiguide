<?php

class ClientProfilesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('SendReminder'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(''),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
        
        public function actionSendReminder()
        {
            $mdate = date("Y-m-d",time());            
            $criteria = new CDbCriteria;        
            $criteria->condition = "meeting_date='$mdate' and status=0";           
            $data_meets = ClientProfiles::model()->findAll($criteria);
         
            if(!empty($data_meets))
            {    
                foreach ($data_meets as $info)
                {
                   $meetid = $info->id; 
                    
                  /* Send mail to admin for confirmation */
                   $mail    = new Sendmail();
                   $subject = SITENAME."- Reminder client profile - ".$info->client;
                   $trans_array  = array(
                       "{NAME}"    => $info->client,                    
                       "{MESSAGE}" => $info->message, 
                       "{MDATE}"   => $info->meeting_date,   
                   );
                   $message = $mail->getMessage('meetingalert', $trans_array);
                   $mail->send(ADMIN_EMAIL, $subject, $message);
                   
                   $model=$this->loadModel($meetid);
                   $model->status=1;
                   $model->save();

                 } 
             }    
          
        }        

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ClientProfiles;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['ClientProfiles']))
		{
			$model->attributes=$_POST['ClientProfiles'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', 'Rappel créé avec succès !!!');
                                $this->redirect(array('index'));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['ClientProfiles']))
		{
			$model->attributes=$_POST['ClientProfiles'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', 'Rappel correctement mis à jour !!!');
                                $this->redirect(array('index'));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
                $this->loadModel($id)->delete();
        
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
                    Yii::app()->user->setFlash('success', 'ClientProfiles Deleted Successfully!!!');
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model=new ClientProfiles('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClientProfiles']))
			$model->attributes=$_GET['ClientProfiles'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ClientProfiles('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClientProfiles']))
			$model->attributes=$_GET['ClientProfiles'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ClientProfiles the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ClientProfiles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ClientProfiles $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-profiles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
