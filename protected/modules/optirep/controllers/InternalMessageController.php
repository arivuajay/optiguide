<?php

class InternalMessageController extends ORController {

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
                'actions' => array('index', 'createnew'),
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

    public function actionIndex() {
        $this->render('index');
    }

    public function actionCreatenew() {
        
        $model = new InternalMessage;

        $this->performAjaxValidation(array($model));
      
        if (isset($_POST['btnSubmit'])) {
            
            $model->attributes = $_POST['InternalMessage'];
            $valid = $model->validate();
            if ($valid) {
                
                $npm_count = InternalMessage::model()->count();
                $id1 = $npm_count+1;
                
                // conversation id
                $model->id1   = $id1;
                // New conversation start        
                $model->id2   = 1;
                // Sender
                $model->user1 = 22;
                // Receiver   (the value send through post)    
                //$model->user2 
                $model->timestamp = time();
                $model->user1read = "yes";
                $model->user2read = "no";
                
                $model->save(false);           

                Yii::app()->user->setFlash('success', "Message send successfully!!!");
                $this->redirect(array('index'));
                
            }
            
        }
        
        $this->render('create',array('model' => $model));
    }
    
        /**
     * Performs the AJAX validation.
     * @param ArchiveCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'internal-message-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


}
