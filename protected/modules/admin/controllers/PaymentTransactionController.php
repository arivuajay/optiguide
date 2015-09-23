<?php

class PaymentTransactionController extends Controller {
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
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'reptransaction', 'repview', 'repUpdateStatus'),
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PaymentTransaction'])) {

            $model->attributes = $_POST['PaymentTransaction'];
            $pstatus = $_POST['PaymentTransaction']['payment_status'];
            
            if($pstatus=="Pending")
            {
                Yii::app()->user->setFlash('danger', 'Payment transaction status not yet completed!!!');                
            }else
            {    
                $suppid = $model->user_id;
                $subscription_type = $model->subscription_type;
                $invoice_number = $model->invoice_number;
                
                $fmodel = SuppliersDirectory::model()->findByPk($suppid);
                
                $profile_expirydate = $fmodel->profile_expirydate;
                $logo_expirydate    = $fmodel->logo_expirydate;

                if ($subscription_type == "1" || $subscription_type == "2") {                   
                        $p_expdate = date("Y-m-d", strtotime($profile_expirydate));
                        if ($p_expdate > date("Y-m-d")) {
                            $time = strtotime($profile_expirydate);
                            $fmodel->profile_expirydate = date("Y-m-d", strtotime("+1 year", $time));
                        } else {
                            $fmodel->profile_expirydate = date('Y-m-d', strtotime('+1 year'));
                        }                         
                }

                if ($subscription_type == "3" || $subscription_type == "2") {                   
                        $l_expdate = date("Y-m-d", strtotime($logo_expirydate));
                        if ($l_expdate > date("Y-m-d")) {
                            $time = strtotime($logo_expirydate);
                            $fmodel->logo_expirydate = date("Y-m-d", strtotime("+1 year", $time));
                        } else {
                            $fmodel->logo_expirydate = date('Y-m-d', strtotime('+1 year'));
                        }                   
                }
                
                $fmodel->save(false);
                
                /* Registration - Update user status 1 in user table */
                if($model->supp_renew_status==0)
                {    
                    $userinfos = UserDirectory::model()->find("NOM_TABLE='Fournisseurs' AND ID_REALTION = " . $suppid);
                    $userinfos->status = 1;
                    $userinfos->save(false);
                }
                
                SupplierTemp::model()->deleteAll("invoice_number = '" . $invoice_number . "'");   
                
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'PaymentTransaction status Updated Successfully!!!');                   
                }
            }    
            
            if ($model->NOMTABLE == 'rep_credentials') {
                $this->redirect(array('reptransaction'));
            } else {
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new PaymentTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentTransaction']))
            $model->attributes = $_GET['PaymentTransaction'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /* ------------------------REP Payment Transaction Details--------------------------------------------- */

    public function actionReptransaction() {
        $model = new PaymentTransaction('searchrep');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentTransaction']))
            $model->attributes = $_GET['PaymentTransaction'];

        $this->render('reptransaction', array(
            'model' => $model,
        ));
    }

    public function actionRepview($id) {
        $this->render('repview', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionRepUpdateStatus($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['PaymentTransaction'])) {
            if ($_POST['PaymentTransaction']['payment_status'] == 'Completed') {
                $model->payment_status = $_POST['PaymentTransaction']['payment_status'];
                $repTemp = RepTemp::model()->findByPk($model->rep_temp_id);
                if (!empty($repTemp)) {
                    if ($repTemp['rep_temp_key'] == RepTemp::REGISTRATION) {
                        $this->processRegistration($repTemp['rep_temp_random_id']);
                    } elseif ($repTemp['rep_temp_key'] == RepTemp::REP_ADMIN_BUY_MORE_ACCOUNTS) {
                        $this->processBuyMoreAccounts($repTemp['rep_temp_random_id']);
                    } elseif ($repTemp['rep_temp_key'] == RepTemp::REP_ADMIN_RENEWAL_REP_ACCOUNTS) {
                        $this->processRenewalRepAccounts($repTemp['rep_temp_random_id']);
                    }
                }
            }
        }
        $this->render('repUpdateStatus', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PaymentTransaction the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PaymentTransaction::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PaymentTransaction $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-transaction-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
