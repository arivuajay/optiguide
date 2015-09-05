<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
*/

class ORController extends Controller {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column2';
    public $lang   = "EN";

    public function init() {
        parent::init();
        
//        $app = Yii::app();
//        if (isset($_POST['_lang']))
//        {
//            $app->language = $_POST['_lang'];
//            $app->session['_lang'] = $app->language;
//            Yii::app()->session['language'] = strtoupper($app->language); 
//            
//        }
//        else if (isset($app->session['_lang']))
//        {
//            $app->language = $app->session['_lang'];
//            Yii::app()->session['language'] = strtoupper($app->language); 
//        }else
//        {
//            $app->language = 'en';
//            Yii::app()->session['language'] = strtoupper($app->language);
//        }    
    }

}
