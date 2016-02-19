<?php

class NewsManagementController extends ORController {
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
     * Lists all models.
     */
    public function actionIndex() {
        $current_date = date("Y-m-d");

        $searchModel = new NewsManagement('search');
        $searchModel->unsetAttributes();

        $criteria = new CDbCriteria();
        if (isset($_REQUEST['NewsManagement'])) {
            $searchModel->attributes = $_REQUEST['NewsManagement'];
            $criteria->compare('TEXTE', $searchModel->TEXTE, true);
        } else {
            $criteria->addCondition('DATE_AJOUT1 <= "' . $current_date . '" AND DATE_AJOUT2 >= "' . $current_date . '"');
        }
        $criteria->addCondition('LANGUE = "' . $this->lang . '"');
        $criteria->order = 'DATE_AJOUT1 DESC, TITRE ASC';

        $count = NewsManagement::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);
        $model = NewsManagement::model()->findAll($criteria);

        $this->render('index', array(
            'model' => $model,
            'pages' => $pages,
            'total'=>$count,
            'searchModel' => $searchModel,
        ));
    }

    public function actionView($id) {
        $searchModel = new NewsManagement('search');
        $searchModel->unsetAttributes();

        $this->render('view', array(
            'model' => $this->loadModel($id),
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
        $model = NewsManagement::model()->findByPk($id);
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
