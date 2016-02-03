<?php

class DashboardController extends ORController {

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
                'actions' => array('index'),
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
        $this->layout = '//layouts/column1';
        $statvisible = 0;
        $response = array();
        
        $usrinfo = RepCredentials::model()->findByPk(Yii::app()->user->id);
      
        if($usrinfo->rep_role == RepCredentials::ROLE_ADMIN)
        {
           
             // FOR ROLE_ADMIN USRES ONLY
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
            
        }else{    
           
            // FOR OPTIREP USRES ONLY
            /** Users registered in optiguide **/
            $months = array();
            if (Yii::app()->session['language'] == 'FR') { 
                for ($i = 0; $i < 6; $i++) {

                    $m      = date("n", strtotime($i . " months ago"));
                    $mon    = Myclass::getMonths_M($m);
                    $year   = date("Y", strtotime($i . " months ago"));
                    $get_my = $mon.' '.$year;
                    array_push($months, $get_my);
                }
            }else{
                for ($i = 0; $i < 6; $i++) {
                    array_push($months, date("M Y", strtotime($i . " months ago")));
                }
            }
    //            array_push($months, date("M Y", strtotime($i . " months ago")));

            $response['months'] = array();
            foreach ($months as $month) {
                array_push($response["months"], $month);
            }

            $usertypes = array("Professionals", "Retailers");

            foreach ($usertypes as $key => $utype) {
                // Count  profile view counts  per month
                $response['viewcounts'] = array();
                $viewcounts = '';
                foreach ($months as $month) {

                    $searchdate = date("Y-m", strtotime($month));
                    if ($utype == "Professionals" || $utype=="Professionnels") {
                        $per_mount_counts = Yii::app()->db->createCommand() //this query contains all the data
                                ->select('count(*) as pro_per_month_count,ID_SPECIALISTE , NOM , PRENOM , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' AND rs.CREATED_DATE LIKE '%$searchdate%' ")
                                ->group('rst.ID_TYPE_SPECIALISTE')
                                ->queryAll();

                         foreach($per_mount_counts as $per_mount_count){
                             $viewcount = $viewcount + $per_mount_count['pro_per_month_count'];
                         }

                        $viewcounts =$viewcount;
                        $viewcount=0;
                        $user_type=Myclass::t('OR718', '', 'or');
                    }

                    if ($utype == "Retailers" || $utype=="Détaillants") {
                        $ret_mount_counts = Yii::app()->db->createCommand() // this query get the total number of items,
                            ->select('count(*) as ret_per_month_count , NOM_TYPE_EN')
                            ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                            ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' AND rs.CREATED_DATE LIKE '%$searchdate%'")
                            ->group('rst.ID_RETAILER_TYPE')
                            ->queryAll();
                        foreach($ret_mount_counts as $ret_mount_count){
                             $viewcount = $viewcount + $ret_mount_count['ret_per_month_count'];
                         }                        
                        $viewcounts =$viewcount;
                        $viewcount= 0;
                        $user_type = Myclass::t('OR720', '', 'or');
                    }

                    array_push($response["viewcounts"], (int) $viewcounts);
                }

                $response['allprofiles'][$key]['name'] = $user_type;
                $response['allprofiles'][$key]['data'] = $response["viewcounts"];
            }
       
        }
        
        

//        $response = array();
//
//        $dates = array();
//        for ($i = 0; $i < 6; $i++) {
//            array_push($dates, date("Y-m-d", strtotime($i . " days ago")));
//        }
//
//        $response['dates'] = array();
//        foreach ($dates as $date) {
//            array_push($response["dates"], $date);
//        }

//        $response['visits'] = array();
//        foreach ($dates as $date) {
//            $criteria = new CDbCriteria();
//            $criteria->addCondition("DATE(loggedin_date) = '" . $date . "' AND rep_credential_id = " . Yii::app()->user->id);
//            $visits = RepLoggedinActivities::model()->count($criteria);
//            array_push($response["visits"], (int) $visits);
//        }

//        $this->render('index', array('response' => $response));
       
          $this->render('index', array('usrinfo' => $usrinfo,'response' => $response));
    }

}
