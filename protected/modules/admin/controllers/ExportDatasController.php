<?php

class ExportDatasController extends Controller
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
				'actions'=>array('index','create','delete'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            
            Yii::import('ext.ECSVExport');
            $attach_path = Yii::getPathOfAlias('webroot').'/'.EXPORTDATAS;                    
            
            $model=new ExportDatas;

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['ExportDatas']))
            {
                $query_str = "";
                
                $model->attributes=$_POST['ExportDatas'];

                $lang_en = $_POST['ExportDatas']['EN'];
                $lang_fr = $_POST['ExportDatas']['FR'];
                
                $sub_optipromo = $_POST['ExportDatas']['Optipromo'];
                $sub_optinews  = $_POST['ExportDatas']['Optinews'];
                $sub_envision_print   =  $_POST['ExportDatas']['Envision_print'];
                $sub_envision_digital =  $_POST['ExportDatas']['Envision_digital'];
                $sub_envue_print   =  $_POST['ExportDatas']['Envue_print'];
                $sub_envue_digital =  $_POST['ExportDatas']['Envue_digital'];
                
                
                
                $provinces = $_POST['ExportDatas']['province'];
//                        (
//                            [0] => 125
//                            [1] => 1
//                        )

                $professional_type = $_POST['ExportDatas']['professional_type'];
//                        (
//                            [0] => 9
//                        )

                $export_type = $_POST['ExportDatas']['export_type'];
               
                
                //$dati = Yii::app()->db->createCommand("SELECT ID_CLIENT,COMPAGNIE FROM repertoire_retailer LIMIT 0,10");
                 // Get all records list  with limit
                $prof_result = Yii::app()->db->createCommand(
                        "SELECT USR , PWD , LANGUE , NOM , PRENOM , TYPE_SPECIALISTE_EN ,  NOM_VILLE ,  NOM_REGION_EN , ABREVIATION_EN ,  NOM_PAYS_EN 
                         FROM  repertoire_specialiste as rs, repertoire_specialiste_type as rst, repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
                         WHERE rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Professionnels'
                         ORDER BY NOM");             
                
                 // File name and path
                $randstr  = Myclass::getRandomString(4);
                $filename = "Professional_data_".date("Y_m_d")."_".$randstr.".csv";                
                $outputFile_path = $attach_path.$filename;
                
                // Export as csv file
                $this->Exceldownload($prof_result,$outputFile_path);

                $model->attachment_file = $filename;
                $model->user_type = "Professional";

                if($model->save()){
                        Yii::app()->user->setFlash('success', 'Export Datas Created Successfully!!!');
                        $this->redirect(array('index'));
                }
            }

            $this->render('_form',array(
                    'model'=>$model,
            ));
	}
        
        
        public function Exceldownload($prof_result , $outputFile)
        {           
            Yii::import('ext.ECSVExport');           
            $csv = new ECSVExport($prof_result);
            $csv->convertActiveDataProvider=false;
            $csv->setOutputFile($outputFile);
            $output = $csv->toCSV();               
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
                    Yii::app()->user->setFlash('success', 'ExportDatas Deleted Successfully!!!');
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model=new ExportDatas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ExportDatas']))
			$model->attributes=$_GET['ExportDatas'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ExportDatas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ExportDatas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ExportDatas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='export-datas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
