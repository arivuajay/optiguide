<?php

class SupplierSubscriptionPriceController extends Controller
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
				'actions'=>array('index','update','statsprice'),
				'users'=>array('@'),
                                'expression'=> 'AdminIdentity::checkAccess()',
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['SupplierSubscriptionPrice']))
		{
			$model->attributes=$_POST['SupplierSubscriptionPrice'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', 'Prix ​​de souscription correctement mis à jour!!!');
                                
                                if($_POST['disp_type'] ==  'stats')
                                {
                                    $this->redirect(array('statsprice'));
                                }else{    
                                    $this->redirect(array('index'));
                                }                               
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model=new SupplierSubscriptionPrice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupplierSubscriptionPrice']))
			$model->attributes=$_GET['SupplierSubscriptionPrice'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        public function actionStatsprice()
	{
            $model=new SupplierSubscriptionPrice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupplierSubscriptionPrice']))
			$model->attributes=$_GET['SupplierSubscriptionPrice'];

		$this->render('statsprice',array(
			'model'=>$model,
		));
	}
        
        

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SupplierSubscriptionPrice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupplierSubscriptionPrice']))
			$model->attributes=$_GET['SupplierSubscriptionPrice'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SupplierSubscriptionPrice the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SupplierSubscriptionPrice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SupplierSubscriptionPrice $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='supplier-subscription-price-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
