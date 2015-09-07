<?php

class RepAccountsController extends ORController {

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
                'actions' => array('index', 'create'),
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

    public function actionCreate() {
        $current_plan = RepAdminSubscriptions::model()->getCurrentPlan();
        if (empty($current_plan)) {
            Yii::app()->user->setFlash('danger', "You can't create new rep account");
            $this->redirect(array('index'));
        }

        $model = new RepCredentials('create_new_rep_account');
        $profile = new RepCredentialProfiles('step2');

        if (isset($_POST['btnSubmit'])) {
            $model->attributes = $_POST['RepCredentials'];
            $profile->attributes = $_POST['RepCredentialProfiles'];
            $valid = $model->validate();
            $valid = $profile->validate() && $valid;
            if ($valid) {
                $model->rep_role = RepCredentials::ROLE_SINGLE;
                $model->rep_parent_id = Yii::app()->user->id;
                $model->rep_expiry_date = $current_plan['rep_admin_subscription_end'];

                if ($model->save(false)) {
                    //Rep Profile Insert
                    $profile->rep_credential_id = $model->rep_credential_id;
                    $profile->save(false);

                    //Current Plan - Upadate the used and remaining accounts count
                    $current_plan->no_of_accounts_used = $current_plan->no_of_accounts_used + 1;
                    $current_plan->no_of_accounts_remaining = $current_plan->no_of_accounts_remaining - 1;
                    $current_plan->save(false);

                    //Current Plan - New Subscriber Insert
                    $subscriber = new RepAdminSubscribers();
                    $subscriber->rep_admin_subscription_id = $current_plan->rep_admin_subscription_id;
                    $subscriber->rep_credential_id = $model->rep_credential_id;
                    $subscriber->save(false);

                    Yii::app()->user->setFlash('success', "Rep account created successfully!!!");
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create', array('model' => $model, 'profile' => $profile));
    }

}
