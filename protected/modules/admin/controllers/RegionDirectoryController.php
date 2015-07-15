<?php

class RegionDirectoryController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'create', 'update', 'admin'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new RegionDirectory;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['RegionDirectory'])) {
            $model->attributes = $_POST['RegionDirectory'];

            if ($model->save()) {
                $msg = Myclass::t('APP106') . ' ' . Myclass::t('APP501');
                Yii::app()->user->setFlash('success', $msg);
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['RegionDirectory'])) {
            $model->attributes = $_POST['RegionDirectory'];

            if ($model->save()) {
                $msg = Myclass::t('APP106') . ' ' . Myclass::t('APP502');
                Yii::app()->user->setFlash('success', $msg);
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new RegionDirectory;

        /* POst values of search */
        $cntryid    = isset($_POST['RegionDirectory']['ID_PAYS']) ? $_POST['RegionDirectory']['ID_PAYS'] : '';
        $regionname = isset($_POST['RegionDirectory']['NOM_REGION_FR']) ? $_POST['RegionDirectory']['NOM_REGION_FR'] : '';

        $criteria = new CDbCriteria();
        $criteria->order = 'NOM_PAYS_FR ASC';
        
        /* get the search params from url*/
        $regname = Yii::app()->getRequest()->getQuery('regname');
       
        if ($cntryid != '')
        {
            $data['cntryid'] = $cntryid;
            $criteria->condition = "t.ID_PAYS=:col_val";
            $criteria->params    = array(':col_val' => $cntryid);
        }

        if ($regionname != '') 
        {
            $data['regname'] = $regionname;    
            $criteria->compare('repertoireRegions.NOM_REGION_FR', $regionname, true);
            $criteria->together = true;            
        }elseif($regname!='')
        {    
            $data['regname'] = $regname;
            $criteria->compare('repertoireRegions.NOM_REGION_FR', $regname, true);
            $criteria->together = true;    
        }  
        
        $count = CountryDirectory::model()->with('repertoireRegions')->count($criteria);
       
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;    
        if ($cntryid != '') 
        {
            $pages->params   = array('cntryid' => $cntryid );
        }
        
        if ($regionname != '' ) 
        {
            $pages->params   = array('regname' => $regionname );
        }elseif($regname!='')
        {
            $pages->params   = array('regname' => $regname );            
        }    
         
        $pages->applyLimit($criteria);
  
        $models = CountryDirectory::model()->with('repertoireRegions')->findAll($criteria);
        
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
    public function actionAdmin() {
        $model = new RegionDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegionDirectory']))
            $model->attributes = $_GET['RegionDirectory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RegionDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RegionDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RegionDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'region-directory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
