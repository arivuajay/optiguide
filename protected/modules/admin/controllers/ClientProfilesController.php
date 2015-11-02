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
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Alert Message Updated Successfully!!!');
                $this->redirect(array('update', 'id' => $model->client_id));
            }
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
        $val = "<option value=''>Select Category</option>";
        $id = isset($_POST['id']) ? $_POST['id'] : '';
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

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
       
        if (isset($_POST['ClientProfiles'])) {
            $model->attributes = $_POST['ClientProfiles'];
            $model->created_date  = date("Y-m-d");
            $model->modified_date = date("Y-m-d");
            if ($model->save()) {                
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
            'cmodel' => $cmodel
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
            $model->modified_date = date("Y-m-d");
            if ($model->save()) {
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
                Yii::app()->user->setFlash('success', 'Client profile updated successfully!!!');
                $this->redirect(array('update',"id"=>$id));
            }
        }
        
        // Get the alert history for the client
        $cmodel = new ClientMessages('search_client');
        $cexpiremodel  = $cmodel->search_expirealerts($id);
        $ccurrentmodel = $cmodel->search_currentalerts($id);

        $this->render('update', array(
            'model'  => $model,
            'cmodel' => $cmodel,
            'cexpiremodel'  => $cexpiremodel,
            'ccurrentmodel' => $ccurrentmodel,
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
