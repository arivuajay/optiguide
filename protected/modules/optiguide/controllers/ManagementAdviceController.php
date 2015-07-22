<?php

class ManagementAdviceController extends OGController {

    public function actionView($id) {
        $model = ManagementAdvice::model()->find(array(
            'condition' => 'ID_CONSEIL = :PKEY AND LANGUE = :LN',
            'params' => array(':PKEY' => $id, ':LN' => Yii::app()->session['language']),
        ));
        
        if ($model === null)
            throw new CHttpException(404, 'No result found');

        $this->render('view', array(
            'model' => $model,
        ));
    }

}
