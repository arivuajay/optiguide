<?php

class ProfessionalDirectoryController extends Controller {
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
                parent::accessRules(), array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'getmessage', 'deleteMessage', 'updateMessage'),
                'users' => array('@'),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ProfessionalDirectory('backend');
        $pmodel = new ProfessionalMessages;
        // $umodel = new UserDirectory();

        $this->performAjaxValidation(array($model));

        if (isset($_POST['ProfessionalDirectory'])) {

            $model->attributes = $_POST['ProfessionalDirectory'];
            $model->pfile = CUploadedFile::getInstance($model, 'pfile');

            //   $umodel->attributes = $_POST['UserDirectory'];
            //    $model->ID_CLIENT   = $umodel->USR;          
            //   $umodel->NOM_TABLE  = $model::$NOM_TABLE;
            //   $umodel->NOM_UTILISATEUR = $model->PRENOM." ".$model->NOM;
            //   $umodel->PWD = Myclass::getRandomString(5);
            //   $umodel->sGuid = Myclass::getGuid();
            //   $umodel->LANGUE  = "FR";         
            //        $valid = $umodel->validate();
            //        $valid = $model->validate() && $valid;

            if ($model->validate()) {

                $address = $model->ADRESSE;
                $country = $model->country;
                $region = $model->region;
                $cty = $model->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if ($geo_values != '') {
                    $exp_latlong = explode('~', $geo_values);
                    $model->map_lat = $exp_latlong[0];
                    $model->map_long = $exp_latlong[1];
                }
                $model->CREATED_DATE = date("Y-m-d");
                // save proof file
                if ($model->pfile) {
                    $filename = time() . '_' . $model->pfile->name;
                    $model->proof_file = $filename;
                    $proof_path = Yii::getPathOfAlias('webroot') . '/' . PROOF_PATH . '/';
                    if (!is_dir($proof_path)) {
                        mkdir($proof_path, 0777, true);
                    }
                    $model->pfile->saveAs($proof_path . $filename);
                }

                $model->save(false);
                //   $umodel->ID_RELATION = $model->ID_SPECIALISTE;
                //   $umodel->save(false);
                // save the alert message         
                if (isset($_POST['ProfessionalMessages'])) {
                    $pmodel->attributes = $_POST['ProfessionalMessages'];
                    $pmodel->ID_SPECIALISTE = $model->ID_SPECIALISTE;
                    $pmodel->message = nl2br($_POST['ProfessionalMessages']['message']);
                    $pmodel->date_remember = date("Y-m-d", strtotime($_POST['ProfessionalMessages']['date_remember']));
                    $pmodel->created_date = date("Y-m-d");
                    $pmodel->randkey = Myclass::getGuid();
                    //save attachment
                    $pmodel->afile = CUploadedFile::getInstance($pmodel, 'afile');
                    if ($pmodel->afile) {
                        $filename = time() . '_' . $pmodel->afile->name;
                        $pmodel->alertfile = $filename;
                        $attach_path = Yii::getPathOfAlias('webroot') . '/' . ATTACH_PATH . '/';
                        if (!is_dir($attach_path)) {
                            mkdir($attach_path, 0777, true);
                        }
                        $pmodel->afile->saveAs($attach_path . $filename);
                    }

                    if ($pmodel->date_remember != '' && $pmodel->employee_id != '' && $pmodel->message != '') {
                        $pmodel->save();
                    }
                }

                Yii::app()->user->setFlash('success', 'professionnel créé avec succès!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', compact('model', 'pmodel'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'backend';
        $pmodel = new ProfessionalMessages;
        // $umodel = UserDirectory::model()->find("USR = '{$model->ID_CLIENT}'");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));

        if (isset($_POST['ProfessionalDirectory'])) {
            $model->attributes = $_POST['ProfessionalDirectory'];
            $model->pfile = CUploadedFile::getInstance($model, 'pfile');

            //  $umodel->attributes = $_POST['UserDirectory'];
            //  $umodel->NOM_TABLE = $model::$NOM_TABLE;
            //  $umodel->NOM_UTILISATEUR = $model->PRENOM." ".$model->NOM;
            //  $valid = $umodel->validate();
            //  $valid = $model->validate() && $valid;

            if ($model->validate()) {

                $address = $model->ADRESSE;
                $country = $model->country;
                $region = $model->region;
                $cty = $model->ID_VILLE;
                $geo_values = Myclass::generatemaplocation($address, $country, $region, $cty);
                if ($geo_values != '') {
                    $exp_latlong = explode('~', $geo_values);
                    $model->map_lat = $exp_latlong[0];
                    $model->map_long = $exp_latlong[1];
                }

                // save proof file
                if ($model->pfile) {
                    $filename = time() . '_' . $model->pfile->name;
                    $model->proof_file = $filename;
                    $proof_path = Yii::getPathOfAlias('webroot') . '/' . PROOF_PATH . '/';
                    if (!is_dir($proof_path)) {
                        mkdir($proof_path, 0777, true);
                    }
                    $model->pfile->saveAs($proof_path . $filename);
                }

                //   $umodel->save(false);
                $model->save(false);

                // save the alert message         
                if (isset($_POST['ProfessionalMessages'])) {
                    $pmodel->attributes = $_POST['ProfessionalMessages'];
                    $pmodel->ID_SPECIALISTE = $model->ID_SPECIALISTE;
                    $pmodel->message = nl2br($_POST['ProfessionalMessages']['message']);
                    $pmodel->date_remember = date("Y-m-d", strtotime($_POST['ProfessionalMessages']['date_remember']));
                    $pmodel->created_date = date("Y-m-d");
                    $pmodel->randkey = Myclass::getGuid();
                    //save attachment
                    $pmodel->afile = CUploadedFile::getInstance($pmodel, 'afile');
                    if ($pmodel->afile) {
                        $filename = time() . '_' . $pmodel->afile->name;
                        $pmodel->alertfile = $filename;
                        $attach_path = Yii::getPathOfAlias('webroot') . '/' . ATTACH_PATH . '/';
                        if (!is_dir($attach_path)) {
                            mkdir($attach_path, 0777, true);
                        }
                        $pmodel->afile->saveAs($attach_path . $filename);
                    }

                    if ($pmodel->date_remember != '' && $pmodel->employee_id != '' && $pmodel->message != '') {
                        $pmodel->save(false);
                    }
                }

                Yii::app()->user->setFlash('success', 'professionnelle mis à jour avec succès!!!');
                $this->redirect(array('update', "id" => $id));
            }
        }

        // Get the alert history for the client
        $pmodel = new ProfessionalMessages('search');
        $pexpiremodel = $pmodel->search_expirealerts($id);
        $pcurrentmodel = $pmodel->search_currentalerts($id);

        $this->render('update', compact('model', 'pmodel', 'pexpiremodel', 'pcurrentmodel'));
    }

    public function actionGetmessage() {
        $messageid = $_POST['id'];
        $message_info = ProfessionalMessages::model()->findByPk($messageid);
        $return_str = $message_info->message;
        echo $return_str;
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
            Yii::app()->user->setFlash('success', 'ProfessionalDirectory Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    public function actionDeleteMessage($id) {

        ProfessionalMessages::model()->findByPk($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Message d\'alerte supprimé avec succès!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    public function actionUpdateMessage() {
        $message_id = $_GET['message_id'];
        $message_id_array = explode('_', $message_id);

        $model = ProfessionalMessages::model()->findByPk($message_id_array[1]);
        $model->scenario = 'update';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ProfessionalMessages'])) {
            $model->attributes = $_POST['ProfessionalMessages'];

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
                $this->redirect(array('update', 'id' => $model->ID_SPECIALISTE));
            }
        }

        $this->renderPartial('update_message', array('model' => $model), false, true);
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $model = new ProfessionalDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProfessionalDirectory']))
            $model->attributes = $_GET['ProfessionalDirectory'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProfessionalDirectory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProfessionalDirectory']))
            $model->attributes = $_GET['ProfessionalDirectory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProfessionalDirectory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProfessionalDirectory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProfessionalDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === 'professional-directory-form' || $_POST['ajax'] === 'professional-message-form')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
