<?php

class SettingsController extends Controller {
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
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $dashboard_boxes = ['Payments' => "Payments"];
        $model = new Settings();
        $setting_attr = $model->attributeLabels();
                
        if (isset($_POST['Settings'])) {    
            $model->attributes = $_POST['Settings'];

            if($_POST['Settings']['paypal_advanced_status'] == '1' && $_POST['Settings']['paypal_standard_status'] == '1'){
                $model->addError('option_value','Please choose any one');
            } else {                
                foreach ($setting_attr as $akey => $avalue) {
                    $smodel = Settings::model()->find("option_type='" . $akey . "'");
                    if (isset($smodel) && !empty($smodel)) {
                        //$optionval = json_encode($model->dashboard);
                        $optionval = $model->$akey;
                        $smodel->option_value = $optionval;
                        $smodel->save();
                    }
                }
                Yii::app()->user->setFlash('success', 'Settings Updated Successfully!!!');
                $this->redirect(array('index'));
            }
            
        }        
        if (isset($setting_attr) && !empty($setting_attr)) {
            foreach ($setting_attr as $akey => $avalue) {                                
                $optionval_obj = Settings::model()->find("option_type='" . $akey . "'");
                if (isset($optionval_obj) && !empty($optionval_obj)) {
                    //$optionval = json_decode($optionval_obj->option_value, true);                    
                    $optionval = $optionval_obj->option_value;
                    $model->$akey = $optionval;
                }
            }
        }
        
        $this->render('index', array(
            'model' => $model,
            'dashboard_boxes' => $dashboard_boxes,
        ));
    }
        
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Settings the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Settings::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Settings $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bj-settings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
