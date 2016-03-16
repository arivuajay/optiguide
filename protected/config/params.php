<?php

$whitelist = array('127.0.0.1', '::1');
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    $mailsendby = 'smtp';
    $adminurl   = 'http://local.optiadmin/';
    $repurl     = 'http://local.optirep/'; 
    $guideurl   = 'http://local.optiguide/'; 
    $adminemail = 'vasanth@arkinfotec.com';
} else {
    $mailsendby  = 'phpmail';
     $adminurl   = 'http://webadmin.opti-guide.com/';
     $repurl     = 'http://opti-rep.com/'; 
     $guideurl   = 'http://opti-guide.com/'; 
     $adminemail = 'bretoncom2@gmail.com';
}

// Custom Params Value
return array(
    //Global Settings
    'EMAILLAYOUT' => 'file', // file(file concept) or db(db_concept)
    'EMAILTEMPLATE' => '/mailtemplate/',
    'EMAILTEMPLATE_EN' => '/mailtemplate/en/',
    'EMAILTEMPLATE_FR' => '/mailtemplate/fr/',
    
    'MAILSENDBY' => $mailsendby,
    //EMAIL Settings
    'SMTPHOST' => 'smtp.gmail.com',
    'SMTPPORT' => '465', // Port: 465 or 587
    'SMTPUSERNAME' => 'marudhuofficial@gmail.com',
    'SMTPPASS' => 'ninja12345',
    'SMTPAUTH' => true, // Auth : true or false
    'SMTPSECURE' => 'ssl', // Secure :tls or ssl
    'NOREPLYMAIL' => 'noreply@optiguide.com',
//    'SITENAME' => 'Optiguide.com',
    'JS_SHORT_DATE_FORMAT' => 'yy-mm-dd',
    'PHP_SHORT_DATE_FORMAT' => 'Y-m-d',
//    'FB_APP_ID' => $fb_app_id,
//    'FB_SECRET_ID' => $fb_sec_id,
//    'GOOGLE_APP_ID' => $google_app_id,
//    'GOOGLE_SECRET_ID' => $google_sec_id,
//    'ADMIN_EMAIL'   => 'vasanth@arkinfotec.com',
    'ADMIN_EMAIL'   => $adminemail,
//info@bretoncom.com
    'ADMIN_URL'  => $adminurl,   
    
    //Product Settings
    'ARCHIVE_IMG_PATH' => 'uploads/archivage/',
    'JOURNAL_IMG_PATH' => 'uploads/journal/',
    'COPYRIGHT' => '&copy; 2015 Optiguide.',
    'EMAILHEADERIMAGE_REP' => 'themes/optiguide/images/opti-rep-logo.png',
    'EMAILHEADERIMAGE_GUIDE' => 'themes/optiguide/images/opti-guide.png',
    
    'DEFAULTPAYS' => 1,    
    'REPURL' => $repurl,
    'GUIDEURL' => $guideurl,
    
    'CALANDERLISTPERPAGE' => 14,
    'LISTPERPAGE' => 15,
    'PAGE_SIZE' => 15,
    'GROUPSLISTPERPAGE' => 20,
    'SUPPLIERSLISTPERPAGE' => 21,
    'CATEGORIESLISTPERPAGE' => 22,
    'MARQUESLISTPERPAGE' => 23,
    'PROFESSIONALLISTPERPAGE' => 26,
    'RETAILERSLISTPERPAGE' => 27,
    
    //Paypal values
//    'SANDBOXVALUE'  => TRUE,
//    'CURRENCY'      => 'CAD',
//    'BUSINESSEMAIL' => 'vasanth@arkinfotec.com', 
    
    //Paypal values
    'SANDBOXVALUE'  => FALSE,
    'CURRENCY'      => 'CAD',
//    'BUSINESSEMAIL' => 'vasanth@arkinfotec.com', 
    'BUSINESSEMAIL' => 'martine@bretoncom.com', 
    
    // retailer logo path
    'RET_IMG_PATH' => 'uploads/retailer_logos/',
    
    // Proof uploaded path
    'PROOF_PATH' => 'uploads/user_proofs/',
    
    // Professional Alert files
    'ATTACH_PATH' => 'uploads/alerts_attachments/',
    
    //REP PROFILE PICTURE
    'REP_PROFILE_PICTURE' => 'uploads/rep_profile_pictures/',
    
     //Export datas
    'EXPORTDATAS' => 'uploads/export_datas/',
    
    'ADMINSITENAME' => 'Optiguide Admin',
    'OPTIGUIDESITENAME' => 'Optiguide',
    'OPTIREPSITENAME' => 'Optirep',
);
