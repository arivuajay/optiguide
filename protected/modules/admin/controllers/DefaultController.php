<?php
/**
 * Site controller
 */
class DefaultController extends Controller {
 
    public $layout = '//layouts/column1';

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'error', 'forgotpassword', 'screens','exceldownload','extractexcelsheet'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'index', 'profile','changepassword'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionExtractexcelsheet()
    {
        $fpath = Yii::getPathOfAlias('webroot').'/uploads/import_datas/Professionals.xls';
        $from = $_REQUEST['from'];
        $to  =  $_REQUEST['to']; 
       echo "between $from - $to \n";
      
        
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($fpath);
        
        $rows =  $data->rowcount(); // 11499
        $cols =  $data->colcount(); // 4
        
          
        for($i=$from;$i<=$to;$i++)
        {
            for($j=1;$j<=$cols;$j++)
            {
                if($j==1)
                {    
                   $client_id  = $data->val($i,$j);
                }
                else if($j==2)
                {  
                   $gender   = $data->val($i,$j); // M or F
                } 
                else if($j==3)
                { 
                   $Envue_Print = $data->val($i,$j); // NO or YES
                }                  
                else if($j==4)
                { 
                   $Envision_Print = ($j==4)?$data->val($i,$j):''; // NO or YES
                } 
            }
//                echo "Client id    : ".$client_id."<br>";
//                echo "gender       : ".$gender."<br>";
//                echo "Envue Print  : ".$Envue_Print."<br>";
//                echo "EnvisionPrint: ".$Envision_Print."<br>";
//                exit;
                
            // Get professional detail
            $prof_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rs.ID_SPECIALISTE,ru.ID_UTILISATEUR,rs.ID_CLIENT,ru.NOM_TABLE,ru.status')
                ->from(array('repertoire_specialiste rs', 'repertoire_utilisateurs as ru'))
                ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND ru.NOM_TABLE ='Professionnels' AND rs.ID_CLIENT=$client_id")
                ->queryRow();
            
            if(!empty($prof_query))
            {
                $uid  = $prof_query['ID_UTILISATEUR'];               
                if($uid!='')
                {   
                    if($Envue_Print=="YES")
                    {
                        $envueprint_flag = 1;
                    }else{
                        $envueprint_flag = 0;
                    } 
                    
                    if($Envision_Print=="YES")
                    {
                        $envisionprint_flag = 1;
                    }else{
                        $envisionprint_flag = 0;
                    } 
                                        
                    $umodel = UserDirectory::model()->findByPk($uid);
                    $umodel->print_envision = $envisionprint_flag;
                    $umodel->print_envue  = $envueprint_flag;
                    $umodel->updatestatus = 1;
                    $umodel->save(false);
                }    
                
                $prof_id = $prof_query['ID_SPECIALISTE'];
                if($prof_id!='' && $gender!='')
                {
                    if($gender=="F")
                    {
                       $gflag = "female";
                    }else{
                       $gflag = "male";
                    }
                    
                    $pmodel = ProfessionalDirectory::model()->findByPk($prof_id);
                    $pmodel->sex = $gflag;
                    $pmodel->save(false);
                }    
            }else{
                $clientids[] = $client_id;
            }    
            
        }  
       echo "Done $from - $to \n";

       echo implode(",",$clientids);
        
    }        

    public function actionIndex() 
    {
        $this->render('index');
    }
    

    public function actionLogin() {
        $this->layout = '//layouts/login';
        
        //$baseurl =  Yii::app()->baseUrl; 
       // 'admin/retailerDirectory/update/id/4';

        if (!Yii::app()->user->isGuest) 
        {
            //$this->redirect(array('/admin/default/index'));  
             $param_str = Yii::app()->getRequest()->getQuery('str');
                if ($param_str!='')
                {  
                    $decodeurl = Myclass::refdecryption($param_str); 
                    $this->redirect($decodeurl);  
                }  
              $this->redirect(array('/admin/default/index'));
               
        }  
        
        $model = new AdminLoginForm();
 //
        if (isset($_POST['sign_in'])) {
            $model->attributes = $_POST['AdminLoginForm'];
            if ($model->validate() && $model->login()):
                
               $param_str = Yii::app()->getRequest()->getQuery('str');
                if ($param_str!='')
                {  
                    $decodeurl = Myclass::refdecryption($param_str); 
                    $this->redirect($decodeurl);  
                }    
                 $this->redirect(array('/admin/default/index'));              
            endif;
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout() 
    {       
        Yii::app()->user->logout();
        $this->redirect(array('/admin/default/login'));
    }

    public function actionForgotpassword() 
    {
        
        $this->layout = '//layouts/login';

        if (!Yii::app()->user->isGuest) 
        {
               $this->redirect(array('/admin/default/index'));
        }
        
        $model = new PasswordResetRequestForm();
        if (isset($_POST['PasswordResetRequestForm'])) 
        {
            $model->attributes = $_POST['PasswordResetRequestForm'];
            if ($model->validate() && $model->authenticate()):                    
                Yii::app()->user->setFlash('success', Myclass::t('APP17'));
                $this->redirect(array('/admin/default/login'));     
            endif;
        }

        $this->render('forgotpassword', array(
            'model' => $model,
        ));
    }
    
    public function actionChangepassword()
    {      
        $id    = Yii::app()->user->id;       
        $model = Admin::model()->findByAttributes(array('admin_id'=>$id));
        $model->setScenario('changepassword');

        if(isset($_POST['Admin']))
        {
            $model->attributes = $_POST['Admin'];              
            if($model->validate())
            {  
                $model->admin_password = Myclass::encrypt($_POST['Admin']['current_password']);
              if($model->save(false))
              {                  
                Yii::app()->user->setFlash('success', Myclass::t('APP18'));
                $this->redirect(array('/admin/default/changepassword'));    
              }else
              {  
                Yii::app()->user->setFlash('error', Myclass::t('APP19'));
                $this->redirect(array('/admin/default/changepassword'));                   
              }   
            }
        }else
        {
             unset($model->admin_password); 
        }

        $this->render('changepassword',array('model'=>$model)); 
    }

    public function actionProfile() 
    {
        $id    = Yii::app()->user->id;
        $model = Admin::model()->findByPk($id);
        $model->setScenario('update');
     
        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            if ($model->validate()):    
                $model->save(false);
                Yii::app()->user->setFlash('success', Myclass::t('APP20'));
                $this->refresh();
            endif;
        }
        $this->render('profile', compact('model'));
    }

    public function actionError() {
        $this->layout = '//layouts/anonymous_page';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
                Yii::app()->end();
            } else {
                $name = Yii::app()->errorHandler->error['code'] . ' Error';
               
                $this->render('error', compact('error', 'name'));
            }
        }
    }

    public function actionScreens($path) {
        if ($path) {
            $this->render('screens', compact('path'));
        }
    }

}