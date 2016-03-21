<?php

class ClientProfilesController extends Controller {
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
    
    public function behaviors() {
        return array(
            'exportableGrid' => array(
                'class' => 'application.components.ExportableGridBehavior',
                'filename' => "Clients_" . time() . ".csv",
//                'csvDelimiter' => ',', //i.e. Excel friendly csv delimiter
        ));
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
                'actions' => array('index', 'view', 'create', 'update', 'getcategories', 'delete','getmessage', 'updateMessage'),
                'users' => array('@'),
                 'expression'=> 'AdminIdentity::checkAccess()',
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
    
     public function actionUpdateMessage() {
        $message_id = $_GET['message_id'];
        $message_id_array = explode('_', $message_id);

        $model = ClientMessages::model()->findByPk($message_id_array[1]);
        $model->scenario = 'update';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ClientMessages'])) {
            $model->attributes = $_POST['ClientMessages'];

            //save attachment
            $model->afile = CUploadedFile::getInstance($model, 'afile');
            if ($model->afile) {
                $filename = time() . '_' . $model->afile->name;
                $model->alertfile = $filename;
                $attach_path = Yii::getPathOfAlias('webroot') . '/' . ATTACH_PATH . '/';
                if (!is_dir($attach_path)) {
                    mkdir($attach_path, 0777, true);
                }
                $model->afile->saveAs($attach_path . $filename);
            }
            
             if ($model->date_remember != '' && $model->employee_id != '' && $model->message != '') 
            {
                $model->date_remember = date("Y-m-d", strtotime($_POST['ClientMessages']['date_remember']));    
                $model->save();
                
                Yii::app()->user->setFlash('success', 'Alert Message Updated Successfully!!!');               
            }else{
                Yii::app()->user->setFlash('danger', Myclass::t("OG200"));
            } 
            
            $this->redirect(array('update', 'id' => $model->client_id));
            
        }

        $this->renderPartial('update_message', array('model' => $model), false, true);
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

    public function actionGetcategories() {
        $val = "";
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        
         $filter_ajax = isset($_POST['filter_ajax']) ? $_POST['filter_ajax'] : '';
        
         if($filter_ajax=="yes")
          $val = "<option value=''>Choisissez une Catégorie Nom</option>";
         
        if ($id != '') {
            $data_cats = CHtml::listData(ClientCategory::model()->findAll(array("order" => "category asc", "condition" => "cat_type_id=" . $id)), 'category', 'cat_name');           
            foreach ($data_cats as $k => $info) {
                $val .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $val;
        exit;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model  = new ClientProfiles;
        $cmodel = new ClientMessages;
        
        $selected_sections = array();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
       
        if (isset($_POST['ClientProfiles'])) {
            $model->attributes = $_POST['ClientProfiles'];
            
//            $cat_vals = implode(',',$_POST['ClientProfiles']['category']);
//            $model->category = $cat_vals;
            $model->created_date  = date('Y-m-d H:i:s', time());
            $model->modified_date = date('Y-m-d H:i:s', time());
            $model->ID_CLIENT     = Myclass::getRandomNUmbers();
            
            if ($model->save()) {    
                
                $clientid = $model->client_id;
                
                $catvals = $_POST['ClientProfiles']['category'];
                foreach($catvals as $cinfo)
                {
                    $catmap_model = new ClientCatMapping();
                    $catmap_model->client_id   = $clientid;
                    $catmap_model->cat_type_id = $_POST['ClientProfiles']['cat_type_id'];
                    $catmap_model->category    =  $cinfo;
                    $catmap_model->save();
                }    
                
                // save the alert message         
                if (isset($_POST['ClientMessages'])) 
                {  
                    $cmodel->attributes    = $_POST['ClientMessages'];
                    $cmodel->client_id     = $model->client_id;
                    $cmodel->date_remember = date("Y-m-d", strtotime($_POST['ClientMessages']['date_remember']));
                    $cmodel->created_date  = date("Y-m-d");
                    $cmodel->randkey       = Myclass::getGuid();
                    //save attachment
                    $cmodel->afile = CUploadedFile::getInstance($cmodel,'afile');                   
                    if($cmodel->afile)
                    { 
                        $filename = time() . '_' . $cmodel->afile->name;                    
                        $cmodel->alertfile = $filename;
                        $attach_path = Yii::getPathOfAlias('webroot').'/'.ATTACH_PATH.'/';                    
                        if (!is_dir($attach_path)) {
                            mkdir($attach_path, 0777, true);
                        }
                        $cmodel->afile->saveAs($attach_path . $filename);
                    }                        
                    
                    if($cmodel->date_remember!='' && $cmodel->employee_id!='' && $cmodel->message!='')
                    {     
                        $cmodel->save();
                    }                   
                }
                
                Yii::app()->user->setFlash('success', 'Client profile created successfully!!!');
                $this->redirect(array('index'));
            }  
        }
   
        $this->render('create', array(
            'model' => $model,
            'cmodel' => $cmodel,   
            'selected_sections' => $selected_sections
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $cmodel = new ClientMessages;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        
        if (isset($_POST['ClientProfiles'])) {

            $model->attributes = $_POST['ClientProfiles'];
            if ($model->validate()) {
            $cat_vals = implode(',',$_POST['ClientProfiles']['category']);
            $model->category = $cat_vals;
            $model->modified_date = date('Y-m-d H:i:s', time());

            if(isset($_POST['modified-profile'])){
                    $model->save(false);
                    
                    $client_id = $model->client_id;  
                    ClientCatMapping::model()->deleteAll("client_id ='" .$client_id. "'");
                    
                    $catvals = $_POST['ClientProfiles']['category'];
                    foreach($catvals as $cinfo)
                    {
                        $catmap_model = new ClientCatMapping();
                        $catmap_model->client_id   = $client_id;
                        $catmap_model->cat_type_id = $_POST['ClientProfiles']['cat_type_id'];
                        $catmap_model->category    =  $cinfo;
                        $catmap_model->save();
                    }    
                    
                    Yii::app()->user->setFlash('success', 'Client profile updated successfully!!!');
                    $this->redirect(array('update', "id" => $id));
                }
                 // save the alert message         
                if (isset($_POST['ClientMessages'])) 
                {  
                    $cmodel->attributes    = $_POST['ClientMessages'];
                    $cmodel->client_id     = $model->client_id;                   
                    $cmodel->created_date  = date("Y-m-d");
                    $cmodel->randkey       = Myclass::getGuid();
                    //save attachment
                    $cmodel->afile = CUploadedFile::getInstance($cmodel,'afile');                   
                    if($cmodel->afile)
                    { 
                        $filename = time() . '_' . $cmodel->afile->name;                    
                        $cmodel->alertfile = $filename;
                        $attach_path = Yii::getPathOfAlias('webroot').'/'.ATTACH_PATH.'/';                    
                        if (!is_dir($attach_path)) {
                            mkdir($attach_path, 0777, true);
                        }
                        $cmodel->afile->saveAs($attach_path . $filename);
                    }      
                    
                    if($cmodel->date_remember!='' && $cmodel->employee_id!='' && $cmodel->message!='')
                    {     
                        $cmodel->date_remember = date("Y-m-d", strtotime($_POST['ClientMessages']['date_remember']));
                        $cmodel->save();
                        Yii::app()->user->setFlash('success', 'Alarme correctement mis à jour !!!');
                    }else{
                        Yii::app()->user->setFlash('danger', Myclass::t("OG200"));
                    }   
                    $this->redirect(array('update', "id" => $id));
                }
                
            }
        }
        
        // Get the alert history for the client
        $cmodel = new ClientMessages('search_client');
        $cexpiremodel  = $cmodel->search_expirealerts($id);
        $ccurrentmodel = $cmodel->search_currentalerts($id);
        
        $selected_sections = array();
        
        $client_id = $model->client_id;  
        $client_catinfos = ClientCatMapping::model()->findAll("client_id=".$client_id);
        
        if($client_catinfos!='')
        {               
            foreach($client_catinfos as $catinfo)
            {
                $pubcatid = $catinfo->category;             
                $selected_sections[$pubcatid]['selected'] =  'selected';     
                $cattypeid = $catinfo->cat_type_id; 
            }   
            $model->cat_type_id = $cattypeid;
        } 

        $this->render('update', array(
            'model'  => $model,
            'cmodel' => $cmodel,
            'cexpiremodel'  => $cexpiremodel,
            'ccurrentmodel' => $ccurrentmodel,
            'selected_sections' => $selected_sections
        ));
    }
    
    public function actionGetmessage()
    {
        $messageid = $_POST['id'];
        $message_info = ClientMessages::model()->findByPk($messageid);
        $return_str = $message_info->message;
        echo  $return_str;
        exit;
    }        
    
     //called on rendering the column for each row 
    protected function gridDataColumn($data, $row) {

        $message_id = $data->message_id;
        $linkval = "<a href='javascript:void(0)' data-target='#products-disp-modal' style='text-align:center;' data-toggle='modal' class='popupmessage' id=" . $message_id . "><i class='glyphicon glyphicon-eye-open'></i></a>";
        return $linkval;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Client profiles deleted successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
      
        $model = new ClientProfiles('search');
        
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ClientProfiles']))
            $model->attributes = $_GET['ClientProfiles'];
        
        
//        if ($this->isExportRequest()) {
//            $model->unsetAttributes();
//            $this->exportCSV(array('Client Accounts:'), null, false);
//            $this->exportCSV($model->search(), array('name', 'company', 'address', 'country'));
//        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ClientProfiles the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ClientProfiles::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ClientProfiles $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === 'client-profiles-form'  || $_POST['ajax'] === 'client-message-form')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
