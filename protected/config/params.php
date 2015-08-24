<?php

$whitelist = array('127.0.0.1', '::1');
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    $mailsendby = 'smtp';
    $adminurl   = 'http://localhost/optiguide/branches/dev/';
    $repurl = 'http://local.optirep'; 
    
} else {
    $mailsendby = 'phpmail';
     $adminurl   = 'http://demo.arkinfotec.in/optiguide/';
     $repurl =  'http://optirep.arkinfotec.in'; 
}



// Custom Params Value
return array(
    //Global Settings
    'EMAILLAYOUT' => 'file', // file(file concept) or db(db_concept)
    'EMAILTEMPLATE' => '/mailtemplate/',
    'MAILSENDBY' => $mailsendby,
    //EMAIL Settings
    'SMTPHOST' => 'smtp.gmail.com',
    'SMTPPORT' => '465', // Port: 465 or 587
    'SMTPUSERNAME' => 'marudhuofficial@gmail.com',
    'SMTPPASS' => 'ninja12345',
    'SMTPAUTH' => true, // Auth : true or false
    'SMTPSECURE' => 'ssl', // Secure :tls or ssl
    'NOREPLYMAIL' => 'noreply@express2help.com',
    'SITENAME' => 'Optiguide.com',
    'JS_SHORT_DATE_FORMAT' => 'yy-mm-dd',
    'PHP_SHORT_DATE_FORMAT' => 'Y-m-d',
    'FB_APP_ID' => $fb_app_id,
    'FB_SECRET_ID' => $fb_sec_id,
    'GOOGLE_APP_ID' => $google_app_id,
    'GOOGLE_SECRET_ID' => $google_sec_id,
    'ADMIN_EMAIL'   => 'vasanth@arkinfotec.com',
    'ADMIN_URL'  => $adminurl,
   
    
    //
    //Product Settings
    'ARCHIVE_IMG_PATH' => 'uploads/archivage/',
    'JOURNAL_IMG_PATH' => 'uploads/journal/',
    'COPYRIGHT' => '&copy; 2014 Express2Help.',
    'EMAILHEADERIMAGE' => '/themes/site/css/frontend/img/logos/header-logo.png',
    
    'LISTPERPAGE' => 15,
    'DEFAULTPAYS' => 1,    
    'REPURL' => $repurl,
    
    //Paypal values
    'SANDBOXVALUE'  => TRUE,
    'CURRENCY'      => 'CAD',
    'BUSINESSEMAIL' => 'vasanth@arkinfotec.com', 
);

