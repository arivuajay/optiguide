<?php

class CronController extends ORController {

    public function actionMynotesReminder() {
        $today = date("Y-m-d");
        $today_notes = RepNotes::model()->findAll("DATE(alert_date) = :today", array(":today" => $today));

        if (!empty($today_notes)) {
            foreach ($today_notes as $today_note) {
                $rep_credential = RepCredentials::model()->findByPk($today_note["rep_credential_id"]);
                $rep_credential_profile = $rep_credential->repCredentialProfiles;

                $client = UserDirectory::model()->findByPk($today_note['ID_UTILISATEUR']);

                if (!empty($rep_credential_profile['rep_profile_email'])):
                    $mail = new Sendmail;
                    $trans_array = array(
                        "{USERNAME}" => $rep_credential['rep_username'],
                        "{CLIENTNAME}" => $client['NOM_UTILISATEUR'],
                        "{MESSAGE}" => $today_note['message'],
                        "{ALERTDATE}" => $today_note['alert_date'],
                        "{CREATEDAT}" => $today_note['created_at']
                    );
                    $message = $mail->getMessage('rep_mynotes_reminder', $trans_array);
                    $Subject = $mail->translate('OptiRep - My Notes Reminder');
                    $mail->send($rep_credential_profile['rep_profile_email'], $Subject, $message);
                endif;
            }
        }
        exit;
    }

    public function actionAccountExpiryReminder() {
        $today = date("Y-m-d");
        
        //get expiry accounts, with in 5 days from today.
        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT * FROM rep_credentials WHERE `rep_role` = "' . RepCredentials::ROLE_SINGLE . '" AND `rep_status` = "1" AND `rep_expiry_date` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 5 DAY)');

        $rep_credentials = $command->queryAll();

        if (!empty($rep_credentials)) {
            foreach ($rep_credentials as $rep_credential) {
                $rep_detail = RepCredentials::model()->findByPk($rep_credential['rep_credential_id']);
                $rep_profile_detail = $rep_detail->repCredentialProfiles;
                
                if (!empty($rep_profile_detail['rep_profile_email'])):
                    $mail = new Sendmail;
                    $trans_array = array(
                        "{USERNAME}" => $rep_detail['rep_username'],
                        "{EXPIRYDATE}" => Myclass::dateFormat($rep_detail['rep_expiry_date']),
                        "{NEXTSTEPURL}" => REPURL,
                    );
                    $message = $mail->getMessage('rep_account_expiry_reminder', $trans_array);
                    $Subject = $mail->translate('OptiRep - Account Expiry Reminder');
                    $mail->send($rep_profile_detail['rep_profile_email'], $Subject, $message);
                endif;
            }
        }
        exit;
    }

}
