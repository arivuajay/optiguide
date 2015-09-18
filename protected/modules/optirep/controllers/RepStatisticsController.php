<?php

class RepStatisticsController extends ORController {

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
                'actions' => array(),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'repAccountsLoggedinActivities'),
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

    //Particular Rep Logged in Activities
    public function actionIndex() {
        $response = array();

        $dates = array();
        for ($i = 0; $i < 6; $i++) {
            array_push($dates, date("Y-m-d", strtotime($i . " days ago")));
        }

        $response['dates'] = array();
        foreach ($dates as $date) {
            array_push($response["dates"], $date);
        }

        $response['visits'] = array();
        foreach ($dates as $date) {
            $criteria = new CDbCriteria();
            $criteria->addCondition("DATE(loggedin_date) = '" . $date . "' AND rep_credential_id = " . Yii::app()->user->id);
            $visits = RepLoggedinActivities::model()->count($criteria);
            array_push($response["visits"], (int) $visits);
        }

        $this->render('index', array('response' => $response));
    }

    //Rep Admin - Accounts Logged in Activites
    public function actionRepAccountsLoggedinActivities() {
        $repAccountsCriteria = new CDbCriteria;
        $repAccountsCriteria->select = 't.rep_credential_id, t.rep_username'; // select fields which you want in output
        $repAccountsCriteria->condition = 't.rep_parent_id = ' . Yii::app()->user->id;
        $repAccounts = RepCredentials::model()->findAll($repAccountsCriteria);
        
        $dates = array();
        for ($i = 0; $i < 6; $i++) {
            array_push($dates, date("Y-m-d", strtotime($i . " days ago")));
        }

        $response = array();

        $response['dates'] = array();
        foreach ($dates as $date) {
            array_push($response["dates"], $date);
        }

        $response['series'] = array();

        foreach ($repAccounts as $key => $repAccount) {
            $response['series'][$key]['name'] = $repAccount['rep_username'];
            $response['series'][$key]['data'] = array();
            foreach ($dates as $date) {
                $criteria = new CDbCriteria();
                $criteria->addCondition("DATE(loggedin_date) = '" . $date . "' AND rep_credential_id = " . $repAccount['rep_credential_id']);
                $visits = RepLoggedinActivities::model()->count($criteria);
                $response['series'][$key]['data'][] = (int) $visits;
            }
        }
        $this->render('repAccountsLoggedinActivities', array('response' => $response));
    }

}
