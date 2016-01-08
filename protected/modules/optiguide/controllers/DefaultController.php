<?php

class DefaultController extends OGController {
    
    public $lang;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        $this->lang = Yii::app()->session['language'];
    }   
    public function actionExpireValidate()
    {
        $today = date("Y-m-d h:i:s");
        // 3 years
        $days  = 1095;
        
        // For profesional expiry count
        $prof_count = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('count(*) as count')
                    ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                    ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 and ru.MUST_VALIDATE=1 AND ru.NOM_TABLE ='Professionnels' and (DATEDIFF('$today', DATE_MODIFICATION))>$days")
                    ->queryScalar();
        
        if($prof_count>0)
        {    
            // For profesional
            $prof_query = Yii::app()->db->createCommand() //this query contains all the data
                        ->select("ru.ID_UTILISATEUR,rs.ID_SPECIALISTE,DATE_MODIFICATION,DATEDIFF('$today', DATE_MODIFICATION) AS last_mdfy_days")
                        ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                        ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 and ru.MUST_VALIDATE=1 AND ru.NOM_TABLE ='Professionnels' and (DATEDIFF('$today', DATE_MODIFICATION))>$days")
                        ->order('rs.ID_SPECIALISTE')                   
                        ->queryAll();

           foreach($prof_query as $infos)
           {       
               $uid = $infos['ID_UTILISATEUR'];
               $model = UserDirectory::model()->findByPk($uid);
               $model->MUST_VALIDATE = 0;
               $model->save(false);
           } 
        }
        
        // For retailer
         $retail_count = Yii::app()->db->createCommand() //this query contains all the data
                        ->select('count(*) as count')
                        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                        ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1  and ru.MUST_VALIDATE=1 AND ru.NOM_TABLE ='Detaillants' and (DATEDIFF('$today', DATE_MODIFICATION))>$days")                                      
                        ->queryScalar();
         
        if($retail_count > 0)
        {    
        
            $retail_query = Yii::app()->db->createCommand() //this query contains all the data
                    ->select("ru.ID_UTILISATEUR,rs.ID_RETAILER,DATE_MODIFICATION,DATEDIFF('$today', DATE_MODIFICATION) AS last_mdfy_days")
                    ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                    ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1  and ru.MUST_VALIDATE=1 AND ru.NOM_TABLE ='Detaillants' and (DATEDIFF('$today', DATE_MODIFICATION))>$days")
                    ->order('rs.ID_RETAILER')                
                    ->queryAll();
            
           foreach($retail_query as $rinfos)
           {       
               $uid = $rinfos['ID_UTILISATEUR'];
               $umodel = UserDirectory::model()->findByPk($uid);
               $umodel->MUST_VALIDATE = 0;
               $umodel->save(false);
           } 
        }    
        

    }        
    
    public function actionConfirmation($id)
    {
        
        if ($id != '')
        {            
            $criteria = new CDbCriteria;
            $criteria->condition = "status='0' AND sGuid='" . $id . "'";           

            $userinfos = UserDirectory::model()->find($criteria);

            if (!empty($userinfos)) 
            {
                $userinfos->status = 1;
                $userinfos->save(false);
                
                Yii::app()->user->setFlash('success', Myclass::t('OG180'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('info', Myclass::t('OG181'));
                $this->redirect(array('index'));
            }
            
        } else {
            $this->redirect(array('index'));
        }
        
    }        

    public function actionIndex() {
        $searchModel = new SuppliersDirectory();
        $this->render('index', array('searchModel' => $searchModel));
    }

    public function actionError() {
        $error = Yii::app()->errorHandler->error;
        if ($error)
            $this->render('_error', array('error' => $error));
        else
            throw new CHttpException(404, 'Page not found.');
    }

    public function actionClientprofile($id) {

        if ($id != '') {
            $criteria = new CDbCriteria;
            $criteria->condition = "randkey='" . $id . "'";
            $criteria->with = array(
                "clientProfiles" => array(
                    'alias' => 'clientProfiles',
                    'select' => 'clientProfiles.*'
                ),
            );

            $messageinfos = ClientMessages::model()->find($criteria);

            if (!empty($messageinfos)) {
                $messageinfos->user_view_status = 1;
                $messageinfos->status = 0;
                $messageinfos->save(false);

                $this->render('_clientprofile', compact('messageinfos'));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    public function actionProfessionalprofile($id) {

        if ($id != '') {
            $criteria = new CDbCriteria;
            $criteria->condition = "randkey='" . $id . "'";
            $criteria->with = array(
                "professionalDirectory" => array(
                    'alias' => 'professionalDirectory',
                    'select' => 'professionalDirectory.*'
                ),
            );

            $messageinfos = ProfessionalMessages::model()->find($criteria);

            if (!empty($messageinfos)) {
                $messageinfos->user_view_status = 1;
                $messageinfos->status = 0;
                $messageinfos->save(false);

                $this->render('_professionalprofile', compact('messageinfos'));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    public function actionRetailerprofile($id) {

        if ($id != '') {
            $criteria = new CDbCriteria;
            $criteria->condition = "randkey='" . $id . "'";
            $criteria->with = array(
                "retailerDirectory" => array(
                    'alias' => 'retailerDirectory',
                    'select' => 'retailerDirectory.*'
                ),
            );

            $messageinfos = RetailerMessages::model()->find($criteria);

            if (!empty($messageinfos)) {
                $messageinfos->user_view_status = 1;
                $messageinfos->status = 0;
                $messageinfos->save(false);

                $this->render('_retailerprofile', compact('messageinfos'));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    public function actionSubscribe() {

        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('index'));
        }

        $this->render('subscribe');
    }

    public function actionAccess() {
        //echo Yii::app()->createUrl('/optiguide/default/updateadsclick');
        echo Yii::app()->createAbsoluteUrl('/optiguide/default/access');
        exit;
    }

    public function actionContactus() {
        $model = new ContactForm;
        $this->performAjaxValidation(array($model));

        if (isset($_POST['ContactForm'])) {
            $this->lang = Yii::app()->session['language'];
            $model->attributes = $_POST['ContactForm'];

            /* Send request mail to admin for advertise */
            $mail = new Sendmail();
            
            if($this->lang=='EN' ){
                $subject = SITENAME . " - Contact from " . $model->name;
            }elseif($this->lang=='FR'){
                $subject = SITENAME . " - Demande de contact d’un utilisateur";
            }
            
            $trans_array = array(
                "{SITE}" => SITENAME,
                "{NAME}" => $model->name,
                "{EMAIL}" => $model->email,
                "{PHONE}" => $model->phone,
                "{MESSAGE}" => $model->message,
            );
            $message = $mail->getMessage('contactform', $trans_array);
            $mail->send(ADMIN_EMAIL, $subject, $message, $model->name, $model->email);

            Yii::app()->user->setFlash('success', Myclass::t('OGO79', '', 'og'));
            $this->redirect(array('contactus'));
        }
        $this->render('contactus', compact('model'));
    }

    public function actionTermsandconditions() {
        $this->render('terms');
    }

    public function actionAdvertise() {

        $model = new Advertise;

        $this->performAjaxValidation(array($model));

        if (isset($_POST['Advertise'])) {
            $this->lang = Yii::app()->session['language'];
            $model->attributes = $_POST['Advertise'];

            /* Send request mail to admin for advertise */
            $mail = new Sendmail();
            
            if($this->lang=='EN' ){
                $subject = SITENAME . " - Advertise request from " . $model->name;
            }elseif($this->lang=='FR'){
                $subject = SITENAME . " - Bannière publicitaire sur le site";
            }
            
            $trans_array = array(
                "{SITE}" => SITENAME,
                "{NAME}" => $model->name,
                "{EMAIL}" => $model->email,
                "{TELEPHONE}" => $model->telephone,
                "{MESSAGE}" => $model->informations,
                "{POSITION}" => $model->position,
            );
            $message = $mail->getMessage('advertise', $trans_array);
            $mail->send(ADMIN_EMAIL, $subject, $message, $model->name, $model->email);

            Yii::app()->user->setFlash('success', Myclass::t('OGO79', '', 'og'));
            $this->redirect(array('advertise'));
        }

        $this->render('advertise', compact('model'));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index');
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
    
    public function actionClassifieds(){
        $this->render('classified');
    }

    /**
     * Performs the AJAX validation.
     * @param RetailerDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'advertise-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
