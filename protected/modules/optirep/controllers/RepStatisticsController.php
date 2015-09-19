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
                'actions' => array(''),
                'users' => array('*'),
            ), 
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'payment','paypalreturn' , 'paypalcancel' , 'paypalnotify'),
                'users' => array('@'),               
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array( 'userslogstats', 'profileviewstats'),      
                'users' => array('@'),
                'expression' => 'Yii::app()->user->rep_role=="admin"'
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

    public function actionPayment() {
        $paypalManager = new Paypal;

        if (isset($_POST['btnSubmit'])) {

            $returnUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repStatistics/paypalreturn'));
            $cancelUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repStatistics/paypalcancel'));
            $notifyUrl = Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('/optirep/repStatistics/paypalnotify'));
            
            $subprices  = SupplierSubscriptionPrice::model()->findByPk(1);
            $price      = $subprices->rep_statistics_price;
    
            $invoice = rand();
            $subscription_type = $_POST['subscription_type'];

            if ($subscription_type == 3) {
                $itemname = 'Statistics Subscription';
                $payment_details['expirydate'] = date("Y-m-d", strtotime('+1 month'));
            } else if ($subscription_type == 4)
            {
                $itemname = 'Renew Statistics Subscription';
               
                $repid =  Yii::app()->user->id;
                $criteria1 = new CDbCriteria();
                $criteria1->addCondition("user_id=".$repid);
                $criteria1->addCondition("NOMTABLE='rep_credentials'");
                $criteria1->addCondition("(subscription_type='3' || subscription_type='4')");
                $criteria1->order = 'id DESC';
                $criteria1->limit = 1;
                $get_recent_transaction = PaymentTransaction::model()->find($criteria1);
                if(!empty($get_recent_transaction))
                {    
                    $exprydate  = $get_recent_transaction['expirydate'];
                    if ($exprydate > date("Y-m-d")) 
                    {
                        $time = strtotime($exprydate);
                        $payment_details['expirydate'] = date("Y-m-d", strtotime("+1 month", $time));                        
                    } else {
                        $payment_details['expirydate'] = date('Y-m-d', strtotime('+1 month'));
                    }
                }else
                {
                  $payment_details['expirydate'] = date("Y-m-d", strtotime('+1 month'));   
                }    
            }

            $payment_details = array();
            $payment_details['rep_credential_id'] = Yii::app()->user->id;
            $payment_details['rep_user_name']     = Yii::app()->user->rep_username;
            $payment_details['pay_type'] = '1';
            $payment_details['subscription_type'] = $_POST['subscription_type'];
            $pdetails = serialize($payment_details);

            $stmodel = new SupplierTemp;
            $stmodel->paymentdetails = $pdetails;
            $stmodel->invoice_number = $invoice;
            $stmodel->save(false);

            $paypalManager->addField('item_name', $itemname);
            $paypalManager->addField('amount', $price);
            $paypalManager->addField('custom', $invoice);
            $paypalManager->addField('return', $returnUrl);
            $paypalManager->addField('cancel_return', $cancelUrl);
            $paypalManager->addField('notify_url', $notifyUrl);

            //$paypalManager->dumpFields();   // for printing paypal form fields
            $paypalManager->submitPaypalPost();
        }

        $this->render('payment');
    }

    public function actionPaypalreturn() {

        $pstatus = $_POST["payment_status"];

        if (isset($_POST["txn_id"]) && isset($_POST["payment_status"])) {
            if ($pstatus == "Pending") {
                Yii::app()->user->setFlash('info', Myclass::t('OGO182', '', 'og'));
            } else {
                Yii::app()->user->setFlash('success', Myclass::t('OGO185', '', 'og'));
            }
        } else {
            Yii::app()->user->setFlash('danger', Myclass::t('OGO183', '', 'og'));
        }
        $this->redirect(array('payment'));
    }

    public function actionPaypalcancel() {

        Yii::app()->user->setFlash('warning', Myclass::t('OGO184', '', 'og'));
        $this->redirect(array('payment'));
    }

    public function actionPaypalnotify() {
        $paypalManager = new Paypal;

        if ($paypalManager->notify() && ( $_POST['payment_status'] == "Completed" || $_POST['payment_status'] == "Pending")) {

            $invoice_number = $_POST['custom'];

            $result = SupplierTemp::model()->find("invoice_number='$invoice_number'");

            if (!empty($result)) {

                $pdetails = $result->paymentdetails;
                $pdetails = unserialize($pdetails);

                // Save the payment details                                   
                $ptmodel = new PaymentTransaction;
                $ptmodel->user_id = $pdetails['rep_credential_id'];    // need to assign acutal user id
                $ptmodel->total_price = $_POST['mc_gross'];
                $ptmodel->subscription_price = $_POST['mc_gross'];
                $ptmodel->payment_status = $_POST['payment_status'];
                $ptmodel->payer_email = $_POST['payer_email'];
                $ptmodel->verify_sign = $_POST['verify_sign'];
                $ptmodel->txn_id = $_POST['txn_id'];
                $ptmodel->payment_type = $_POST['payment_type'];
                $ptmodel->receiver_email = $_POST['receiver_email'];
                $ptmodel->txn_type = $_POST['txn_type'];
                $ptmodel->item_name = $_POST['item_name'];
                $ptmodel->NOMTABLE = 'rep_credentials';
                $ptmodel->expirydate = $pdetails['expirydate'];
                $ptmodel->invoice_number = $_POST['custom'];
                $ptmodel->pay_type = $pdetails['pay_type'];
                $ptmodel->subscription_type = $pdetails['subscription_type'];
                $ptmodel->save();
                                
                $repname = $pdetails['rep_user_name'];
                
                SupplierTemp::model()->deleteAll("invoice_number = '" . $_POST['custom'] . "'");

                /* Send mail to admin for confirmation */
                $mail = new Sendmail();
                
                $invoice_url = ADMIN_URL . '/admin/paymentTransaction/view/id/' . $ptmodel->id;
                $enc_url2    = Myclass::refencryption($invoice_url);
                $nextstep_url2 = ADMIN_URL . 'admin/default/login/str/' . $enc_url2;
                
                $subject = SITENAME . "- Statistics subscription notification with invoice details - " . $repname;
                $trans_array = array(
                "{NAME}" => $repname,
                "{UTYPE}" => 'Opti-Rep',               
                "{item_name}" => $_POST['item_name'],
                "{total_price}" => $_POST['mc_gross'],
                "{payment_status}" => $_POST['payment_status'],
                "{txn_id}" => $_POST['txn_id'],
                "{INVOICEURL}" => $nextstep_url2
                );
                $message = $mail->getMessage('optirep_stats_subscription', $trans_array);
                $mail->send(ADMIN_EMAIL, $subject, $message);
                
            }
        }
    }

    //Particular Rep Logged in Activities
    public function actionIndex() {
        
        $stats_disp = Myclass::stats_display();
        if($stats_disp==0)
        {
            Yii::app()->user->setFlash('info', "Kindly do the payment to see the statistics chart!!");
            $this->redirect('payment');
        }    
        
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
    public function actionUserslogstats() {
        
        $stats_disp = Myclass::stats_display();
        if($stats_disp==0)
        {
            Yii::app()->user->setFlash('info', "Kindly do the payment to see the statistics chart!!");
            $this->redirect('payment');
        }   
        
        
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
        $this->render('userslogstats', array('response' => $response));
    }

    public function actionProfileviewstats() {
        
        $stats_disp = Myclass::stats_display();
        if($stats_disp==0)
        {
            Yii::app()->user->setFlash('info', "Kindly do the payment to see the statistics chart!!");
            $this->redirect('payment');
        }   
        
        $response = array();

        $adminid = Yii::app()->user->id;

        $condition = "rep_status='1' and rep_parent_id = '" . $adminid . "'";
        $getusers = RepCredentials::model()->findAll($condition);

        $dates = array();
        for ($i = 0; $i < 6; $i++) {
            array_push($dates, date("Y-m-d", strtotime($i . " days ago")));
        }

        $response['dates'] = array();
        foreach ($dates as $date) {
            array_push($response["dates"], $date);
        }

        if (!empty($getusers)) {

            foreach ($getusers as $key => $uinfo) {

                $rep_id = $uinfo['rep_credential_id'];

                // Count all profile view counts              
                $response['viewcounts'] = array();
                foreach ($dates as $date) {
                    $condition1 = " DATE(view_date) ='$date' and rep_credential_id=" . $rep_id;
                    $viewcounts = RepViewCounts::model()->count($condition1);
                    array_push($response["viewcounts"], (int) $viewcounts);
                }
                $response['allprofiles'][$key]['name'] = $uinfo['rep_username'];
                $response['allprofiles'][$key]['data'] = $response["viewcounts"];

                // Count professional profile view counts                
                $response['viewcounts'] = array();
                foreach ($dates as $date) {
                    $condition2 = " DATE(view_date) ='$date' and ID_SPECIALISTE!=0 and rep_credential_id=" . $rep_id;
                    $viewcounts = RepViewCounts::model()->count($condition2);
                    array_push($response["viewcounts"], (int) $viewcounts);
                }
                $response['professionalviews'][$key]['name'] = $uinfo['rep_username'];
                $response['professionalviews'][$key]['data'] = $response["viewcounts"];

                // Count retailer profile view counts
                $response['viewcounts'] = array();
                foreach ($dates as $date) {
                    $condition3 = " DATE(view_date) ='$date' and ID_RETAILER!=0 and rep_credential_id=" . $rep_id;
                    $viewcounts = RepViewCounts::model()->count($condition3);
                    array_push($response["viewcounts"], (int) $viewcounts);
                }
                $response['retailerviews'][$key]['name'] = $uinfo['rep_username'];
                $response['retailerviews'][$key]['data'] = $response["viewcounts"];
            }
        }

        $this->render('profileviewstats', array('response' => $response));
    }

}
