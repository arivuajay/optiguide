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
                'actions' => array('index', 'forgotPassword', 'error', 'footercount','features', 'contactus'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout','updateadsclick','aboutus', 'legend', 'contactus', 'classifieds'),
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

    public function actionError() {
        $error = Yii::app()->errorHandler->error;
        if ($error)
            $this->render('_error', array('error' => $error));
        else
            throw new CHttpException(404, 'Page not found.');
    }

    public function actionFootercount() {
        
        $profesional_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' ")
                ->queryScalar();

        $retailer_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' ")
                ->queryScalar();

        $supplier_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("f.ID_FOURNISSEUR=ru.ID_RELATION AND f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND bAfficher_site=1 AND ru.NOM_TABLE ='Fournisseurs' and ru.status=1 ")
                ->queryScalar();

        $rep_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from(array('rep_credentials'))
                ->where("rep_role='single' and rep_status='1'")
                ->queryScalar();

        $pk = 1;
        $coun_results = UserCounts::model()->findByPk($pk);
        $coun_results->prof_users = $profesional_count;
        $coun_results->supp_users = $supplier_count;
        $coun_results->ret_users = $retailer_count;
        $coun_results->rep_users = $rep_count;
        $coun_results->save(false);       
        //mail("vasanth@arkinfotec.com","T subject","rep: $rep_count");
    }

    public function actionIndex() {
        $model = new OrLoginForm('login');
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('/optirep/dashboard'));
        
        if (isset($_POST['login'])) {
            $model->attributes = $_POST['OrLoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(array('/optirep/dashboard'));
            }
        }
        $this->render('index', array('model' => $model));
    }

    public function actionFeatures() {
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

    public function actionForgotPassword() {
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('index'));

        $model = new OrLoginForm('forgotpass');

        if (isset($_POST['forgot'])) {
            $model->attributes = $_POST['OrLoginForm'];
            if ($model->validate()) {
                $rep = RepCredentials::model()->findByAttributes(array('rep_username' => $_POST['OrLoginForm']['username']));
                if (empty($rep)) {
                    Yii::app()->user->setFlash('danger', Myclass::t("OR587", "", "or"));
                } else {
                    $rep_profile = $rep->repCredentialProfiles;
                    $rep->rep_password = Myclass::getRandomString(5);
                    $rep->save(false);

                    if (!empty($rep_profile['rep_profile_email'])):
                        //$loginlink = Yii::app()->createAbsoluteUrl('/site/default/login');
                        $mail = new Sendmail;
                        $trans_array = array(
                            "{USERNAME}" => $rep->rep_username,
                            "{NEWPASSWORD}" => $rep->rep_password,
                        );
                        $message = $mail->getMessage('rep_forgot_password', $trans_array);
                        $Subject = $mail->translate('Reset Password');
                        $mail->send($rep_profile['rep_profile_email'], $Subject, $message);
                    endif;

                    Yii::app()->user->setFlash('success', Myclass::t("OR588", "", "or"));
                }
                $this->refresh();
            }
        }
        $this->render('forgotPassword', array('model' => $model));
    }
    
    public function actionClassifieds(){
        $this->layout = '//layouts/column1';
        $this->render('classified');
    }
    
     public function actionupdateadsclick() {
        $ads_id = isset($_POST['id']) ? $_POST['id'] : '';

        if ($ads_id != '' && is_numeric($ads_id)) {
            // Add one count for the loading banner.
            Yii::app()->db
                    ->createCommand("UPDATE publicite_publicite SET CLICK_RATE = CLICK_RATE + 1 WHERE ID_PUBLICITE=:adsId")
                    ->bindValues(array(':adsId' => $ads_id))
                    ->execute();
            echo "success";
            exit;
        }
    }
    

}
