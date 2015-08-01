<?php

$whitelist = array('127.0.0.1', '::1');
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    $mailsendby = 'smtp';
} else {
    $mailsendby = 'phpmail';
}
if (strpos($_SERVER['SERVER_NAME'], 'cherrybells.in') !== false) {
    $fb_app_id = '1539995622943889';
    $fb_sec_id = '110c466a1ee59dbb1cae307b216d1c2b';
    
    $google_app_id = '675517855666-ndue37r1cdhn72es30r1kkk545sm8ooi.apps.googleusercontent.com';
    $google_sec_id = 'ahTkPog54J_DcMGI5NU-dSwk';
} elseif (strpos($_SERVER['SERVER_NAME'], 'express2help.com') !== false) {
    $fb_app_id = '333663073505578';
    $fb_sec_id = '14209990fc94997b6bb83061865a3886';
    
    $google_app_id = '';
    $google_sec_id = '';
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
    'SITENAME' => 'Optiguide',
    'JS_SHORT_DATE_FORMAT' => 'yy-mm-dd',
    'PHP_SHORT_DATE_FORMAT' => 'Y-m-d',
    'FB_APP_ID' => $fb_app_id,
    'FB_SECRET_ID' => $fb_sec_id,
    'GOOGLE_APP_ID' => $google_app_id,
    'GOOGLE_SECRET_ID' => $google_sec_id,
    //
    //Product Settings
    'ARCHIVE_IMG_PATH' => 'uploads/archivage/',
    'JOURNAL_IMG_PATH' => 'uploads/journal/',
    'COPYRIGHT' => '&copy; 2014 Express2Help.',
    'EMAILHEADERIMAGE' => '/themes/site/css/frontend/img/logos/header-logo.png',
    
    'LISTPERPAGE' => 15,
    'DEFAULTPAYS' => 1,
);

