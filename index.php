<?php

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

if (strpos($_SERVER['HTTP_HOST'], 'localhost:7000') !== false) {
    $modules = array('optiguide');
    $def_mod = 'optiguide';
} elseif (strpos($_SERVER['HTTP_HOST'], 'localhost:7001') !== false) {
    $modules = array('optirep');
    $def_mod = 'optirep';
} else {
    $modules = array('admin');
    $def_mod = 'admin';
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
