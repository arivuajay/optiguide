<?php

class DefaultController extends OGController {
    
    public function actionForgetpassword()
    {
        
        $model = new Advertise;

        $this->performAjaxValidation(array($model));

        if (isset($_POST['Advertise'])) 
        {
            $model->attributes = $_POST['Advertise'];

            /* Send request mail to admin for advertise */
            $mail = new Sendmail();
            $subject = SITENAME . " - Forget password request from " . $model->name;
            $trans_array = array(
                "{SITE}" => SITENAME,
                "{NAME}" => $model->name,
                "{EMAIL}" => $model->email,
                "{TELEPHONE}" => $model->telephone,
                "{MESSAGE}" => $model->informations,
            );
            $message = $mail->getMessage('advertise', $trans_array);
            $mail->send(ADMIN_EMAIL, $subject, $message, $model->name, $model->email);

            Yii::app()->user->setFlash('success', Myclass::t('OGO79', '', 'og'));
            $this->redirect(array('advertise'));
        }

       // $this->render('_forgetpassword', compact('model'));
        
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
            $model->attributes = $_POST['ContactForm'];

            /* Send request mail to admin for advertise */
            $mail = new Sendmail();
            $subject = SITENAME . " - Contact from " . $model->name;
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
            $model->attributes = $_POST['Advertise'];

            /* Send request mail to admin for advertise */
            $mail = new Sendmail();
            $subject = SITENAME . " - Advertise request from " . $model->name;
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
