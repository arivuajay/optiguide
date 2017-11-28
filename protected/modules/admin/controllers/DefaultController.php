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
                'actions' => array('login', 'error', 'forgotpassword', 'screens','exceldownload','extractexcelsheet','extractexcelsheet_client','extractexcelsheet_clientid'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'index', 'profile','changepassword',"clientprofile","professionalprofile","retailerprofile"),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionExtractexcelsheet_clientid()
    {
        
        
        header('Content-type: text/html; charset=UTF-8') ;
        $fpath = Yii::getPathOfAlias('webroot').'/uploads/import_datas/Advertisers_List.xls';
        $from = $_REQUEST['from'];
        $to  =  $_REQUEST['to']; 
        
      
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($fpath);
        
        $rows =  $data->rowcount(); // 2641
        $cols =  $data->colcount(); // 48
       
        
        
        $_found = '';
        $_not_found = '';
        $_foundcount = '0';
        $_not_foundcount = '0';
        
        for($i=2;$i<=$rows;$i++)
        {
            $model = ClientProfiles::model()->find('ID_CLIENT ='.$data->val($i,1).'2016');
        
                   if($model->member_type != ''){
                       $_found .= $data->val($i,1).',';
                       $_foundcount++;
                       $model->member_type = 'advertiser';
                       $model->save(false);  
                   }else{
                       $_not_found .= $data->val($i,1).',';
                       $_not_foundcount++;
                   }                   
        }
        echo 'total count-'.($rows-1);
        echo '<br>';
        echo 'found count-'.$_foundcount;
        echo '<br>';
        echo 'not found count-'.$_not_foundcount;
        echo '<br>';
        echo 'found id<br>';

        echo $_found;
        echo '<br>';
        echo 'not found id';
        echo '<br>';
        echo $_not_found;
        
    }
    public function actionExtractexcelsheet_client()
    {
        
        
        header('Content-type: text/html; charset=UTF-8') ;
        $fpath = Yii::getPathOfAlias('webroot').'/uploads/import_datas/Clients.xls';
        $from = $_REQUEST['from'];
        $to  =  $_REQUEST['to']; 
        echo "between $from - $to \n";
      
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data=new JPhpExcelReader($fpath);
        
        $rows =  $data->rowcount(); // 2641
        $cols =  $data->colcount(); // 48
        $Client_Profile= array();
        
        for($i=$from;$i<=$to;$i++)
        {
            $cat_arr = array();
            $Country = $Region = $Ville ='';
            $site_url1= $site_url  ='';
            for($j=1;$j<=$cols;$j++)
            {   
                $model  = new ClientProfiles;
//                echo "<br>";
//                echo "****$j***** ";echo "<br>";
//                echo $j.'-'.$data->val($i,$j);echo "<br>";
               
                if($j==1){  
                    
                    $modified_time=strtotime(str_replace('/', '-', $data->val($i,$j)));
                    echo 'Modified: '.$modified_time.'<br>';
                    $Client_Profile['modified_date'] = date('Y-m-d H:i:s', $modified_time);
                    }
                if($j==3){  $Client_Profile['ID_CLIENT']  = $data->val($i,$j);    }              
                if($j==4 || $j==5 || $j==6 || $j==7 || $j==8 || $j==9 || $j==10 || $j==11 || $j==12 || $j==13 || $j==14 || $j==15 )
                { 
                    $cat_id  = $data->val($i,$j);      
                    if($cat_id!='')
                    {
                       $cat_arrs[] = $cat_id;//store to client-map
                    }    
                }                
                if($j==16){  $Client_Profile['company']  = utf8_encode($data->val($i,$j)); }//NomEntreprise                    
                if($j==17){  $Client_Profile['sex']    = $data->val($i,$j);     } 
                if($j==18){  $Client_Profile['name'] = utf8_encode($data->val($i,$j));  }//Contact
                if($j==19){  $Client_Profile['job_title'] = utf8_encode($data->val($i,$j)); }//TitreDuContact
                if($j==20){  $Client_Profile['address'] = utf8_encode($data->val($i,$j)); }//Adresse
                if($j==21){ 
                    $Ville = utf8_encode($data->val($i,$j));
//                    $villeid = $this->_getcityinfo($Ville);
                }
                if($j==22){ 
                    $Region = utf8_encode($data->val($i,$j));
                }
                if($j==23){ 
                    $Country = utf8_encode($data->val($i,$j));
                    $final_rs = $this->_getcountryinfo($Ville,$Region,$Country);
                    $Client_Profile['country']=$final_rs[0];//Pays
                    $Client_Profile['region']=$final_rs[1];//Province
                    $Client_Profile['ville']=$final_rs[2];//Ville
                }
                if($j==24){ 
                    $Client_Profile['CodePostal'] = $data->val($i,$j);
                }
                if($j==25){ 
                    $Client_Profile['phonenumber1'] = $data->val($i,$j);
                }
                if($j==26){ 
                    $Client_Profile['Poste1'] = $data->val($i,$j);
                }
                if($j==27){ 
                    $Client_Profile['phonenumber2'] = $data->val($i,$j);
                }
                if($j==28){ 
                    $Client_Profile['Poste2'] = $data->val($i,$j);
                }
                if($j==29){ 
                    $Client_Profile['phonenumber3'] = $data->val($i,$j);
                }
                if($j==30){ 
                    $Client_Profile['Europe'] = utf8_encode($data->val($i,$j));
                }
                if($j==31){ 
                    $Client_Profile['feurope'] = $data->val($i,$j);
                }
                if($j==32){ 
                    $Client_Profile['tollfree_number'] = $data->val($i,$j);
                }
                if($j==33){ 
                    $Client_Profile['mobile_number'] = $data->val($i,$j);
                }
                if($j==34){ 
                    $Client_Profile['fax'] = $data->val($i,$j);
                }
                if($j==35){ 
                    $Client_Profile['email'] = $data->val($i,$j);
                }
                //36 and 37 is Calcul and Valeur
                if($j==38){ 
                    $site_url = $data->val($i,$j);
                    if(!empty($site_url)){
                    if(strpos($site_url, "http://") !== false){
                        $Client_Profile['site_address'] = $data->val($i,$j);
                    }else{
                        $Client_Profile['site_address'] = 'http://'.$data->val($i,$j);
                    }
                    }  else {
                        $Client_Profile['site_address'] = '';
                    }
                }
                if($j==39){ 
                    $site_url1 = $data->val($i,$j);
                    if(!empty($site_url1)){
                        if(strpos($site_url1, "http://") !== false){
                            $Client_Profile['Website2'] = $data->val($i,$j);
                        }else{
                            $Client_Profile['Website2'] = 'http://'.$data->val($i,$j);
                        }
                    }  else {
                        $Client_Profile['Website2'] = '';
                    }
                    
                }
                //40 Région
                if($j==41){ 
                    $Client_Profile['Envue_print'] = $this->_subscriptioninfo($data->val($i,$j));
                }
                if($j==42){ 
                    $Client_Profile['Envision_print'] = $this->_subscriptioninfo($data->val($i,$j));
                }
                if($j==43){ 
                    $Client_Profile['Optipromo'] = $this->_subscriptioninfo($data->val($i,$j));
                }
                if($j==44){ 
                    $Client_Profile['Optinews'] = $this->_subscriptioninfo($data->val($i,$j));
                }
                if($j==45){ 
                    $Client_Profile['Envision_digital'] = $this->_subscriptioninfo($data->val($i,$j));
                }
                if($j==46){ 
                    $Client_Profile['Envue_digital'] = $this->_subscriptioninfo($data->val($i,$j));
                }
                if($j==47){ 
                    $Client_Profile['Rep'] = $data->val($i,$j);
                }
                if($j==48){ 
                    
                    $create_time=strtotime(str_replace('/', '-', $data->val($i,$j)));
                    echo 'create: '.$create_time.'<br>';
                    $Client_Profile['created_date'] = date('Y-m-d H:i:s', $create_time);
                }
                $Client_Profile['member_type'] = 0;
                $Client_Profile['local_number'] = '';
                $Client_Profile['client_id']='';
            }
            
            $client_category = ClientCategory::model()->findByPk($cat_arrs[0]);
            $client_category_id =$client_category->cat_type_id;
            $model->attributes = $Client_Profile;
            
            if ($model->save()) {
            $client_id = Yii::app()->db->getLastInsertID();
            echo 'id :'.$client_id;
            foreach($cat_arrs as $cat_arr)
                {
                    $catmap = array();
                    $catmap_model = new ClientCatMapping;
                    $catmap['client_id']   = $client_id;
                    $catmap['cat_type_id'] = $client_category_id;
                    $catmap['category']    =  $cat_arr;
                    $catmap_model->attributes=$catmap;
                    $catmap_model->save();
                }
            }else{
                print_r($model->getErrors());
            }
            echo '<pre>';
            print_r($model->attributes);
              $Client_Profile = $catmap = $final_rs = null; 
              $cat_arrs = null;
              $client_id='';
              
        }
        
        
    }
    public function _subscriptioninfo($var){
        if($var=='YES'){
            return 1;
        }  else {
            return 0;
        }
    }
            
            
    public function _getcountryinfo($Ville,$Region,$Country)
    {
        
        $regionid  = $countryinfo_id = $regioninfo_id =0;
        $ID_VILLE = $ID_REGION = $ID_COUNTRY = '';
        $countryid = 0;
        $cityname='';
        $ville = $regions = $countrys = null;
        $Ville = trim($Ville);
        $exp_cty = explode(",",$Ville);
        
        if(count($exp_cty)>1)
        {    
           $cityname = trim(utf8_encode($exp_cty[0]));
        }else{
           $cityname = trim(utf8_encode($Ville));
        }
        
        $condition_country  = "NOM_PAYS_EN = '$Country' OR NOM_PAYS_FR = '$Country'";
        $countrys = CountryDirectory::model()->find($condition_country);
        if (!empty($countrys)) {
            
            $ID_COUNTRY = $countrys->ID_PAYS;
            foreach ($countrys->repertoireRegions as $country){

                if($country->ABREVIATION_EN == $Region){
                    $condition_region  = "ID_REGION = '$country->ID_REGION'";
                    $ID_REGION = $country->ID_REGION;
                    $regions = RegionDirectory::model()->find($condition_region);
                }
            }
            if (!empty($regions)) {
                
                foreach ($regions->cityDirectory as $region){
                    
                    if($region->NOM_VILLE == $cityname){
                        $condition_ville  = "ID_VILLE = '$region->ID_VILLE'";
                        $ville = CityDirectory::model()->find($condition_ville);
                    }
                }
                if (!empty($ville)) {
                    $ID_VILLE = $ville->ID_VILLE;
                } else {                    
                    if(!empty($cityname)){
                        
                    $cinfo = new CityDirectory;
                    $cinfo->ID_REGION = $ID_REGION;
                    $cinfo->NOM_VILLE = $cityname;
                    $cinfo->country   = $ID_COUNTRY;
                    $cinfo->save();
                    $ID_VILLE = $cinfo->ID_VILLE; 
                    }
                    else {
                        $ID_VILLE=0.3;
                    }
                }
            }  else {
                    if(!empty($Region)){
                    $regioninfo = new RegionDirectory;
                    $regioninfo->ID_PAYS = $ID_COUNTRY;
                    $regioninfo->NOM_REGION_FR = $Region;
                    $regioninfo->NOM_REGION_EN = $Region;
                    $regioninfo->ABREVIATION_FR = $Region;
                    $regioninfo->ABREVIATION_EN = $Region;
                    $regioninfo->save();
                    $regioninfo_id = $regioninfo->ID_REGION;
                    $ID_REGION = $regioninfo_id;
                    $cinfo = new CityDirectory;
                    $cinfo->ID_REGION = $regioninfo_id;
                    $cinfo->NOM_VILLE = $cityname;                    
                    $cinfo->country   = $ID_COUNTRY;
                    $cinfo->save();
                    $ID_VILLE = $cinfo->ID_VILLE;
                }
                else {
                    $ID_REGION=0.2;$ID_VILLE=0.2;
                }
            }
        
        }  else {
            if(!empty($Country)){
                
                $countryinfo = new CountryDirectory;
                $countryinfo->NOM_PAYS_FR = $Country;
                $countryinfo->NOM_PAYS_EN = $Country;
                $countryinfo->save();
                $countryinfo_id = $countryinfo->ID_PAYS;
                $ID_COUNTRY = $countryinfo_id;
                $regioninfo = new RegionDirectory;
                $regioninfo->ID_PAYS = $countryinfo_id;
                $regioninfo->NOM_REGION_FR = $Region;
                $regioninfo->NOM_REGION_EN = $Region;
                $regioninfo->ABREVIATION_FR = $Region;
                $regioninfo->ABREVIATION_EN = $Region;
                $regioninfo->save();
                $regioninfo_id = $regioninfo->ID_REGION;
                $ID_REGION = $regioninfo_id;
                $cinfo = new CityDirectory;
                $cinfo->ID_REGION = $regioninfo_id;
                $cinfo->NOM_VILLE = $cityname;
                $cinfo->country   = $countryinfo_id;
                $cinfo->save();
                $ID_VILLE = $cinfo->ID_VILLE;
                
            }
            else {
                $ID_COUNTRY=0.1;$ID_REGION=0.1;$ID_VILLE=0.1;
                    }
        }
        
        $final_rs=array();
        $final_rs[]=$ID_COUNTRY;
        $final_rs[]=$ID_REGION;
        $final_rs[]=$ID_VILLE;
        
      return $final_rs;
    }
    
    public function _getcityinfo($Villesss)
    {
        $regionid  = 0;
        $ID_VILLE  = 0;
        $countryid = 0;
        $Ville = trim($Ville);
        $exp_cty = explode(",",$Ville);
        
        if(count($exp_cty)>1)
        {    
           $cityname = utf8_encode($exp_cty[0]);
           $province = trim($exp_cty[1]);
           // get region id
           $condition = "ABREVIATION_EN='$province'";
           $region_exist = RegionDirectory::model()->find($condition);
           
           if (!empty($region_exist)) {
               // get country id
                 $regionid  = $region_exist->ID_REGION;
                 $countryid = $region_exist->ID_PAYS;
            }        
        }else{
           $cityname = utf8_encode($Ville);
        }

        
        $condition_cty  = "NOM_VILLE = '$cityname'";
        $city_exist = CityDirectory::model()->find(array('condition'=>$condition_cty));
        
        if (!empty($city_exist)) {
            $ID_VILLE = $city_exist->ID_VILLE;
        } else {             
            $cinfo = new CityDirectory;
            $cinfo->ID_REGION = $regionid;
            $cinfo->NOM_VILLE = $cityname;
            $cinfo->country   = $countryid;
            $cinfo->save();
            $ID_VILLE = $cinfo->ID_VILLE;
        }
        
      return $ID_VILLE;
    }        
    
    public function actionExtractexcelsheet()
    {
        $fpath = Yii::getPathOfAlias('webroot').'/uploads/import_datas/Professionals.xls';
       // $from = $_REQUEST['from'];
      //  $to  =  $_REQUEST['to']; 
       //echo "between $from - $to \n";
      
        
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
                $model->org_password   = $_POST['Admin']['current_password'];
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
                $message = Yii::app()->errorHandler->error['message'];
                $this->render('error', compact('error', 'name', 'message'));
            }
        }
    }

    public function actionScreens($path) {
        if ($path) {
            $this->render('screens', compact('path'));
        }
    }
    
     public function actionClientprofile($id) {

        if ($id != '') {
            $criteria = new CDbCriteria;
            $criteria->condition = "randkey='" . $id . "'";
            $criteria->with = array(
                "clientProfiles" => array(
                    'alias' => 'clientProfiles',
                    'select' => 'clientProfiles.*'
                ),
            );

            $messageinfos = ClientMessages::model()->find($criteria);

            if (!empty($messageinfos)) {
                $messageinfos->user_view_status = 1;
                $messageinfos->status = 0;
                $messageinfos->save(false);

                $this->render('_clientprofile', compact('messageinfos'));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    public function actionProfessionalprofile($id) {

        if ($id != '') {
            $criteria = new CDbCriteria;
            $criteria->condition = "randkey='" . $id . "'";
            $criteria->with = array(
                "professionalDirectory" => array(
                    'alias' => 'professionalDirectory',
                    'select' => 'professionalDirectory.*'
                ),
            );

            $messageinfos = ProfessionalMessages::model()->find($criteria);

            if (!empty($messageinfos)) {
                $messageinfos->user_view_status = 1;
                $messageinfos->status = 0;
                $messageinfos->save(false);

                $this->render('_professionalprofile', compact('messageinfos'));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

    public function actionRetailerprofile($id) {

        if ($id != '') {
            $criteria = new CDbCriteria;
            $criteria->condition = "randkey='" . $id . "'";
            $criteria->with = array(
                "retailerDirectory" => array(
                    'alias' => 'retailerDirectory',
                    'select' => 'retailerDirectory.*'
                ),
            );

            $messageinfos = RetailerMessages::model()->find($criteria);

            if (!empty($messageinfos)) {
                $messageinfos->user_view_status = 1;
                $messageinfos->status = 0;
                $messageinfos->save(false);

                $this->render('_retailerprofile', compact('messageinfos'));
            } else {
                $this->redirect(array('index'));
            }
        } else {
            $this->redirect(array('index'));
        }
    }

}