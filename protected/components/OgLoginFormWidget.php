<?php

class OgLoginFormWidget extends CWidget {

    /**
     * Is called when $this->beginWidget() is called
     */
    public function init() {
        
    }

    /**
     * Is called when $this->endWidget() is called
     */
    public function run() {
        $model = new OgLoginForm;
//        $this->performAjaxValidation($model);
        if (isset($_POST['sign_in'])) {

            $model->attributes = $_POST['OgLoginForm'];

            if ($model->validate() && $model->login()) {
                
                // Update the first log in db
                $id=Yii::app()->user->id;
                $umodel = UserDirectory::model()->findByPk($id);
                if($umodel->IS_FIRST_LOG==0)
                {    
                    $umodel->IS_FIRST_LOG = 1;
                    $umodel->save(false);
                }    
                 
                $this->owner->redirect(array("/optiguide/default/index"));
            } else {
              //  Yii::app()->session->open();
              // Yii::app()->user->setFlash('danger', 'Can not login');
              //  $this->owner->redirect(array("/optiguide/default/index"));
            }
        }
        $this->render('OgLoginFormWidget', array('model' => $model));
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
