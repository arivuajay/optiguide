<?php
//error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
// change the following paths if necessary
$yii = dirname(__FILE__) . '/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';
include_once(dirname(__FILE__) . '/protected/config/constants.php');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);

$optiguide_array = array('local.optiguide', 'optiguide.arkinfotec.in' , 'optiguide.opti-guide.info','opti-guide.com','www.opti-guide.com');
$optirep_array   = array('local.optirep', 'optirep.arkinfotec.in' , 'optirep.opti-guide.info' , 'opti-rep.com' , 'www.opti-rep.com');
$optiadmin_array = array('local.optiadmin', 'optiadmin.arkinfotec.in','optiadmin.opti-guide.info','webadmin.opti-guide.com','webadmin.opti-guide.com');

if (in_array($_SERVER['HTTP_HOST'], $optiadmin_array)) {

    $modules = array('admin');
    $def_mod = 'admin';
    define('SITENAME', 'OptiGuide Admin');
    
} elseif (in_array($_SERVER['HTTP_HOST'], $optirep_array)) {
    $modules = array('optirep');
    $def_mod = 'optirep';
    define('SITENAME', 'OptiRep');
} else {

    $modules = array('optiguide');
    $def_mod = 'optiguide';
    define('SITENAME', 'OptiGuide');
    
}

if ($modules) {
    defined('ENABLE_MODULES') ||
            @define('ENABLE_MODULES', implode(',', $modules));
    defined('DEFAULT_MODULE') ||
            @define('DEFAULT_MODULE', $def_mod);
}

$app = Yii::createWebApplication($config);

defined('SITEURL') ||
        @define('SITEURL', Yii::app()->createAbsoluteUrl("/"));

defined('DS') ||
        @define('DS', DIRECTORY_SEPARATOR);

$app->run();
