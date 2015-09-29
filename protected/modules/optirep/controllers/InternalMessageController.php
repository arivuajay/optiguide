<?php

class InternalMessageController extends ORController {

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

        $this->performAjaxValidation(array($model));
      
        if (isset($_POST['btnSubmit'])) {
            
            $model->attributes = $_POST['InternalMessage'];
            $valid = $model->validate();
            if ($valid) {
             
                // Genreate the conversation id
                $criteria=new CDbCriteria;
                $criteria->select='max(id1) AS maxColumn';
                $row = InternalMessage::model()->find($criteria);
                $npm_count = $row['maxColumn'];
                $id1 = $npm_count+1;              
                
                // Get sender detail
                $sess_id    = Yii::app()->user->id;
                $condition  = " NOM_TABLE='rep_credentials' AND ID_RELATION='$sess_id' ";
                $ufrm_infos = UserDirectory::model()->find($condition);
                
                $model->message = nl2br($_POST['InternalMessage']['message']);
                // conversation id
                $model->id1   = $id1;
                // New conversation start        
                $model->id2   = 1;
                // Sender
                $model->user1 = $ufrm_infos->ID_UTILISATEUR;
                // Receiver   (the value send through post)    
                //$model->user2 
                $model->timestamp = time();
                $model->user1read = "yes";
                $model->user2read = "no";
                
                $model->save(false);     
                
                // Get rep infos
                $ret_prof_id = $model->user2;
                $rcondition  = " NOM_TABLE='rep_credentials' AND ID_RELATION='$ret_prof_id' ";
                $ret_infos   = UserDirectory::model()->find($rcondition);
                $ret_name    = $ret_infos->NOM_UTILISATEUR;
                $ret_email   = $ret_infos->COURRIEL;
                $todaydate   = date("d-m-Y");
              
                if($ret_email!= '')
                {    
                    /* Send notification mail to rep */
                    $mail         = new Sendmail();
                    $nextstep_url = GUIDEURL.'/optiguide/internalMessage/readmessage/convid/' .$model->id1;           
                    $subject      = SITENAME." - ".$ufrm_infos->NOM_UTILISATEUR." sent message for you ( ".$todaydate." )";
                    $trans_array  = array(
                        "{SITENAME}" => SITENAME,
                        "{NAME}"     => $ufrm_infos->NOM_UTILISATEUR,
                        "{RNAME}"    => $ret_name,
                        "{MESSAGE}"  => $conv_message,
                        "{NEXTSTEPURL}" => $nextstep_url,
                    );
                    $message = $mail->getMessage('internalmessage_notify', $trans_array);
                    $mail->send($ret_email, $subject, $message);
                } 

                Yii::app()->user->setFlash('success', "Message send successfully!!!");
                $this->redirect(array('index'));
                
            }
            
        }
        
        $this->render('create',array('model' => $model));
    }
    
     public function actionReadmessage() {
        
        $model = new InternalMessage;
        
        $sess_id    = Yii::app()->user->id;
        $condition  = " NOM_TABLE='rep_credentials' AND ID_RELATION='$sess_id' ";
        $ufrm_infos = UserDirectory::model()->find($condition);
        $session_userid = $ufrm_infos->ID_UTILISATEUR;
        
        $convid = Yii::app()->getRequest()->getQuery('convid');
        
        
         if (isset($_POST['btnSubmit'])) {

            $model->attributes = $_POST['InternalMessage'];
            $valid = $model->validate();
            if ($valid) {
            
                // conversation id
                $conv_message   = nl2br($_POST['InternalMessage']['message']);
                $model->message = $conv_message;
               
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
                $ret_prof_id = $model->user2;
                $ret_infos   = UserDirectory::model()->findByPk($ret_prof_id);
                $ret_name    = $ret_infos->NOM_UTILISATEUR;
                $ret_email   = $ret_infos->COURRIEL;
                $todaydate   = date("d-m-Y");
              
                if($ret_email!= '')
                {    
                    /* Send notification mail to rep */
                    $mail         = new Sendmail();
                    $nextstep_url = GUIDEURL.'optiguide/internalMessage/readmessage/convid/' .$model->id1;           
                    $subject      = SITENAME." - ".$ufrm_infos->NOM_UTILISATEUR." sent message for you ( ".$todaydate." )";
                    $trans_array  = array(
                        "{SITENAME}" => SITENAME,
                        "{NAME}"     => $ufrm_infos->NOM_UTILISATEUR,
                        "{RNAME}"    => $ret_name,
                        "{MESSAGE}"  => $conv_message,
                        "{NEXTSTEPURL}" => $nextstep_url,
                    );
                    $message = $mail->getMessage('internalmessage_notify', $trans_array);
                    $mail->send($ret_email, $subject, $message);
                } 

                Yii::app()->user->setFlash('success', "Message send successfully!!!");
                $this->redirect(array('index'));
            }
        }
        
        // Get the message conversations
        $mymessages = array();
        if(isset($convid))
        {          
           $id1      = intval($convid);
           $msginfo  = InternalMessage::model()->findAllByAttributes(array('id1'=> $id1 , 'id2'=>"1" ));
           $msgcount = count($msginfo);
            //We check if the discussion exists
            if($msgcount==1)
            {
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
                    
                    
                } else {
                    Yii::app()->user->setFlash('danger', 'You dont have the rights to access this page.!');
                    $this->redirect(array('index'));
                }
                            
            }else
            {
                Yii::app()->user->setFlash('danger', 'This discussion does not exists!');
                $this->redirect(array('index'));
            }
        
        }else
        {
            Yii::app()->user->setFlash('danger', 'This discussion does not exists!');
            $this->redirect(array('index'));
        }    
        
         
          $this->render('read_message',array('model'=>$model,'mymessages'=>$mymessages, 'user1_id'=>$u1 , 'user2_id'=>$u2 , 'uid' => $session_userid));;
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
