<?php
class ClientProfilesController extends OGController {
    
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $lang;

    public function __construct($id, $module = null) {

        if (Yii::app()->session['language']) {
            $lang = Yii::app()->session['language'];
        } else {
            $lang = "EN";
        }

        $this->lang = $lang;

        parent::__construct($id, $module);
    }

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
           parent::accessRules(), array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array(''),
                    'users' => array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                     'actions' => array('update', 'getcategories'),
                    'users' => array('@'),
                ),           
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            )
        );
    }
    
    
    public function actionGetcategories() {
        $val = "";
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        
         $filter_ajax = isset($_POST['filter_ajax']) ? $_POST['filter_ajax'] : '';
        
         if($filter_ajax=="yes")
         $val = "<option value=''>".Myclass::t('OG242')."</option>";
         
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        
        $client_id = Yii::app()->user->id;
        $model = $this->loadModel($client_id);
       
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);        
        
        if (isset($_POST['ClientProfiles'])) {

            $model->attributes = $_POST['ClientProfiles'];
            if ($model->validate()) 
            {
                $cat_vals = implode(',',$_POST['ClientProfiles']['category']);
                $model->category = $cat_vals;
                $model->modified_date = date("Y-m-d H:i:s",time());
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
                
                $this->lang = Yii::app()->session['language'];
                /* Send mail to admin for confirmation */
                $mail = new Sendmail();
                $retailer_url = ADMIN_URL . 'admin/clientProfiles/update/id/' . $model->client_id;
                $enc_url = Myclass::refencryption($retailer_url);
                $nextstep_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;
                
                if($this->lang=='EN' ){
                    $subject = SITENAME . " - Notification for update client profile - " . $model->name;
                }elseif($this->lang=='FR'){
                    $subject = SITENAME . " - Notification pour le profil client de mise à jour";
                }
                $trans_array = array(
                    "{NAME}" => $model->name,
                    "{UTYPE}" => 'client',
                    "{NEXTSTEPURL}" => $nextstep_url,
                );
                $message = $mail->getMessage('profile_update', $trans_array);
                $mail->send(ADMIN_EMAIL, $subject, $message);
                
                Yii::app()->user->setFlash('success', Myclass::t('APP20'));
                $this->redirect(array('update'));               
                
            }
        }
        
        $selected_sections = array();
        
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
            'selected_sections' => $selected_sections
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
        if (isset($_POST['ajax']) && ($_POST['ajax'] === 'client-profiles-form')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
