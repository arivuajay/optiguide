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
    
     /**
     * Lists all models.
     */
    public function actionIndex() {
       
        $criteria = new CDbCriteria();      
        $criteria->addCondition('LANGUE = "' . Yii::app()->session['language'] . '"');
        $criteria->addCondition('AFFICHER_SITE=1');
        $criteria->order = 'ID_CONSEIL DESC';

        $count = ManagementAdvice::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 8;
        $pages->applyLimit($criteria);
        $model = ManagementAdvice::model()->findAll($criteria);

        $this->render('index', array(
            'model' => $model,
            'pages' => $pages,
        ));
    }

}
