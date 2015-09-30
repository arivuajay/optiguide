<?php

class RepNotesController extends ORController
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
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','update','delete'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new RepNotes;

		if(isset($_POST['RepNotes']))
		{
			$model->attributes=$_POST['RepNotes'];
                        $model->rep_credential_id = Yii::app()->user->id;
                        $model->created_at = date('Y-m-d');
			if($model->save()){
                                Yii::app()->user->setFlash('success', 'Notes Created Successfully!!!');
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


		if(isset($_POST['RepNotes']))
		{
			$model->attributes=$_POST['RepNotes'];
                        $model->created_at = date('Y-m-d');
			if($model->save()){
                                Yii::app()->user->setFlash('success', 'Notes Updated Successfully!!!');
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
                    Yii::app()->user->setFlash('success', 'Note deleted Successfully!!!');
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $rep_id = Yii::app()->user->id;        
            
            $mynotes = Yii::app()->db->createCommand() //this query contains all the data
             ->select('rn.message,rn.created_at,ru.NOM_UTILISATEUR,ru.NOM_TABLE,ru.ID_RELATION')
             ->from(array('rep_notes rn', 'repertoire_utilisateurs ru'))
             ->where("rn.ID_UTILISATEUR=ru.ID_UTILISATEUR AND ru.status=1 AND (ru.NOM_TABLE='Professionnels' OR ru.NOM_TABLE='Detaillants') AND rn.rep_credential_id =" . $rep_id)
             ->order('rn.id desc')
             ->queryAll();

           
            // Get total counts of records    
            $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
            ->select('count(*) as count')
            ->from(array('rep_notes rn', 'repertoire_utilisateurs ru'))
            ->where("rn.ID_UTILISATEUR=ru.ID_UTILISATEUR AND ru.status=1 AND (ru.NOM_TABLE='Professionnels' OR ru.NOM_TABLE='Detaillants') AND rn.rep_credential_id =" . $rep_id)
            ->queryScalar(); // do not LIMIT it, this must count all items!
          
            // results per page
            $pages = new CPagination($item_count);
            $pages->setPageSize(LISTPERPAGE);

            $this->render('index', array(
                'model' => $mynotes,
                'pages' => $pages,
            ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RepNotes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=RepNotes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RepNotes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rep-notes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
