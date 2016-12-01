<?php

class RetailerDirectoryController extends Controller {
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
        return array_merge(
                
           parent::accessRules(), 
            array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array(''),
                    'users' => array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'getgroups','getmessage','deleteMessage', 'updateMessage', 'deleteProof'),
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
             )
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
    
    public function actionUpdateMessage() {
        $message_id = $_GET['message_id'];
        $message_id_array = explode('_', $message_id);

        $model = RetailerMessages::model()->findByPk($message_id_array[1]);
        $model->scenario = 'update';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['RetailerMessages'])) {
            $model->attributes = $_POST['RetailerMessages'];

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
                $model->date_remember = date("Y-m-d", strtotime($_POST['RetailerMessages']['date_remember']));    
                $model->save();
                
                Yii::app()->user->setFlash('success', 'Alert Message Updated Successfully!!!');               
            }else{
                Yii::app()->user->setFlash('danger', Myclass::t("OG200"));
            } 
            
            $this->redirect(array('update', 'id' => $model->ID_RETAILER));
            
        }

        $this->renderPartial('update_message', array('model' => $model), false, true);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model   = new RetailerDirectory('backend');
        $rmodel  = new RetailerMessages;
       // $umodel = new UserDirectory();

        $this->performAjaxValidation(array($model));

        if (isset($_POST['RetailerDirectory'])) {
            $model->attributes = $_POST['RetailerDirectory'];
            $model->image=CUploadedFile::getInstance($model,'image');
            $model->pfile = CUploadedFile::getInstance($model,'pfile');
           // $umodel->attributes = $_POST['UserDirectory'];
     
          //  $model->ID_CLIENT = $umodel->USR;

          //  $umodel->NOM_TABLE = $model::$NOM_TABLE;
         //   $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;
         //   $umodel->PWD     = Myclass::getRandomString(5);
        //    $umodel->sGuid   = Myclass::getGuid();
        //    $umodel->LANGUE  = "FR";          
            
        //    $valid = $umodel->validate();
        //    $valid = $model->validate() && $valid;

            if ($model->validate()) {
                
                $address = $model->ADRESSE;
                $country = $model->country;
                $region  = $model->region;
                
                if ($model->ID_VILLE == "-1") {
                    $regionid = $model->region;
                    $othercity = $model->autre_ville;
                    $condition = 'ID_REGION="'.$regionid.'" and NOM_VILLE="'.$othercity.'"';
                    $city_exist = CityDirectory::model()->find($condition);
                    if (!empty($city_exist)) {
                        $model->ID_VILLE = $city_exist->ID_VILLE;
                    } else {
                        $cinfo = new CityDirectory;
                        $cinfo->ID_REGION = $regionid;
                        $cinfo->NOM_VILLE = $othercity;
                        $cinfo->country = $model->country;
                        $cinfo->save(false);
                        $model->ID_VILLE = $cinfo->ID_VILLE;
                    }
                }
                $cty     = $model->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if($geo_values!='')
                {
                    $exp_latlong = explode('~',$geo_values);
                    $model->map_lat  = $exp_latlong[0];
                    $model->map_long = $exp_latlong[1];        
                }   
                
                // save retailer logo
                if($model->image)
                {   
                    $imgname = time() . '_' . $model->image->name;                    
                    $model->FICHIER = $imgname;
                    $ret_img_path = Yii::getPathOfAlias('webroot').'/'.RET_IMG_PATH.'/';                    
                    if (!is_dir($ret_img_path)) {
                        mkdir($ret_img_path, 0777, true);
                    }
                    $model->image->saveAs($ret_img_path . $imgname);
                }  
                
                 // save proof file
                if($model->pfile)
                {   
                    $filename = time() . '_' . $model->pfile->name;                    
                    $model->proof_file = $filename;
                    $proof_path = Yii::getPathOfAlias('webroot').'/'.PROOF_PATH.'/';                    
                    if (!is_dir($proof_path)) {
                        mkdir($proof_path, 0777, true);
                    }
                    $model->pfile->saveAs($proof_path . $filename);
                }   
                $model->CREATED_DATE = date('Y-m-d H:i:s', time());
                $model->DATE_MODIFICATION = date('Y-m-d H:i:s', time());
                $model->save(false);
               // $umodel->ID_RELATION = $model->ID_RETAILER;
              //  $umodel->save(false);
                
                 // save the alert message         
                if (isset($_POST['RetailerMessages'])) 
                {  
                    $rmodel->attributes     = $_POST['RetailerMessages'];
                    $rmodel->ID_RETAILER    = $model->ID_RETAILER;
                    $rmodel->message        = nl2br($_POST['RetailerMessages']['message']);
                   
                    $rmodel->created_date   = date("Y-m-d");
                    $rmodel->randkey        = Myclass::getGuid();
                    //save attachment
                    $rmodel->afile = CUploadedFile::getInstance($rmodel,'afile');      
                    if($rmodel->afile)
                    { 
                        $filename = time() . '_' . $rmodel->afile->name;                    
                        $rmodel->alertfile = $filename;
                        $attach_path = Yii::getPathOfAlias('webroot').'/'.ATTACH_PATH.'/';                    
                        if (!is_dir($attach_path)) {
                            mkdir($attach_path, 0777, true);
                        }
                        $rmodel->afile->saveAs($attach_path . $filename);
                    } 
                    
                    if($rmodel->date_remember!='' && $rmodel->employee_id!='' && $rmodel->message!='')
                    {     
                        $rmodel->save();
                    }                   
                }

                Yii::app()->user->setFlash('success', 'Détaillant créé avec succès!!!');
                $this->redirect(array('index'));
            } else {
               // var_dump($model->errors);
               //  var_dump($umodel->errors);
            }
        }

        $this->render('create', compact('model','rmodel'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'backend';
        $rmodel  = new RetailerMessages;
      //  $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));
        
        if (isset($_POST['RetailerDirectory'])) {
            $model->attributes = $_POST['RetailerDirectory'];
             $model->image=CUploadedFile::getInstance($model,'image');
             $model->pfile = CUploadedFile::getInstance($model,'pfile');
         //   $umodel->attributes = $_POST['UserDirectory'];
        //    $umodel->NOM_TABLE = $model::$NOM_TABLE;
       //     $umodel->NOM_UTILISATEUR = $model->COMPAGNIE;

       //     $valid = $umodel->validate();
       //     $valid = $model->validate() && $valid;

            if ($model->validate()) {
                
                $address = $model->ADRESSE;
                $country = $model->country;
                $region  = $model->region;
                if ($model->ID_VILLE == "-1") {
                    $regionid = $model->region;
                    $othercity = $model->autre_ville;
                    $condition = 'ID_REGION="'.$regionid.'" and NOM_VILLE="'.$othercity.'"';
                    $city_exist = CityDirectory::model()->find($condition);
                    if (!empty($city_exist)) {
                        $model->ID_VILLE = $city_exist->ID_VILLE;
                    } else {
                        $cinfo = new CityDirectory;
                        $cinfo->ID_REGION = $regionid;
                        $cinfo->NOM_VILLE = $othercity;
                        $cinfo->country = $model->country;
                        $cinfo->save(false);
                        $model->ID_VILLE = $cinfo->ID_VILLE;
                    }
                }
                $cty     = $model->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if($geo_values!='')
                {
                    $exp_latlong = explode('~',$geo_values);
                    $model->map_lat  = $exp_latlong[0];
                    $model->map_long = $exp_latlong[1];        
                }  
                
                // save retailer logo
                if($model->image)
                {   
                    $imgname = time() . '_' . $model->image->name;                    
                    $model->FICHIER = $imgname;
                    $ret_img_path = Yii::getPathOfAlias('webroot').'/'.RET_IMG_PATH.'/';                    
                    if (!is_dir($ret_img_path)) {
                        mkdir($ret_img_path, 0777, true);
                    }
                    $model->image->saveAs($ret_img_path . $imgname);
                }  
                
                 // save proof file
                if($model->pfile)
                { 
                    $filename = time() . '_' . $model->pfile->name;                    
                    $model->proof_file = $filename;
                    $proof_path = Yii::getPathOfAlias('webroot').'/'.PROOF_PATH.'/';                    
                    if (!is_dir($proof_path)) {
                        mkdir($proof_path, 0777, true);
                    }
                    $model->pfile->saveAs($proof_path . $filename);
                }   
                
             //   $umodel->save(false);
                if(isset($_POST['modified-retailer'])){
                    $model->DATE_MODIFICATION = date('Y-m-d H:i:s', time());
                    $model->save();
                    Yii::app()->user->setFlash('success', 'Détaillant correctement mis à jour!!!');
                    $this->redirect(array('update',"id"=>$id));
                }
                  // save the alert message         
                if (isset($_POST['RetailerMessages'])) 
                {  
                    $rmodel->attributes     = $_POST['RetailerMessages'];
                    $rmodel->ID_RETAILER    = $model->ID_RETAILER;
                    $rmodel->message        = nl2br($_POST['RetailerMessages']['message']);                  
                    $rmodel->created_date   = date("Y-m-d");
                    $rmodel->randkey        = Myclass::getGuid();
                     //save attachment
                    $rmodel->afile = CUploadedFile::getInstance($rmodel,'afile');                   
                    if($rmodel->afile)
                    { 
                        $filename = time() . '_' . $rmodel->afile->name;                    
                        $rmodel->alertfile = $filename;
                        $attach_path = Yii::getPathOfAlias('webroot').'/'.ATTACH_PATH.'/';                    
                        if (!is_dir($attach_path)) {
                            mkdir($attach_path, 0777, true);
                        }
                        $rmodel->afile->saveAs($attach_path . $filename);
                    }    
                    
                    if($rmodel->date_remember!='' && $rmodel->employee_id!='' && $rmodel->message!='')
                    {     
                        $rmodel->date_remember  = date("Y-m-d", strtotime($_POST['RetailerMessages']['date_remember']));
                        $rmodel->save();
                        Yii::app()->user->setFlash('success', 'Alarme correctement mis à jour !!!');
                    }else{
                        Yii::app()->user->setFlash('danger', Myclass::t("OG200"));
                    }                   
                }
                
//                Yii::app()->user->setFlash('success', 'Détaillant correctement mis à jour!!!');
                $this->redirect(array('update',"id"=>$id));
            }
        }
        
          // Get the alert history for the client
        $rmodel = new RetailerMessages('search');      
        $rexpiremodel  = $rmodel->search_expirealerts($id);
        $rcurrentmodel = $rmodel->search_currentalerts($id);

        $this->render('update', compact( 'model','rmodel','rexpiremodel','rcurrentmodel'));
    }
    
    
     public function actionGetmessage()
    {
        $messageid = $_POST['id'];
        $message_info = RetailerMessages::model()->findByPk($messageid);
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
        
        $user=UserDirectory::model()->find('ID_RELATION=:id_relation AND NOM_TABLE=:nom_table',array(':id_relation'=>$id,'nom_table'=>'Detaillants') ); 
        $user->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'RetailerDirectory Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }
    
     public function actionDeleteMessage($id) {
        
        RetailerMessages::model()->findByPk($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Message d\'alerte supprimé avec succès!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model  = new RetailerDirectory('search');
      //  $umodel = new UserDirectory();
        
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RetailerDirectory']))
            $model->attributes  = $_GET['RetailerDirectory'];
         //   $umodel->attributes = $_GET['UserDirectory'];

        $this->render('index', array(
            'model' => $model,
          //  'umodel' => $umodel,
        ));
    }

    public function actionGetGroups() {
        $options = '';
        $cid = isset($_POST['id']) ? $_POST['id'] : '';
        $ajxcall = isset($_POST['ajxcall']) ? $_POST['ajxcall'] : '';
        
        if($ajxcall=="")
        {    
            $options = "<option value=''>Sélectionnez le groupe</option>";
        }    
        if ($cid != '') {
            $criteria = new CDbCriteria;
            $criteria->order = 'NOM_GROUPE ASC';
            $criteria->condition = 'ID_RETAILER_TYPE=:id';
            $criteria->params = array(':id' => $cid);
            $data_groups = CHtml::listData(RetailerGroup::model()->findAll($criteria), 'ID_GROUPE', 'NOM_GROUPE');
            foreach ($data_groups as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }
    
    public function actionDeleteProof($id, $file_name) {
        if (Yii::app()->user->role == 'admin') {
            $model = $this->loadModel($id);
            $file_url = dirname(Yii::app()->request->scriptFile) . '/uploads/user_proofs/' . $file_name;
            if (file_exists($file_url)) {
                unlink($file_url);
                $model->proof_file = '';
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Proof file deleted successfully!!!');
                $this->redirect(array('update', 'id' => $id));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new RetailerDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RetailerDirectory']))
            $model->attributes = $_GET['RetailerDirectory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RetailerDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RetailerDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RetailerDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && ( $_POST['ajax'] === 'retailer-directory-form' || $_POST['ajax'] === 'retailer-message-form')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
