<?php

class RepFavouritesController extends ORController {

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
                'actions' => array('index', 'updatefav'),
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

    public function actionUpdatefav() {
        $rep_id = Yii::app()->user->id;
        $retailerid = isset($_POST['id']) ? $_POST['id'] : '';
        $favstatus = isset($_POST['favstatus']) ? $_POST['favstatus'] : '';

        if ($favstatus != '' && $retailerid != '' && $rep_id != '') {
            if ($favstatus == "removefav") {
                $criteria = new CDbCriteria;
                $criteria->condition = 'rep_credential_id=:repid and ID_UTILISATEUR= :retid';
                $criteria->params = array(":repid" => $rep_id, ":retid" => $retailerid);
                $favourites = RepFavourites::model()->find($criteria);
                $favourites->delete();
            } else {
                $favourites = new RepFavourites;
                $favourites->rep_credential_id = $rep_id;
                $favourites->ID_UTILISATEUR = $retailerid;
                $favourites->save();
            }
        }
    }

}
