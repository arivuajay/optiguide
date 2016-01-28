<?php

class UserDirectoryController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new UserDirectory;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        $relid    = Yii::app()->getRequest()->getQuery('relid');
        $nomtable = Yii::app()->getRequest()->getQuery('nomtable');
        
        $userslist_query = array();
        $namestr         = '';
       
    
        if (isset($_POST['UserDirectory'])) {

            $GUID = Myclass::getGuid();
            $guid_val = trim($GUID, "{}");

            $model->attributes  = $_POST['UserDirectory'];
            if($model->NOM_TABLE=='')
            {    
             $model->NOM_TABLE   = "NA";
             $model->ID_RELATION = 0;
            }            
            $model->sGuid       = $guid_val;
            if ($model->save()) {
                
                Yii::app()->user->setFlash('success', 'L\'accès de l\'utilisateur créé avec succès!!!');
                $mail = new Sendmail();
                $lang = "FR";
                $subject = 'OptiGuide- your account details';
                
                $nextstep_url = GUIDEURL . 'optiguide/';
                $trans_array = array(
                    "{NAME}" => $model->NOM_UTILISATEUR,
                    "{subscription_name}" => $model->NOM_TABLE,
                    "{username}"=>$model->USR,
                    "{password}"=>$model->PWD,
                    "{NEXTSTEPURL}" => $nextstep_url,
                );
                $message = $mail->getMessage('backend_user_create', $trans_array);
                if($model->COURRIEL!=''){
                    $mail->send($model->COURRIEL, $subject, $message);
                }
                
                $edituserlink =  '/admin/userDirectory/update';
                $uid =  $model->ID_UTILISATEUR; 
                $this->redirect(array($edituserlink,"id"=>$uid));
               // $this->redirect(array('index'));
            }
        }
        
        if(is_numeric($relid) &&  $nomtable!='')
        {    
         // Get all user records list to the realtions
            $userslist_query = Yii::app()->db->createCommand() //this query contains all the data
            ->select('ID_UTILISATEUR , NOM_UTILISATEUR , USR')
            ->from(array('repertoire_utilisateurs'))
            ->where("ID_RELATION='$relid' AND NOM_TABLE='$nomtable'")
            ->order('NOM_UTILISATEUR')
            ->queryAll();     
       
            if($nomtable=="Professionnels")
            {                
                  $result = ProfessionalDirectory::model()->findByPk($relid);      
                  $namestr     = $result->PRENOM.' '.$result->NOM;                  
            }else if($nomtable=="Detaillants"){
                
                  $result = RetailerDirectory::model()->findByPk($relid);                     
                  $namestr = $result->COMPAGNIE;               
            }else if($nomtable=="Fournisseurs"){
                
                  $result = SuppliersDirectory::model()->findByPk($relid);                     
                  $namestr = $result->COMPAGNIE;               
            }     
            
                  $model->USR   = $result->ID_CLIENT;
                  $model->PWD  = $result->CODE_POSTAL;
            
        } 
        
        $this->render('create',  compact('userslist_query','model','relid','namestr','nomtable'));
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
        
        //$relid    = Yii::app()->getRequest()->getQuery('relid');
        //$nomtable = Yii::app()->getRequest()->getQuery('nomtable');
        
        $nomtable = $model->NOM_TABLE;
        $relid    = $model->ID_RELATION;
       
        
        $userslist_query = array();
         $namestr        = '';
         
        if(is_numeric($relid) &&  $nomtable!='')
        {    
         // Get all user records list to the realtions
            $userslist_query = Yii::app()->db->createCommand() //this query contains all the data
            ->select('ID_UTILISATEUR , NOM_UTILISATEUR , USR')
            ->from(array('repertoire_utilisateurs'))
            ->where("ID_RELATION='$relid' AND NOM_TABLE='$nomtable'")
            ->order('NOM_UTILISATEUR')
            ->queryAll(); 
            
             if($nomtable=="Professionnels")
            {                
                  $prof_result = ProfessionalDirectory::model()->findByPk($relid);      
                  $namestr = $prof_result->PRENOM.' '.$prof_result->NOM;     
                  
            }else if($nomtable=="Detaillants"){
                
                  $retail_result = RetailerDirectory::model()->findByPk($relid);                     
                  $namestr = $retail_result->COMPAGNIE;  
            }else if($nomtable=="Fournisseurs"){
                
                  $result = SuppliersDirectory::model()->findByPk($relid);                     
                  $namestr = $result->COMPAGNIE;               
            }    
        } 

        if (isset($_POST['UserDirectory'])) {
            $model->attributes = $_POST['UserDirectory'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'L\'accès de l\'utilisateur à jour avec succès!!!');
                //$this->redirect(array('index'));
                $edituserlink =  '/admin/userDirectory/update';
                $uid =  $model->ID_UTILISATEUR; 
                $this->redirect(array($edituserlink,"id"=>$uid));
            }
        }

        $this->render('update', compact('userslist_query','model','relid','namestr'));
    }   

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new UserDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserDirectory']))
            $model->attributes = $_GET['UserDirectory'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new UserDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserDirectory']))
            $model->attributes = $_GET['UserDirectory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UserDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UserDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-directory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
