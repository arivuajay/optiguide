<?php

class InternalMessageController extends OGController {

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
                'actions' => array('index', 'createnew', 'readmessage'),
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
    
    public function actionCreatenew() {

        $model = new InternalMessage;

        if (isset($_POST['SendMessage'])) {

            $model->attributes = $_POST['InternalMessage'];

            // Genreate the conversation id
            $criteria = new CDbCriteria;
            $criteria->select = 'max(id1) AS maxColumn';
            $row = InternalMessage::model()->find($criteria);
            $npm_count = $row['maxColumn'];
            $id1 = $npm_count + 1;

            // Get sender detail
            $sess_id    = Yii::app()->user->id;
            $condition  = "";
            
            if(Yii::app()->user->role == "Professionnels")
            $condition  = "status=1 AND NOM_TABLE ='Professionnels' AND ID_RELATION='$sess_id' ";
            elseif(Yii::app()->user->role == "Fournisseurs")
            $condition  = "status=1 AND NOM_TABLE ='Fournisseurs' AND status=1 AND ID_RELATION='$sess_id' ";
            elseif(Yii::app()->user->role == "Detaillants")
            $condition  = "status=1 AND NOM_TABLE ='Detaillants' AND ID_RELATION='$sess_id' ";
                
            if($condition!="")
            {    
            
                $ufrm_infos = UserDirectory::model()->find($condition);

                $conv_message = nl2br($_POST['InternalMessage']['message']);
                $model->message = $conv_message;
                // conversation id
                $model->id1 = $id1;
                // New conversation start        
                $model->id2 = 1;
                // Sender
                $model->user1 = $ufrm_infos->ID_UTILISATEUR;
                // Receiver   (the value send through post)    
                //$model->user2 
                $model->timestamp = time();
                $model->user1read = "yes";
                $model->user2read = "no";

                $model->save(false);

                // Get user infos
                $ret_prof_id = $model->user2;
                $ret_infos = UserDirectory::model()->findByPk($ret_prof_id);
                $ret_name  = $ret_infos->NOM_UTILISATEUR;
                $ret_email = $ret_infos->COURRIEL;
                $todaydate = date("d-m-Y");

                $redirect_id = $ret_infos->ID_RELATION;

                $identy_user = $ret_infos->NOM_TABLE;

                $directoryname = "suppliersDirectory";

                if ($ret_email != '') {

                    $this->lang = Yii::app()->session['language'];
                    /* Send notification mail to rep */
                    $mail = new Sendmail();
                    $nextstep_url = REPURL . 'optirep/internalMessage/readmessage/convid/' . $model->id1;

                    if($this->lang=='EN'){
                        $subject = SITENAME." - ".Yii::app()->user->name." sent message for you ( ".$todaydate." )";
                    }else if($this->lang=='FR'){
                        $subject = SITENAME . " - Vous avez un nouveau message";
                    }
                    $trans_array = array(
                        "{SITENAME}" => SITENAME,
                        "{NAME}" => $ufrm_infos->NOM_UTILISATEUR,
                        "{RNAME}" => $ret_name,
                        "{MESSAGE}" => $conv_message,
                        "{NEXTSTEPURL}" => $nextstep_url,
                    );
                    $message = $mail->getMessage('internalmessage_notify', $trans_array);
                   // $mail->send($ret_email, $subject, $message);
                }

                Yii::app()->user->setFlash('success', Myclass::t("OR615", "", "or"));
                $this->redirect(array($directoryname . '/view', 'id' => $redirect_id));
            }else{
                Yii::app()->user->setFlash('danger', "You are not authenticated user to send message.");
                $this->redirect(array($directoryname . '/view', 'id' => $redirect_id));
            }      
        }
    }

    public function actionReadmessage() {
        $model = new InternalMessage;

        $session_userid = Yii::app()->user->id;
        $convid = Yii::app()->getRequest()->getQuery('convid');

        $this->performAjaxValidation(array($model));

        if (isset($_POST['btnSubmit'])) {

            $model->attributes = $_POST['InternalMessage'];
            $valid = $model->validate();
            if ($valid) {
             
                $conv_message   = nl2br($_POST['InternalMessage']['message']);
                $model->message = $conv_message;
                // conversation id
                $model->id1 = $convid;
                // Sender
                $model->user1 = $session_userid;
                // Receiver   (the value send through post)    
                //$model->user2 
                $model->timestamp = time();
                $model->user1read = "yes";
                $model->user2read = "no";
                              
                $model->save(false);
                
                // Get rep infos
                $rep_id     = $model->user2;
                $ufrm_infos = UserDirectory::model()->findByPk($rep_id);
                $rep_name   = $ufrm_infos->NOM_UTILISATEUR;
                $rep_email  = $ufrm_infos->COURRIEL;
                $todaydate  = date("d-m-Y");
                
                if($rep_email!= '')
                {    
                    $this->lang = Yii::app()->session['language'];
                    /* Send notification mail to rep */
                    $mail         = new Sendmail();
                    $nextstep_url = REPURL.'optirep/internalMessage/readmessage/convid/' .$model->id1; 
                    if($this->lang=='EN'){
                        $subject      = SITENAME." - ".Yii::app()->user->name." sent message for you ( ".$todaydate." )";
                    }else if($this->lang=='FR'){
                        $subject = SITENAME . " - Vous avez un nouveau message";
                    }
                    
                    $trans_array  = array(
                        "{SITENAME}" => SITENAME,
                        "{NAME}"     => Yii::app()->user->name,
                        "{RNAME}"    => $rep_name,
                        "{MESSAGE}"  => $conv_message,
                        "{NEXTSTEPURL}" => $nextstep_url,
                    );
                    $message = $mail->getMessage('internalmessage_notify', $trans_array);
                    $mail->send($rep_email, $subject, $message);
                }    
          
                Yii::app()->user->setFlash('success', "Message send successfully!!!");
                $this->redirect(array('index'));
            }
        }

        $mymessages = array();
        if (isset($convid)) {
            $id1 = intval($convid);
            $msginfo = InternalMessage::model()->findAllByAttributes(array('id1' => $id1, 'id2' => "1"));
            $msgcount = count($msginfo);
            //We check if the discussion exists
            if ($msgcount == 1) {
                
                foreach($msginfo as $uids)
                {    
                   $u1 = $uids['user1'];
                   $u2 = $uids['user2'];
                }                
                
                if($u1 == $session_userid ||  $u2 == $session_userid)
                {
                    $mymessages = Yii::app()->db->createCommand() //this query contains all the data
                        ->select('pm.timestamp, pm.message, users.ID_UTILISATEUR as userid, users.NOM_UTILISATEUR')
                        ->from(array('internal_message pm', 'repertoire_utilisateurs users'))
                        ->where("pm.id1='$id1' and users.ID_UTILISATEUR=pm.user1")
                        ->order('pm.id2')
                        ->queryAll();                    
                    
                    $user1_id =  $msginfo['user1'];
                    $user2_id =  $msginfo['user2']; 
                }else {
                    Yii::app()->user->setFlash('danger', 'You dont have the rights to access this page.!');
                    $this->redirect(array('index'));
                }
            } else {               
                Yii::app()->user->setFlash('danger', 'This discussion does not exists!');
                $this->redirect(array('index'));
            }
        } else {
            Yii::app()->user->setFlash('danger', 'This discussion does not exists!');
            $this->redirect(array('index'));
        }


        $this->render('read_message', array('model' => $model, 'mymessages' => $mymessages, 'user1_id'=>$u1 , 'user2_id'=>$u2));
    }

    /**
     * Performs the AJAX validation.
     * @param ArchiveCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'internal-message-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
