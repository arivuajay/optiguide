<?php

class DefaultController extends ORController {

    public $layout = '//layouts/anonymous_page';

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
                'actions' => array('index','aboutus','legend','contactus'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout'),
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
        $model = new OrLoginForm;
        if (isset($_POST['login'])) {
            $model->attributes = $_POST['OrLoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(array('/optirep/dashboard'));
            }
        }
        $this->render('index', array('model' => $model));
    }
    
    public function actionAboutus() {
        $this->layout = '//layouts/column1';
        $this->render('aboutus');
    }
    
    public function actionLegend() {
        $this->layout = '//layouts/column1';
        $this->render('legend');
    }
    
    public function actionContactus() {
        $this->layout = '//layouts/column1';
        $this->render('contactus');
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index');
    }

}
