<?php
class CityDirectoryController extends Controller
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
                        'actions'=>array('index','view','create','update','admin','delete','getregions'),
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
        $model=new CityDirectory;

        $data['country'] = Myclass::getallcountries();               
        $data['regions'] = Myclass::getallregions();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['CityDirectory']))
        {
            $model->attributes=$_POST['CityDirectory'];
            if($model->save()){
                    Yii::app()->user->setFlash('success', Myclass::t('APP52'));
                    $this->redirect(array('index'));
            }
        }

        $data['model'] = $model;

        $this->render('create', $data);
    }

    public function actionGetRegions()
    {          
        $options = '';
        $cid     = isset($_POST['id'])?$_POST['id']:'';
        $options = "<option value=''>".Myclass::t('APP53')."</option>";
        if($cid!='')
        {
            $data_regions = Myclass::getallregions($cid);   
            foreach($data_regions as $k => $info)
            {
                $options .= "<option value='".$k."'>".$info."</option>";  
            }    
        }        
        echo $options;
        exit;
    }  



    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $regionid   = $model->ID_REGION;

        $cntry_info = CityDirectory::get_country_info($regionid);

        $cid =  $cntry_info['ID_PAYS'];
        // $cntry_info['NOM_PAYS_EN'];
        $data['cid'] = $cid;

        /* get all countries and regions */    
        $data['country'] = Myclass::getallcountries();               
        $data['regions'] = Myclass::getallregions($cid);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['CityDirectory']))
        {
            $model->attributes=$_POST['CityDirectory'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success', Myclass::t('APP54'));
                $this->redirect(array('index'));
            }
        }

        $data['model'] = $model;

        $this->render('update',$data);
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
        if(!isset($_GET['ajax']))
        {
            Yii::app()->user->setFlash('success', Myclass::t('APP55'));
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }
    

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model=new CityDirectory('search');

        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['CityDirectory']))
            $model->attributes=$_GET['CityDirectory'];

        $data['model'] = $model;

        $this->render('index', $data);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new CityDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CityDirectory']))
                $model->attributes=$_GET['CityDirectory'];

        $this->render('admin',array(
                'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CityDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=CityDirectory::model()->findByPk($id);
        if($model===null)
                throw new CHttpException(404,Myclass::t('APP39'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CityDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='city-directory-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
    }
}