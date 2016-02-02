<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Opti-Guide',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
       ENABLE_MODULES,
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'optiguide',
            'generatorPaths' => array('application.gii'),
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'clientScript' => array(
            'packages' => array(
                'jquery' => array(
                    'baseUrl' => '//code.jquery.com/',
                    'js' => array('jquery-1.10.1.min.js', 'jquery-migrate-1.2.1.min.js'),
                ),
            )
        ),
        'booster' => array(
            'class' => 'application.extensions.yiibooster.components.Booster',
            'yiiCss' => false
        ),
        //
        //local mail components
        //
        'admin' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('/'.DEFAULT_MODULE.'/default/login'),
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/default/login'),
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => require(dirname(__FILE__) . '/urlManager.php'),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        
        'errorHandler' => array(
            'errorAction' => DEFAULT_MODULE.'/default/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class'=>'CProfileLogRoute',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    //setting the basic language value
    'defaultController' => DEFAULT_MODULE.'/default/index',
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
   // 'timeZone' => 'Asia/Calcutta',
    'timeZone' => 'America/New_York',
    'theme' => 'adminlte',
    'sourceLanguage' => '00',
    'language' => 'fr',
);
