<?php

class CalenderEventController extends Controller
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
		return array_merge(
                
                        parent::accessRules(), 
                        array(
                            array('allow',  // allow all users to perform 'index' and 'view' actions
                                    'actions'=>array(''),
                                    'users'=>array('*'),
                            ),
                            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                    'actions'=>array('index','view','create','update','admin','delete', 'getfichers','getficherimage'),
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
                        )
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
		$model=new CalenderEvent;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['CalenderEvent']))
		{
			$model->attributes=$_POST['CalenderEvent'];
            if ($model->validate()) {
                $this->_createnewlocation($model);
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Événement créé avec succès!!!');
                    $this->redirect(array('index'));
                }
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

    public function _createnewlocation(&$model)
    {
        $postregion = $model->ID_REGION;
        if ($model->ID_REGION == "-1") {
            $paysid = $model->ID_PAYS;
            $otherregion = $model->autre_region;
            $otherregion_abr = $model->autre_region_abr;
            $condition = 'ID_PAYS="' . $paysid . '" and ( NOM_REGION_EN="' . $otherregion . '" || NOM_REGION_FR="' . $otherregion . '" )';
            $region_exist = RegionDirectory::model()->find($condition);
            if (!empty($region_exist)) {
                $model->ID_REGION = $region_exist->ID_REGION;
            } else {
                $rinfo = new RegionDirectory;
                $rinfo->ID_PAYS = $paysid;
                $rinfo->NOM_REGION_EN = $otherregion;
                $rinfo->NOM_REGION_FR = $otherregion;
                $rinfo->ABREVIATION_EN = $otherregion_abr;
                $rinfo->ABREVIATION_FR = $otherregion_abr;
                $rinfo->federal_rates = 0;
                $rinfo->save(false);
                $model->ID_REGION = $rinfo->ID_REGION;
            }
        }

        if ($model->ID_VILLE == "-1" || $postregion == "-1") {
            $regionid = $model->ID_REGION;
            $othercity = $model->autre_ville;
            $condition = 'ID_REGION="' . $regionid . '" and NOM_VILLE="' . $othercity . '"';
            $city_exist = CityDirectory::model()->find($condition);
            if (!empty($city_exist)) {
                $model->ID_VILLE = $city_exist->ID_VILLE;
            } else {
                $cinfo = new CityDirectory;
                $cinfo->ID_REGION = $regionid;
                $cinfo->NOM_VILLE = $othercity;
                $cinfo->country = $model->ID_PAYS;
                $cinfo->save(false);
                $model->ID_VILLE = $cinfo->ID_VILLE;
            }
        }
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

		if(isset($_POST['CalenderEvent']))
		{
            $model->attributes = $_POST['CalenderEvent'];
            if ($model->validate()) {
                $this->_createnewlocation($model);
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Événement correctement mis à jour!!!');
                    $this->redirect(array('index'));
                }
            }else{
                print_r($model->getErrors());
                exit;
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
                    Yii::app()->user->setFlash('success', 'CalenderEvent Deleted Successfully!!!');
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model=new CalenderEvent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CalenderEvent']))
			$model->attributes = $_GET['CalenderEvent'];
                        $model->Year       = $_GET['CalenderEvent']['Year'];
                        $model->keyword    = $_GET['CalenderEvent']['keyword'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CalenderEvent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CalenderEvent']))
			$model->attributes=$_GET['CalenderEvent'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CalenderEvent the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CalenderEvent::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CalenderEvent $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='calender-events-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
