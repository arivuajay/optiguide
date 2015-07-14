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
                    $msg = Myclass::t('APP41').' '.Myclass::t('APP501');
                    Yii::app()->user->setFlash('success',$msg );
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
        $options = "<option value=''>".Myclass::t('APP44')."</option>";
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
                $msg = Myclass::t('APP41').' '.Myclass::t('APP502');
                Yii::app()->user->setFlash('success',$msg );
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
            $msg = Myclass::t('APP41').' '.Myclass::t('APP503');
            Yii::app()->user->setFlash('success',$msg );
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }
    

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new CityDirectory;

        $regid = isset($_POST['CityDirectory']['ID_REGION']) ? $_POST['CityDirectory']['ID_REGION'] : '';
        $cityname = isset($_POST['CityDirectory']['NOM_VILLE']) ? $_POST['CityDirectory']['NOM_VILLE'] : '';

        $criteria = new CDbCriteria();
        $criteria->order = 'NOM_REGION_FR ASC';
        
        /* get the search params*/
        $ctyname = Yii::app()->getRequest()->getQuery('ctyname');
       
        if ($regid != '')
        {
            $criteria->condition = "t.ID_REGION=:col_val";
            $criteria->params = array(':col_val' => $regid);
             $data['regid'] = $regid;
        }

        if ($cityname != '') 
        {
            $criteria->compare('cityDirectory.NOM_VILLE', $cityname, true);
            $criteria->together = true;
            $data['ctyname'] = $cityname;
        }elseif($ctyname!='')
        {               
            $criteria->compare('cityDirectory.NOM_VILLE', $ctyname, true);
            $criteria->together = true;
            $data['ctyname'] = $ctyname;
        }  
        
       // $count = RegionDirectory::model()->with('cityDirectory')->count($criteria);
        $rescnt =RegionDirectory::model()->with('cityDirectory')->findAll($criteria);
        $count = count($rescnt);
 
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;    
        if ($regid != '') 
        {
               $pages->params   = array('regid' => $regid );
        }
        
        if ($cityname != '' ) 
        {
               $pages->params   = array('ctyname' => $cityname );
        }elseif($ctyname!='')
        {
               $pages->params   = array('ctyname' => $ctyname );            
        }    
         
       // $pages->pageVar='page';
        $pages->applyLimit($criteria);
        
        //
        $models = RegionDirectory::model()->with('cityDirectory')->findAll($criteria);
       
        $this->render('index', array(
            'models' => $models,
            'postinfo' => $data,
            'pages' => $pages,
            'Rmodel' => $model
        ));
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
                throw new CHttpException(404,Myclass::t('APP506'));
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