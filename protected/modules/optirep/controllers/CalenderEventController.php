<?php
class CalenderEventController extends ORController {
  

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
                       'actions' => array(),
                       'users' => array('*'),
                   ),
                   array('allow', // allow authenticated user to perform 'create' and 'update' actions
                       'actions' => array('index', 'view'),
                       'users' => array('@'),
                   ),
                   array('allow', // allow admin user to perform 'admin' and 'delete' actions
                       'actions' => array(''),
                       'users' => array(''),
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
        $searchModel = new CalenderEvent('search');
        $searchModel->unsetAttributes();
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'searchModel' => $searchModel,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //Index function
        $current_date = date("Y-m-d");

        $searchModel = new CalenderEvent('search');
        $searchModel->unsetAttributes();
        
        $criteria = new CDbCriteria();
        $criteria->addCondition('LANGUE = "'.$this->lang.'"');
        if (isset($_REQUEST['CalenderEvent'])) {
            $searchModel->attributes = $_REQUEST['CalenderEvent'];
            $criteria->compare('TITRE', $searchModel->TITRE, true);
            if ($searchModel->ID_PAYS)
                $criteria->addCondition('ID_PAYS = ' . $searchModel->ID_PAYS);
            if ($searchModel->ID_REGION)
                $criteria->addCondition('ID_REGION = ' . $searchModel->ID_REGION);
            if ($searchModel->ID_VILLE)
                $criteria->addCondition('ID_VILLE = ' . $searchModel->ID_VILLE);
            if ($searchModel->EVENT_MONTH)
                $criteria->addCondition('MONTH(DATE_AJOUT1) = ' . $searchModel->EVENT_MONTH);
            if ($searchModel->EVENT_YEAR)
                $criteria->addCondition('YEAR(DATE_AJOUT1) = ' . $searchModel->EVENT_YEAR);
        } elseif (isset($_REQUEST['date'])) {
            $criteria->addCondition('DATE_AJOUT1 <= "' . $_REQUEST['date'] . '" AND DATE_AJOUT2 >= "' . $_REQUEST['date'] . '"');
        } else {
            $criteria->addCondition('DATE_AJOUT1 >= "' . $current_date . '"');
        }
        $criteria->addCondition('AFFICHER_SITE = 1');
        $criteria->order = 'DATE_AJOUT1 DESC';

        $count = CalenderEvent::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $model = CalenderEvent::model()->findAll($criteria);

        $result = array();
        foreach ($model as $events) {
            $time = strtotime($events['DATE_AJOUT1']);
            $month = date("F", $time);
            $year = date("Y", $time);
            $result[$month . ' ' . $year][] = $events;
        }

        $this->render('index', array(
            'model' => $result,
            'pages' => $pages,
            'searchModel' => $searchModel,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CalenderEvent the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CalenderEvent::model()->findByPk($id, 'AFFICHER_SITE = :ENABLE', array(':ENABLE' => 1));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CalenderEvent $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'calender-event-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
