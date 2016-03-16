<?php

class ClientMessagesController extends Controller {
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
                'actions' => array('sendReminder'),
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

    public function actionSendReminder() {
        $mdate = date("Y-m-d", time());
        
        // Client profiles
        $criteria = new CDbCriteria;
        $criteria->condition = "DATE(date_remember)='$mdate' and t.status=1";
        $criteria->with = array(
            "clientProfiles" => array(
                'alias' => 'clientProfiles',
                'select' => 'name'
            ),
            "employeeProfiles" => array(
                'alias' => 'employeeProfiles',
                'select' => 'employee_name,employee_email',
            ),
        );
        $data_meets = ClientMessages::model()->findAll($criteria);

        if (!empty($data_meets)) {
            foreach ($data_meets as $info) {
                
                $meetid = $info->message_id;
                $client_name = $info->clientProfiles->name;
                $randkey = $info->randkey;
                $message = $info->message;
                $employee_email = $info->employeeProfiles->employee_email;
                $employee_name = $info->employeeProfiles->employee_name;
                
                $alertf_name = ($info->alertfile!='')? Yii::getPathOfAlias('webroot').'/'.ATTACH_PATH.'/'.$info->alertfile : '';

                $clientdetail_url = ADMIN_URL . "admin/default/clientprofile/id/" . $randkey;
                $enc_url          = Myclass::refencryption($clientdetail_url);
                $clientdetail_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                /* Send mail to admin for confirmation */
                $mail = new Sendmail();
                $lang = 'FR';
                if($lang=='EN' ){
                    $subject = SITENAME . "- Reminder Mail - Today meet with client " . $client_name;
                }elseif($lang=='FR'){
                    $subject =  SITENAME." - Rappel Mail - Aujourd'hui rencontrer client ". $client_name;
                }
                
                $trans_array = array(
                    "{REMKEY}" => $randkey,
                    "{NAME}" => $client_name,
                    "{MESSAGE}" => $message,
                    "{MDATE}" => $info->date_remember,
                    "{NEXTSTEPURL}" => $clientdetail_url
                );
                $message = $mail->getMessage('meetingalert', $trans_array);
                $mail->send($employee_email, $subject, $message,'','',$alertf_name);

                $model = $this->loadModel($meetid);
                if ($model->mail_sent_counts == 1) {
                    $model->status = 0;
                    $model->mail_sent_counts = 2;
                } else {
                    $model->mail_sent_counts = 1;
                }
                $model->save(false);
            }
        }
        
        // Professional alerts
        $pcriteria = new CDbCriteria;
        $pcriteria->condition = "DATE(date_remember)='$mdate' and t.status=1";
        $pcriteria->with = array(
            "professionalDirectory" => array(
                'alias' => 'ProfessionalDirectory',
                'select' => 'NOM,PRENOM'
            ),
            "employeeProfiles" => array(
                'alias' => 'employeeProfiles',
                'select' => 'employee_name,employee_email',
            ),
        );
        $data_meets = ProfessionalMessages::model()->findAll($pcriteria);
      
       
        if (!empty($data_meets)) {
            foreach ($data_meets as $info) {
     
                $meetid = $info->message_id;
                $client_name = $info->professionalDirectory->NOM."-".$info->professionalDirectory->PRENOM;              
                $randkey = $info->randkey;
                $message = $info->message;
                $employee_email = $info->employeeProfiles->employee_email;
                $employee_name = $info->employeeProfiles->employee_name;
                
                $alertf_name = ($info->alertfile!='')? Yii::getPathOfAlias('webroot').'/'.ATTACH_PATH.'/'.$info->alertfile : '';
                
                $clientdetail_url = ADMIN_URL . "admin/default/professionalprofile/id/" . $randkey;
                $enc_url          = Myclass::refencryption($clientdetail_url);
                $clientdetail_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                /* Send mail to admin for confirmation */
                $mail = new Sendmail();
                $lang = 'FR';
                if($lang=='EN' ){
                    $subject = SITENAME . "- Reminder Mail - Today meet with professional " . $client_name;
                }elseif($lang=='FR'){
                    $subject =  SITENAME." - Rappel Mail - Aujourd'hui rencontrer professionnelle ". $client_name;
                }
                $trans_array = array(
                    "{REMKEY}" => $randkey,
                    "{NAME}" => $client_name,
                    "{MESSAGE}" => $message,
                    "{MDATE}" => $info->date_remember,
                    "{NEXTSTEPURL}" => $clientdetail_url
                );
                $message = $mail->getMessage('meetingalert', $trans_array);
                
               
                $mail->send($employee_email, $subject, $message,'','',$alertf_name);

                $model = ProfessionalMessages::model()->findByPk($meetid);
                if ($model->mail_sent_counts == 1) {
                    $model->status = 0;
                    $model->mail_sent_counts = 2;
                } else {
                    $model->mail_sent_counts = 1;
                }
                $model->save(false);
            }
        }
        
        // Retailer alerts
        $rcriteria = new CDbCriteria;
        $rcriteria->condition = "DATE(date_remember)='$mdate' and t.status=1";
        $rcriteria->with = array(
            "retailerDirectory" => array(
                'alias' => 'RetailerDirectory',
                'select' => 'COMPAGNIE'
            ),
            "employeeProfiles" => array(
                'alias' => 'employeeProfiles',
                'select' => 'employee_name,employee_email',
            ),
        );
        
        $data_meets = RetailerMessages::model()->findAll($rcriteria);
   
        if (!empty($data_meets)) {
            foreach ($data_meets as $info) {
     
                $meetid = $info->message_id;
                $client_name = $info->retailerDirectory->COMPAGNIE;              
                $randkey = $info->randkey;
                $message = $info->message;
                $employee_email = $info->employeeProfiles->employee_email;
                $employee_name = $info->employeeProfiles->employee_name;
                
                $alertf_name = ($info->alertfile!='')? Yii::getPathOfAlias('webroot').'/'.ATTACH_PATH.'/'.$info->alertfile : '';
               
                $clientdetail_url = ADMIN_URL . "admin/default/retailerprofile/id/" . $randkey;
                $enc_url          = Myclass::refencryption($clientdetail_url);
                $clientdetail_url = ADMIN_URL . 'admin/default/login/str/' . $enc_url;

                /* Send mail to admin for confirmation */
                $mail = new Sendmail();
                $lang = 'FR';
                if($lang=='EN' ){
                    $subject = SITENAME . "- Reminder Mail - Today meet with retailer " . $client_name;
                }elseif($lang=='FR'){
                    $subject =  SITENAME." - Rappel Mail - Aujourd'hui, rencontre avec le détaillant ". $client_name;
                }
                $trans_array = array(
                    "{REMKEY}" => $randkey,
                    "{NAME}" => $client_name,
                    "{MESSAGE}" => $message,
                    "{MDATE}" => $info->date_remember,
                    "{NEXTSTEPURL}" => $clientdetail_url
                );
                $message = $mail->getMessage('meetingalert', $trans_array);
                $mail->send($employee_email, $subject, $message,'','',$alertf_name);

                $model = RetailerMessages::model()->findByPk($meetid);
                if ($model->mail_sent_counts == 1) {
                    $model->status = 0;
                    $model->mail_sent_counts = 2;
                } else {
                    $model->mail_sent_counts = 1;
                }
                $model->save(false);
            }
        }
        
        
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
        $model = new ClientMessages;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ClientMessages'])) {

            $model->attributes = $_POST['ClientMessages'];
            $model->date_remember = date("Y-m-d", strtotime($_POST['ClientMessages']['date_remember']));
            $model->created_date = date('Y-m-d H:i:s', time());
            $model->randkey = Myclass::getGuid();

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Message d\'alerte créé avec succès!!!');
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

        if (isset($_POST['ClientMessages'])) {
            $model->attributes = $_POST['ClientMessages'];
            $model->date_remember = date("Y-m-d", strtotime($_POST['ClientMessages']['date_remember']));
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Les messages d\'alerte mis à jour avec succès!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
            Yii::app()->user->setFlash('success', 'Message d\'alerte supprimé avec succès!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ClientMessages('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ClientMessages']))
            $model->attributes = $_GET['ClientMessages'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ClientMessages('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ClientMessages']))
            $model->attributes = $_GET['ClientMessages'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ClientMessages the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ClientMessages::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ClientMessages $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'client-messages-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
