<?php

class ExportDatasController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','delete','retailerIndex','supplierIndex','clientIndex','generate_retailers', 'generate_suppliers','generate_clients','calculate_usercounts'),
				'users'=>array('@'),
                                'expression'=> 'AdminIdentity::checkAccess()',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(''),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
         /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionGenerate_suppliers()
	{
            
            $model=new ExportDatas;           

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['ExportDatas']))
            {   
                $model->attributes=$_POST['ExportDatas'];
                
                //if($model->validate()){
                    

                // Language filter
                $lang_str  = "";
                
                $lang_en = $_POST['ExportDatas']['EN'];
                $lang_fr = $_POST['ExportDatas']['FR'];
                
                $lang_str = $this->getlanguage_filter($lang_en,$lang_fr);                        
                
                // Subscription filter
                $subscription_str  = '';
                
                $sub_optipromo     = $_POST['ExportDatas']['Optipromo'];
                $sub_optinews      = $_POST['ExportDatas']['Optinews'];
                $sub_envision_print   =  $_POST['ExportDatas']['Envision_print'];
                $sub_envision_digital =  $_POST['ExportDatas']['Envision_digital'];
                $sub_envue_print   =  $_POST['ExportDatas']['Envue_print'];
                $sub_envue_digital =  $_POST['ExportDatas']['Envue_digital'];
           
                $subscription_str = $this->getsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital);
              
                 // Provience filter               
                $province_str = '';
                //$provinces    = $_POST['ExportDatas']['province'];
                $search_country = isset($_POST['ExportDatas']['country'])?$_POST['ExportDatas']['country']:'';
                $search_region  = isset($_POST['ExportDatas']['region'])?$_POST['ExportDatas']['region']:'';
                
                //$province_str = $this->getprovince_filter($provinces);
                $province_str = $this->getprovince_filter($search_country,$search_region);
                
                // Supplier Type
                $type_str  = '';
                $supplier_type = $_POST['ExportDatas']['ptype'];                     
                $type_str    = $this->gettype_filter($supplier_type,"supplier");
                
                // Supplier section
                $section_str  = '';
                $supplier_section = isset($_POST['ExportDatas']['psection'])?$_POST['ExportDatas']['psection']:'';           
                if($supplier_section!="")
                {    
                    $section_str  = $this->getsection_filter($supplier_section);
                }else{
                    $section_str  = "";
                }    
     
                // Export type    
                $export_type = $_POST['ExportDatas']['export_type'];
                
                
                // Get user counts           
                $querystr   = $lang_str.$subscription_str.$province_str.$type_str.$section_str;
              
                $item_count = $this->countusers($querystr,"supplier");
               
                
                if($item_count>0)
                {   
                   // Export data and save the files
                    $this->exportfiles_supplier( $export_type , $lang_str , $subscription_str , $province_str , $type_str , $supplier_type , $provinces , $section_str , $supplier_section);
                 
                    Yii::app()->user->setFlash('success', 'Datas export successfully!!!');
                    $this->redirect(array('supplierIndex'));
                    
                }else
                {               
                    Yii::app()->user->setFlash('danger', 'No records to generate!!!');
                    $this->redirect(array('generate_suppliers'));
                }  
                
//            } else {
//                echo '<pre>';
//                print_r($model->getErrors()); exit;
//            }
               
            }

            $this->render('_supplierform',array(
                    'model'=>$model,
            ));
	}
        
        public function getsection_filter($search_section)
        {
            $section_product_qry = "";
            
            if ($search_section != '') {
                // Get productmarques ids based on products and sections
                $criteria = new CDbCriteria;
                $criteria->with = array("productMarqueDirectory" => array("select" => "ID_LIEN_MARQUE"));
                $criteria->condition = 'ID_SECTION=:id';
                $criteria->params = array(':id' => $search_section);               
                $data_products_marques = ProductDirectory::model()->findAll($criteria);
 
                foreach ($data_products_marques as $infos) {
                    foreach ($infos['productMarqueDirectory'] as $info2) {
                        $infoarr[] = $info2['ID_LIEN_MARQUE'];
                    }
                }
                
                if (!empty($infoarr)) {
                    // Get supplierids related to the productmarques   
                    $criteria = new CDbCriteria;
                    $criteria->addInCondition('ID_LIEN_PRODUIT_MARQUE', $infoarr);
                    $criteria->group = 'ID_FOURNISSEUR';
                    $data_suppliers = SupplierProducts::model()->findAll($criteria);

                    foreach ($data_suppliers as $infos3) {
                        $supplierids[] = $infos3['ID_FOURNISSEUR'];
                    }
                }

                if (!empty($supplierids)) {
                    $imp_suppids = (count($supplierids) > 1) ? implode(',', $supplierids) : $supplierids[0];
                    $section_product_qry = " AND f.ID_FOURNISSEUR IN (" . $imp_suppids . ") ";                   
                }
            }
           
            return $section_product_qry;
        }
        
         
        public function exportfiles_supplier( $export_type , $lang_str , $subscription_str , $province_str , $type_str , $supplier_type , $provinces, $section_str , $supplier_section)
        {
            Yii::import('ext.ECSVExport');
            $attach_path = Yii::getPathOfAlias('webroot').'/'.EXPORTDATAS;   
            $randstr  = Myclass::getRandomString(4);
           
            // Single file              
                // Get all records list  with limit
                $ret_result = Yii::app()->db->createCommand(
                "SELECT COMPAGNIE as Company_Name, TYPE_FOURNISSEUR_FR as Supplier_Type, ru.COURRIEL as Email, ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax,  USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
                (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
                (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
                (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
                (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
                (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
                (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
                f.CREATED_DATE as Created_Date , f.DATE_MODIFICATION as Modified_Date
                FROM repertoire_fournisseurs f, repertoire_fournisseur_type ft, repertoire_ville AS rv, repertoire_region AS rr, repertoire_pays AS rp, repertoire_utilisateurs as ru
                WHERE f.ID_FOURNISSEUR=ru.ID_RELATION AND f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.status=1 AND ru.NOM_TABLE ='Fournisseurs' 
                ".$lang_str.$subscription_str.$province_str.$type_str.$section_str." ORDER BY Company_Name");  
                
             
                if($export_type==1)
                {    
                    // File name and path                
                    $filename = "Supplier_data_".date("Y_m_d")."_".$randstr.".csv";                
                    $outputFile_path = $attach_path.$filename;

                }else if($export_type==3){
                    
                    $supplier_type_name = SupplierType::model()->findByPk($supplier_type)->TYPE_FOURNISSEUR_EN;
                    
                    if($supplier_section!="")
                    {
                        $supplier_type_name = SectionDirectory::model()->findByPk($supplier_section)->NOM_SECTION_EN;    
                        $supplier_type_name = str_replace(" ", "_", $supplier_type_name);
                    }   
                    
                    $filename = "Supplier_data_".date("Y_m_d")."_".$supplier_type_name."_".$randstr.".csv"; 
                  
                    $outputFile_path = $attach_path.$filename;
                } 

                // Export as csv file
                $this->Exceldownload($ret_result,$outputFile_path);
                $model=new ExportDatas;   
                $model->attachment_file = $filename;
                $model->user_type = "Supplier";
                $model->save();
           
            
            // Province 
//            if($export_type==2)
//            {
//                if(!empty($provinces))
//                {   
//                    
//                    foreach($provinces as $reg_val)
//                    {
//                        $reg_arr      = array();
//                        $reg_arr[]    = $reg_val;
//                        
//                        $province_str = $this->getprovince_filter($reg_arr);  
//                        
//                        $qry_str       = $lang_str.$subscription_str.$province_str.$type_str;
//                        
//                        $records_exist = $this->countusers($qry_str,"supplier");
//                        
//                        if($records_exist>0)
//                        {    
//                            // Get all records list  with limit
//                            $ret_result = Yii::app()->db->createCommand(
//                                 "SELECT COMPAGNIE as Company_Name, TYPE_FOURNISSEUR_FR as Supplier_Type, ru.COURRIEL as Email, ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax,  USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
//                                (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
//                                (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
//                                (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
//                                (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
//                                (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
//                                (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
//                                rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
//                                FROM repertoire_fournisseurs f, repertoire_fournisseur_type ft, repertoire_ville AS rv, repertoire_region AS rr, repertoire_pays AS rp, repertoire_utilisateurs as ru
//                                WHERE f.ID_FOURNISSEUR=ru.ID_RELATION AND f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS  AND ru.status=1 AND ru.NOM_TABLE ='Fournisseurs' 
//                                ".$qry_str." ORDER BY Company_Name");  
//
//                            // File name and path                                
//                            $province_name = RegionDirectory::model()->findByPk($reg_val)->NOM_REGION_EN;
//                            $filename = "Supplier_data_".date("Y_m_d")."_".$province_name."_".$randstr.".csv";    
//                            $outputFile_path = $attach_path.$filename;
//
//                            // Export as csv file
//                            $this->Exceldownload($ret_result,$outputFile_path);
//                            
//                            $model= new ExportDatas;   
//                            $model->attachment_file = $filename;
//                            $model->user_type = "Retailer";
//                            $model->save();
//                        }  
//                    }
//                }
//            }    

            // Professional types
//            if($export_type==3)
//            {
//                if(!empty($supplier_type))
//                {    
//                    foreach($supplier_type as $typeval)
//                    {
//                        $type_str = " AND f.ID_TYPE_FOURNISSEUR = $typeval "; 
//                        
//                        $qry_str       = $lang_str.$subscription_str.$province_str.$type_str;
//                        
//                        $records_exist = $this->countusers($qry_str,"supplier");
//                        
//                        if($records_exist>0)
//                        {    
//                            // Get all records list  with limit
//                            $ret_result = Yii::app()->db->createCommand(
//                                "SELECT COMPAGNIE as Company_Name, TYPE_FOURNISSEUR_FR as Supplier_Type, ru.COURRIEL as Email, ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax,  USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
//                                (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
//                                (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
//                                (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
//                                (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
//                                (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
//                                (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
//                                f.CREATED_DATE as Created_Date , f.DATE_MODIFICATION as Modified_Date
//                                FROM repertoire_fournisseurs f, repertoire_fournisseur_type ft, repertoire_ville AS rv, repertoire_region AS rr, repertoire_pays AS rp, repertoire_utilisateurs as ru
//                                WHERE f.ID_FOURNISSEUR=ru.ID_RELATION AND f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.status=1 AND ru.NOM_TABLE ='Fournisseurs' 
//                                ".$qry_str." ORDER BY Company_Name");  
//
//                            // File name and path                               
//                            $supplier_type_name = SupplierType::model()->findByPk($typeval)->TYPE_FOURNISSEUR_FR;
//                            $filename = "Supplier_data_".date("Y_m_d")."_".$supplier_type_name."_".$randstr.".csv";                
//                            $outputFile_path = $attach_path.$filename;
//
//                            // Export as csv file
//                            $this->Exceldownload($ret_result,$outputFile_path);
//                            
//                            $model=new ExportDatas;   
//                            $model->attachment_file = $filename;
//                            $model->user_type = "Supplier";
//                            $model->save();
//                        }    
//                    }
//                }    
//            }
            
        } 
        
        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionGenerate_retailers()
	{
            
            $model=new ExportDatas;           

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['ExportDatas']))
            {   
                $model->attributes=$_POST['ExportDatas'];
                
                //if($model->validate()){
   
                // Language filter
                $lang_str  = "";
                
                $lang_en = $_POST['ExportDatas']['EN'];
                $lang_fr = $_POST['ExportDatas']['FR'];
                
                $lang_str = $this->getlanguage_filter($lang_en,$lang_fr);                        
                
                // Subscription filter
                $subscription_str  = '';
                
                $sub_optipromo     = $_POST['ExportDatas']['Optipromo'];
                $sub_optinews      = $_POST['ExportDatas']['Optinews'];
                $sub_envision_print   =  $_POST['ExportDatas']['Envision_print'];
                $sub_envision_digital =  $_POST['ExportDatas']['Envision_digital'];
                $sub_envue_print   =  $_POST['ExportDatas']['Envue_print'];
                $sub_envue_digital =  $_POST['ExportDatas']['Envue_digital'];
                
           
                $subscription_str = $this->getsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital);
              
                 // Provience filter               
                $province_str = '';
                //$provinces    = $_POST['ExportDatas']['province'];
                $search_country = isset($_POST['ExportDatas']['country'])?$_POST['ExportDatas']['country']:'';
                $search_region  = isset($_POST['ExportDatas']['region'])?$_POST['ExportDatas']['region']:'';
                
                //$province_str = $this->getprovince_filter($provinces);
                $province_str = $this->getprovince_filter($search_country,$search_region);
                
                // Professional Type
                $type_str  = '';
                $retailer_type   = $_POST['ExportDatas']['ptype'];         
                $retailer_GROUPE =  $_POST['ExportDatas']['ID_GROUPE'];
                
                $type_str    = $this->gettype_filter($retailer_type,"retailer",$retailer_GROUPE);
     
                // Export type    
                $export_type = $_POST['ExportDatas']['export_type'];
                
                
                // Get user counts           
                $querystr   = $lang_str.$subscription_str.$province_str.$type_str;
                $item_count = $this->countusers($querystr,"retailer");
                
                if($item_count>0)
                {   
                   // Export data and save the files
                    $this->exportfiles_retailer( $export_type , $lang_str , $subscription_str , $province_str , $type_str , $retailer_type , $provinces,$retailer_GROUPE);
                 
                    Yii::app()->user->setFlash('success', 'Datas export successfully!!!');
                    $this->redirect(array('retailerIndex'));
                    
                }else
                {               
                    Yii::app()->user->setFlash('danger', 'No records to generate!!!');
                    $this->redirect(array('generate_retailers'));
                }  
                
//            } else {
//                echo '<pre>';
//                print_r($model->getErrors()); exit;
//            }
               
            }

            $this->render('_retailerform',array(
                    'model'=>$model,
            ));
	}
        
        public function exportfiles_retailer( $export_type , $lang_str , $subscription_str , $province_str , $type_str , $retailer_type , $provinces,$retailer_GROUPE)
        {
            Yii::import('ext.ECSVExport');
            $attach_path = Yii::getPathOfAlias('webroot').'/'.EXPORTDATAS;   
            $randstr  = Myclass::getRandomString(4);
           
            // Single file
            if($export_type==1)
            {    
                // Get all records list  with limit
                $ret_result = Yii::app()->db->createCommand(
                "SELECT COMPAGNIE as Company_Name, NOM_TYPE_EN as Reatlier_Type ,rrg.NOM_GROUPE AS Regroupement , ru.COURRIEL as Email, HEAD_OFFICE_NAME as Head_office , ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax,  USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
                (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
                (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
                (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
                (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
                (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
                (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
                rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
                FROM repertoire_retailer as rs , repertoire_retailer_type as rst , repertoire_retailer_groupe AS rrg , repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
                 WHERE rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_GROUPE=rrg.ID_GROUPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Detaillants' 
                ".$lang_str.$subscription_str.$province_str.$type_str." ORDER BY Company_Name");  
                
                // File name and path                
                $filename = "Retailer_data_".date("Y_m_d")."_".$randstr.".csv";                
                $outputFile_path = $attach_path.$filename;

                // Export as csv file
                $this->Exceldownload($ret_result,$outputFile_path);
                $model=new ExportDatas;   
                $model->attachment_file = $filename;
                $model->user_type = "Retailer";
                $model->save();
            }
            
//            // Province 
//            if($export_type==2)
//            {
//                if(!empty($provinces))
//                {   
//                    
//                    foreach($provinces as $reg_val)
//                    {
//                        $reg_arr      = array();
//                        $reg_arr[]    = $reg_val;
//                        
//                        $province_str = $this->getprovince_filter($reg_arr);  
//                        
//                        $qry_str       = $lang_str.$subscription_str.$province_str.$type_str;
//                        
//                        $records_exist = $this->countusers($qry_str,"retailer");
//                        
//                        if($records_exist>0)
//                        {    
//                            // Get all records list  with limit
//                            $ret_result = Yii::app()->db->createCommand(
//                                "SELECT COMPAGNIE as Company_Name, NOM_TYPE_EN as Reatlier_Type ,rrg.NOM_GROUPE AS Regroupement , ru.COURRIEL as Email, HEAD_OFFICE_NAME as Head_office , ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax,  USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
//                                (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
//                                (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
//                                (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
//                                (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
//                                (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
//                                (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
//                                rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
//                                FROM repertoire_retailer as rs , repertoire_retailer_type as rst , repertoire_retailer_groupe AS rrg , repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
//                                WHERE rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_GROUPE=rrg.ID_GROUPE AND AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Detaillants' 
//                                ".$qry_str." ORDER BY Company_Name");  
//
//                            // File name and path                                
//                            $province_name = RegionDirectory::model()->findByPk($reg_val)->NOM_REGION_EN;
//                            $filename = "Retailer_data_".date("Y_m_d")."_".$province_name."_".$randstr.".csv";    
//                            $outputFile_path = $attach_path.$filename;
//
//                            // Export as csv file
//                            $this->Exceldownload($ret_result,$outputFile_path);
//                            
//                            $model= new ExportDatas;   
//                            $model->attachment_file = $filename;
//                            $model->user_type = "Retailer";
//                            $model->save();
//                        }  
//                    }
//                }
//            }    

            // Professional types
            if($export_type==3)
            {
                if($retailer_type!='')
                {    
                    
                    $type_str = " AND rs.ID_RETAILER_TYPE = $retailer_type "; 
                    
                    if(!empty($retailer_GROUPE))
                    {  
                        foreach($retailer_GROUPE as $typeval)
                        {
                            $grp_str = " AND rs.ID_GROUPE = $typeval "; 

                            $qry_str  = $lang_str.$subscription_str.$province_str.$type_str.$grp_str;

                            $records_exist = $this->countusers($qry_str,"retailer");

                            if($records_exist>0)
                            {    
                                // Get all records list  with limit
                                $ret_result = Yii::app()->db->createCommand(
                                     "SELECT COMPAGNIE as Company_Name, NOM_TYPE_EN as Reatlier_Type ,rrg.NOM_GROUPE AS Regroupement , ru.COURRIEL as Email, HEAD_OFFICE_NAME as Head_office , ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax,  USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
                                    (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
                                    (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
                                    (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
                                    (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
                                    (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
                                    (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
                                    rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
                                    FROM repertoire_retailer as rs , repertoire_retailer_type as rst , repertoire_retailer_groupe AS rrg , repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
                                    WHERE rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_GROUPE=rrg.ID_GROUPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Detaillants' 
                                     ".$qry_str." ORDER BY Company_Name");  

                                // File name and path                               
                                $retailer_group_name = RetailerGroup::model()->findByPk($typeval)->NOM_GROUPE;
                                $filename = "Retailer_data_".date("Y_m_d")."_".$retailer_group_name."_".$randstr.".csv";                
                                $outputFile_path = $attach_path.$filename;

                                // Export as csv file
                                $this->Exceldownload($ret_result,$outputFile_path);

                                $model=new ExportDatas;   
                                $model->attachment_file = $filename;
                                $model->user_type = "Retailer";
                                $model->save();
                            }    
                        }
                    }else
                    {
                         $qry_str  = $lang_str.$subscription_str.$province_str.$type_str;
                        // Get all records list  with limit
                         $ret_result = Yii::app()->db->createCommand(
                        "SELECT COMPAGNIE as Company_Name, NOM_TYPE_EN as Reatlier_Type ,rrg.NOM_GROUPE AS Regroupement , ru.COURRIEL as Email, HEAD_OFFICE_NAME as Head_office , ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax,  USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
                        (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
                        (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
                        (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
                        (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
                        (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
                        (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
                        rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
                        FROM repertoire_retailer as rs , repertoire_retailer_type as rst , repertoire_retailer_groupe AS rrg , repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
                        WHERE rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_GROUPE=rrg.ID_GROUPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Detaillants' 
                        ".$qry_str." ORDER BY Company_Name");  
                                
                         // File name and path                               
                        $retailer_type_name = RetailerType::model()->findByPk($retailer_type)->NOM_TYPE_EN;
                        $filename = "Retailer_data_".date("Y_m_d")."_".$retailer_type_name."_".$randstr.".csv";     
                        
                        $outputFile_path = $attach_path.$filename;

                        // Export as csv file
                        $this->Exceldownload($ret_result,$outputFile_path);

                        $model=new ExportDatas;   
                        $model->attachment_file = $filename;
                        $model->user_type = "Retailer";
                        $model->save();
                    }    
                }    
            }
            
        } 

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            
            $model=new ExportDatas;           

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['ExportDatas']))
            {   
                $model->attributes=$_POST['ExportDatas'];

                // Language filter
                $lang_str  = "";
                
                $lang_en = $_POST['ExportDatas']['EN'];
                $lang_fr = $_POST['ExportDatas']['FR'];
                
                $lang_str = $this->getlanguage_filter($lang_en,$lang_fr);                        
                
                // Subscription filter
                $subscription_str  = '';
                
                $sub_optipromo     = $_POST['ExportDatas']['Optipromo'];
                $sub_optinews      = $_POST['ExportDatas']['Optinews'];
                $sub_envision_print   =  $_POST['ExportDatas']['Envision_print'];
                $sub_envision_digital =  $_POST['ExportDatas']['Envision_digital'];
                $sub_envue_print   =  $_POST['ExportDatas']['Envue_print'];
                $sub_envue_digital =  $_POST['ExportDatas']['Envue_digital'];
           
                $subscription_str = $this->getsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital);
              
                // Provience filter               
                $province_str = '';
                //$provinces    = $_POST['ExportDatas']['province'];
                $search_country = isset($_POST['ExportDatas']['country'])?$_POST['ExportDatas']['country']:'';
                $search_region  = isset($_POST['ExportDatas']['region'])?$_POST['ExportDatas']['region']:'';
                
                //$province_str = $this->getprovince_filter($provinces);
                $province_str = $this->getprovince_filter($search_country,$search_region);
                
                // Professional Type
                $type_str  = '';
                $professional_type = $_POST['ExportDatas']['ptype'];     
                
                $type_str    = $this->gettype_filter($professional_type,"professional");
     
                // Export type    
                $export_type = $_POST['ExportDatas']['export_type'];
                
                // Get user counts           
                $querystr   = $lang_str.$subscription_str.$province_str.$type_str;
                $item_count = $this->countusers($querystr,"professional");
                
                if($item_count>0)
                {   
                   // Export data and save the files
                    $this->exportfiles( $export_type , $lang_str , $subscription_str , $province_str , $type_str , $professional_type , $provinces);
                 
                    Yii::app()->user->setFlash('success', 'Datas export successfully!!!');
                    $this->redirect(array('index'));
                    
                }else
                {               
                    Yii::app()->user->setFlash('danger', 'No records to generate!!!');
                    $this->redirect(array('create'));
                }        
               
            }

            $this->render('_form',array(
                    'model'=>$model,
            ));
	}
        
        public function exportfiles( $export_type , $lang_str , $subscription_str , $province_str , $type_str , $professional_type, $provinces)
        {
            Yii::import('ext.ECSVExport');
            $attach_path = Yii::getPathOfAlias('webroot').'/'.EXPORTDATAS;   
            $randstr  = Myclass::getRandomString(4);
           
            // Single file
            if($export_type==1)
            {    
                // Get all records list  with limit
                $prof_result = Yii::app()->db->createCommand(
                    "SELECT NOM AS First_Name , PRENOM AS Last_Name , TYPE_SPECIALISTE_EN AS Professional_Type, ru.COURRIEL as Email, BUREAU as Bureau, ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax, USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
                    (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
                    (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
                    (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
                    (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
                    (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
                    (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
                    rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
                    FROM  repertoire_specialiste as rs, repertoire_specialiste_type as rst, repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
                    WHERE rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Professionnels'
                    ".$lang_str.$subscription_str.$province_str.$type_str." ORDER BY NOM");  

                // File name and path                
                $filename = "Professional_data_".date("Y_m_d")."_".$randstr.".csv";                
                $outputFile_path = $attach_path.$filename;

                // Export as csv file
                $this->Exceldownload($prof_result,$outputFile_path);
                $model=new ExportDatas;   
                $model->attachment_file = $filename;
                $model->user_type = "Professional";
                $model->save();
            }
            
            // Province 
            if($export_type==2)
            {
                if(!empty($provinces))
                {   
                    
                    foreach($provinces as $reg_val)
                    {
                        $reg_arr      = array();
                        $reg_arr[]    = $reg_val;
                        $province_str = $this->getprovince_filter($reg_arr);                       
                        $qry_str      = $lang_str.$subscription_str.$province_str.$type_str;
                        
                        $records_exist = $this->countusers($qry_str,"professional");
                        
                        if($records_exist>0)
                        {    
                            // Get all records list  with limit
                            $prof_result = Yii::app()->db->createCommand(
                            "SELECT NOM AS First_Name , PRENOM AS Last_Name , TYPE_SPECIALISTE_EN AS Professional_Type, ru.COURRIEL as Email, BUREAU as Bureau, ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax, USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
                            (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
                            (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
                            (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
                            (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,
                            (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
                            (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
                            rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
                            FROM  repertoire_specialiste as rs, repertoire_specialiste_type as rst, repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
                            WHERE rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Professionnels'
                            ".$qry_str." ORDER BY NOM");  

                            // File name and path                                
                            $province_name = RegionDirectory::model()->findByPk($reg_val)->NOM_REGION_EN;
                            $filename = "Professional_data_".date("Y_m_d")."_".$province_name."_".$randstr.".csv";    
                            $outputFile_path = $attach_path.$filename;

                            // Export as csv file
                            $this->Exceldownload($prof_result,$outputFile_path);
                            
                            $model= new ExportDatas;   
                            $model->attachment_file = $filename;
                            $model->user_type = "Professional";
                            $model->save();
                        }  
                    }
                }
            }    

            // Professional types
            if($export_type==3)
            {
                if(!empty($professional_type))
                {    
                    foreach($professional_type as $typeval)
                    {
                        $type_str = " AND rs.ID_TYPE_SPECIALISTE = $typeval "; 
                        
                        $qry_str       = $lang_str.$subscription_str.$province_str.$type_str;
                        $records_exist = $this->countusers($qry_str,"professional");
                        
                        if($records_exist>0)
                        {    
                            // Get all records list  with limit
                            $prof_result = Yii::app()->db->createCommand(
                               "SELECT NOM AS First_Name , PRENOM AS Last_Name , TYPE_SPECIALISTE_EN AS Professional_Type, ru.COURRIEL as Email, BUREAU as Bureau, ADRESSE as Address , CODE_POSTAL as Postal_code, TELEPHONE as Telephone, TELECOPIEUR as Fax, USR AS User_name , PWD AS Password , LANGUE AS Language , NOM_VILLE AS Ville , NOM_REGION_EN AS Region , ABREVIATION_EN AS Abreviation , NOM_PAYS_EN AS Country,
                                 (CASE WHEN bSubscription_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Digital ,
                                 (CASE WHEN bSubscription_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Digital ,
                                 (CASE WHEN print_envision <> 1 THEN 'no' ELSE 'yes' END) As Envision_Print ,
                                 (CASE WHEN print_envue <> 1 THEN 'no' ELSE 'yes' END) As Envue_Print ,                                 
                                 (CASE WHEN ABONNE_MAILING <> 1 THEN 'no' ELSE 'yes' END) As Opti_News ,
                                 (CASE WHEN ABONNE_PROMOTION <> 1 THEN 'no' ELSE 'yes' END) As Opti_Promo ,                     
                                 rs.CREATED_DATE as Created_Date , rs.DATE_MODIFICATION as Modified_Date
                                 FROM  repertoire_specialiste as rs, repertoire_specialiste_type as rst, repertoire_ville as rv, repertoire_region as rr, repertoire_pays as rp, repertoire_utilisateurs as ru
                                 WHERE rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Professionnels'
                                 ".$qry_str." ORDER BY NOM");  

                            // File name and path                               
                            $professional_type_name = ProfessionalType::model()->findByPk($typeval)->TYPE_SPECIALISTE_EN;
                            $filename = "Professional_data_".date("Y_m_d")."_".$professional_type_name."_".$randstr.".csv";                
                            $outputFile_path = $attach_path.$filename;

                            // Export as csv file
                            $this->Exceldownload($prof_result,$outputFile_path);
                            
                            $model=new ExportDatas;   
                            $model->attachment_file = $filename;
                            $model->user_type = "Professional";
                            $model->save();
                        }    
                    }
                }    
            }
            
        } 
        
        public function countusers($querystr,$type)
        {            
          $item_count = 0;
          
            if($type=="professional")
            {    
                // Get user counts               
                $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
               ->select('count(*) as count')
               ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
               ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Professionnels' ".$querystr)
               ->queryScalar(); // do not LIMIT it, this must count all items!
            }

            if($type=="retailer")
            { 
                // Get all records list  with limit
                $item_count = Yii::app()->db->createCommand() //this query contains all the data
                ->select('count(*) as count')
                ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_retailer_groupe AS rrg' ,'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_GROUPE=rrg.ID_GROUPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.NOM_TABLE ='Detaillants' " . $querystr)
                ->queryScalar(); // do not LIMIT it, this must count all items!
            } 
            
            if($type=="supplier")
            {
                 $item_count = Yii::app()->db->createCommand() //this query contains all the data
                ->select('count(*) as count')
                ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                ->where("f.ID_FOURNISSEUR=ru.ID_RELATION AND f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND ru.status=1 AND ru.NOM_TABLE ='Fournisseurs' " . $querystr)
                ->queryScalar(); // do not LIMIT it, this must count all items!
            } 
            
            if($type=="client")
            {
                 $item_count = Yii::app()->db->createCommand() //this query contains all the data
                ->select('COUNT(DISTINCT ru.client_id) AS count')
                ->from(array('client_profiles ru' ,'client_category_types ct' , 'repertoire_pays  rp' , 'repertoire_region rr' , 'repertoire_ville rv', 'client_category cc', 'client_cat_mapping cm'))
                ->where("cm.client_id=ru.client_id AND cm.cat_type_id=ct.cat_type_id AND cm.category=cc.category AND ru.country=rp.ID_PAYS AND ru.region=rr.ID_REGION AND ru.ville=rv.ID_VILLE " . $querystr)
                ->queryScalar();
            }
                
           return  $item_count;
        }   
        
        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCalculate_usercounts()
	{
            $item_count = 0;
            $usertype   = $_POST['utype'];
            if(isset($_POST['ExportDatas']))
            {   
                // Language filter
                $lang_str  = "";
                
                $lang_en = $_POST['ExportDatas']['EN'];
                $lang_fr = $_POST['ExportDatas']['FR'];
                
                $lang_str = $this->getlanguage_filter($lang_en,$lang_fr);                        
                
                // Subscription filter
                $subscription_str  = '';
                
                $sub_optipromo     = $_POST['ExportDatas']['Optipromo'];
                $sub_optinews      = $_POST['ExportDatas']['Optinews'];
                $sub_envision_print   =  $_POST['ExportDatas']['Envision_print'];
                $sub_envision_digital =  $_POST['ExportDatas']['Envision_digital'];
                $sub_envue_print   =  $_POST['ExportDatas']['Envue_print'];
                $sub_envue_digital =  $_POST['ExportDatas']['Envue_digital'];
           
                if($usertype=="client")
                {
                    
                    $ptype=$_POST['ExportDatas']['ptype'];
                    $category=$_POST['ExportDatas']['category'];
                    
                    $subscription_str  = $this->getclientsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital,$ptype,$category); 

                }else
                {
                    $subscription_str = $this->getsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital);
                }
                
              
                // Provience filter               
                $province_str = '';
                //$provinces    = $_POST['ExportDatas']['province'];                
                //$province_str = $this->getprovince_filter($provinces);  
                 $search_country = isset($_POST['ExportDatas']['country'])?$_POST['ExportDatas']['country']:'';
                 $search_region  = isset($_POST['ExportDatas']['region'])?$_POST['ExportDatas']['region']:'';
                if($usertype=="client")
                {
                
                    if ($search_country != '') {                
                        $scntry_qry = " AND ru.country = " . $search_country;
                    }

                    if ($search_region != '') {                
                        $sregion_qry = " AND ru.region = " . $search_region;
                    }

                    $province_str = $scntry_qry.$sregion_qry;
                }else{  
                    $province_str   = $this->getprovince_filter($search_country,$search_region);
                }
                    
              
                $type_str  = '';
                // Type                
                $u_type   = isset($_POST['ExportDatas']['ptype'])?$_POST['ExportDatas']['ptype']:array();       
                if($usertype=="retailer")
                {
                    $retailer_GROUPE =  $_POST['ExportDatas']['ID_GROUPE'];
                    $type_str = $this->gettype_filter($u_type,$usertype,$retailer_GROUPE);
                }else{        
                    $type_str = $this->gettype_filter($u_type,$usertype);
                }
                
                 $section_str  = "";
                if($usertype=="supplier")
                {
                    // Supplier section                   
                    $supplier_section = isset($_POST['ExportDatas']['psection'])?$_POST['ExportDatas']['psection']:'';           
                    if($supplier_section!="")
                    {   
                        
                        $section_str  = $this->getsection_filter($supplier_section);
                    }
                }
            
                    
                // Export type    
                $export_type = $_POST['ExportDatas']['export_type'];
                
                // Get user counts           
                $querystr   = $lang_str.$subscription_str.$province_str.$type_str.$section_str;

                $item_count = $this->countusers($querystr,$usertype);
            }      
              
            echo $item_count;
            exit;
                
        }        

        public function Exceldownload($prof_result , $outputFile)
        {           
            Yii::import('ext.ECSVExport');           
            $csv = new ECSVExport($prof_result);
            $csv->convertActiveDataProvider=false;
            $csv->setOutputFile($outputFile);
            $output = $csv->toCSV();               
        }  
        
        public function getlanguage_filter($lang_en,$lang_fr)
        {
            $lang_str = "";
            
            if($lang_en=="1" && $lang_fr=="1")
            {
                $lang_str .= " AND ( ru.LANGUE='EN' || ru.LANGUE='FR' ) ";
            }else if($lang_en=="1")
            {
                $lang_str .= " AND ru.LANGUE='EN' ";                    
            }else if($lang_fr=="1")
            {
                $lang_str .= " AND ru.LANGUE='FR' ";
            } 
            
            return $lang_str;
        }
        
        public function getsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital)
        {
            $subscription_arr = array();
            $subscription_str = '';
                
            if($sub_optipromo=="1")
            {
                $subscription_arr[] = " ru.ABONNE_PROMOTION=1 ";
            }  

            if($sub_optinews=="1")
            {
                $subscription_arr[] = " ru.ABONNE_MAILING=1 ";
            }   

            if($sub_envision_print=="1")
            {
                $subscription_arr[] = " ru.print_envision=1 ";
            }   

            if($sub_envision_digital=="1")
            {
                $subscription_arr[] = " ru.bSubscription_envision=1 ";
            }  

            if($sub_envue_print=="1")
            {
                $subscription_arr[] = " ru.print_envue=1 ";
            }  

            if($sub_envue_digital=="1")
            {
                $subscription_arr[] = " ru.bSubscription_envue=1 ";
            } 
                
                
            if(!empty($subscription_arr))
            {
                if(count($subscription_arr)>1)
                {
                   $imp_substr =  implode(" || ",$subscription_arr);
                   $subscription_str = " AND  ( $imp_substr )  ";
                }else
                {
                   $subscription_str = " AND $subscription_arr[0] ";
                }    
            }  

            return $subscription_str;
        }    
        
        public function getprovince_filter($search_country,$search_region)
        {
            $province_str = "";
            $scntry_qry   = "";
            $sregion_qry  = "";
            
//            if(!empty($provinces))
//            {    
//               $imp_prov     = implode(",",$provinces);
//               $condition    = " ID_REGION IN ($imp_prov) ";
//               $city_results = CHtml::listData( CityDirectory::model()->findAll($condition) , 'ID_VILLE' , 'ID_VILLE');
//               $cities_str   = implode(',',$city_results);               
//               $province_str = " AND rs.ID_VILLE IN ($cities_str) ";  
//            }
            
            if ($search_country != '') {                
                $scntry_qry = " AND rp.ID_PAYS = " . $search_country;
            }

            if ($search_region != '') {                
                $sregion_qry = " AND rr.ID_REGION = " . $search_region;
            }
            
            $province_str = $scntry_qry.$sregion_qry;
            
            return $province_str;
        }  
        
        public function gettype_filter($type_vlas,$type,$retailer_GROUPE = null)
        {
            $type_str = "";
            
            if($type=="professional")
            {    
                if(!empty($type_vlas))
                {    
                   $imp_types = implode(",",$type_vlas);
                   $type_str  = " AND rs.ID_TYPE_SPECIALISTE IN ($imp_types) ";              
                }
            }    
            
            if($type=="retailer")
            {    
                if($type_vlas!='')
                {                    
                   $type_str   = " AND rs.ID_RETAILER_TYPE = $type_vlas ";  
                   
                   if(!empty($retailer_GROUPE))
                    {
                       $imp_types  = implode(",",$retailer_GROUPE);
                       $type_str  .= " AND rs.ID_GROUPE IN ($imp_types) ";              
                    }  
                
                }
            } 
            
             if($type=="supplier")
            {    
                if($type_vlas!='')
                {  
                 // $imp_types  = implode(",",$type_vlas);
                  $type_str   = " AND f.ID_TYPE_FOURNISSEUR = $type_vlas "; 
                }
            }  
           
            if($type=="client")
            {  
                if($type_vlas!='')
                {
                     $type_str   = " AND cc.cat_type_id = $type_vlas "; 
                }
                  
            }
            
            return $type_str;
        }        
	       
         /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionGenerate_clients()
	{
            
            $model=new ExportDatas;           

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);
            

            if(isset($_POST['ExportDatas']))
            {   
                
                $model->attributes=$_POST['ExportDatas'];
                
                //if($model->validate()){                              
                
                // Subscription filter
                $subscription_str  = '';
                
                $sub_optipromo     = $_POST['ExportDatas']['Optipromo'];
                $sub_optinews      = $_POST['ExportDatas']['Optinews'];
                $sub_envision_print   =  $_POST['ExportDatas']['Envision_print'];
                $sub_envision_digital =  $_POST['ExportDatas']['Envision_digital'];
                $sub_envue_print   =  $_POST['ExportDatas']['Envue_print'];
                $sub_envue_digital =  $_POST['ExportDatas']['Envue_digital'];
                $ptype=$_POST['ExportDatas']['ptype'];
                $category=$_POST['ExportDatas']['category'];
                $subscription_str  = $this->getclientsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital,$ptype,$category); 
                 // Provience filter               
                $province_str = ''; $scntry_qry=''; $sregion_qry='';
                //$provinces    = $_POST['ExportDatas']['province'];
                $search_country = isset($_POST['ExportDatas']['country'])?$_POST['ExportDatas']['country']:'';
                $search_region  = isset($_POST['ExportDatas']['region'])?$_POST['ExportDatas']['region']:'';
                
                if ($search_country != '') {                
                    $scntry_qry = " AND ru.country = " . $search_country;
                }

                if ($search_region != '') {                
                    $sregion_qry = " AND ru.region = " . $search_region;
                }

                $province_str = $scntry_qry.$sregion_qry;
                
                // Client category Type
                $type_str  = '';
                
                $category_type = $_POST['ExportDatas']['ptype'];      
//                $type_str      = $this->gettype_filter($category_type,"client");
                $category = $_POST['ExportDatas']['category'];
                
                    
                // Export type    
                $export_type = $_POST['ExportDatas']['export_type'];
                
                // Get user counts           
                $querystr   = $subscription_str.$province_str;
                $item_count = $this->countusers($querystr,'client');
                
                if($item_count>0)
                {   
                   // Export data and save the files
                    $this->exportfiles_client( $export_type , $subscription_str , $province_str,$category_type,$category);
                 
                    Yii::app()->user->setFlash('success', 'Datas export successfully!!!');
                    $this->redirect(array('clientIndex'));
                    
                }else
                {               
                    Yii::app()->user->setFlash('danger', 'No records to generate!!!');
                    $this->redirect(array('generate_clients'));
                }  
                
//            } else {
//                echo '<pre>';
//                print_r($model->getErrors()); exit;
//            }
               
            }

            $this->render('_clientform',array(
                    'model'=>$model,
            ));
	}          
         
        public function exportfiles_client( $export_type , $subscription_str , $province_str,$category_type,$category)
        {
            Yii::import('ext.ECSVExport');
            $attach_path = Yii::getPathOfAlias('webroot').'/'.EXPORTDATAS;   
            $randstr  = Myclass::getRandomString(4);
           
            // Single file
                // Get all records list  with limit
                $ret_result = Yii::app()->db->createCommand(
                "SELECT ru.client_id AS ID,ru.ID_CLIENT ,ru.name AS Client_Name,ru.sex AS Sex,ru.company AS Company,ru.job_title AS Job_Title,
                (CASE WHEN ru.member_type <> 'free_member' THEN 'Advertiser' ELSE 'Free member' END) AS Member_Type,
                ct.cat_type AS Category_Type,GROUP_CONCAT(cc.cat_name SEPARATOR ', ')AS Category_Name,
                ru.address AS Address,  ru.local_number AS Local_number,  rp.NOM_PAYS_EN AS Country,  rr.ABREVIATION_EN AS Region,  rv.NOM_VILLE AS Ville,    ru.CodePostal, ru.phonenumber1,  ru.Poste1,ru.phonenumber2, ru.Poste2, ru.phonenumber3, ru.Europe,  ru.feurope, 
                ru.tollfree_number, ru.mobile_number,  ru.fax AS Fax,  ru.email AS Email,  ru.site_address AS Site_address, ru.Website2,
                (CASE WHEN ru.Envision_digital <> 1 THEN 'No' ELSE 'Yes' END) AS Envision_Digital ,
                (CASE WHEN ru.Envue_digital <> 1 THEN 'No' ELSE 'Yes' END) AS Envue_Digital ,
                (CASE WHEN ru.Envision_print <> 1 THEN 'No' ELSE 'Yes' END) AS Envision_Print ,
                (CASE WHEN ru.Envue_print <> 1 THEN 'No' ELSE 'Yes' END) AS Envue_Print ,                                 
                (CASE WHEN ru.Optinews <> 1 THEN 'No' ELSE 'Yes' END) AS Opti_News ,
                (CASE WHEN ru.Optipromo <> 1 THEN 'No' ELSE 'Yes' END) AS Opti_Promo ,
                ru.Rep,   ru.modified_date ,ru.created_date
                FROM client_category cc,client_profiles ru  ,client_category_types ct ,repertoire_pays  rp , repertoire_region rr ,repertoire_ville rv,client_cat_mapping cm
                WHERE cm.client_id=ru.client_id AND cm.cat_type_id=ct.cat_type_id AND cm.category=cc.category AND ru.country=rp.ID_PAYS AND ru.region=rr.ID_REGION AND ru.ville=rv.ID_VILLE                                 
                ".$subscription_str.$province_str." GROUP BY ru.client_id");
              
                // File name and path      
                if($export_type==1)
                { 
                    $filename = "Client_data_".date("Y_m_d")."_".$randstr.".csv";                
                    $outputFile_path = $attach_path.$filename;
                }else if($export_type==3)  {  
                    if(!empty($category)){
                        $cattype_name = ClientCategory::model()->findByPk($category)->cat_name;
                    }else if(!empty($category_type)) {
                    $cattype_name = ClientCategoryTypes::model()->findByPk($category_type)->cat_type;
                    }
                
                    $filename = "Client_data_".date("Y_m_d")."_".$cattype_name."_".$randstr.".csv";                
                    $outputFile_path = $attach_path.$filename;
                }                    
                
                // Export as csv file
                $this->Exceldownload($ret_result,$outputFile_path);
                $model=new ExportDatas;   
                $model->attachment_file = $filename;
                $model->user_type = "Client";
                $model->save();
  
        } 
        
        public function getclientsubscription_filter($sub_optipromo , $sub_optinews , $sub_envision_print , $sub_envision_digital , $sub_envue_print , $sub_envue_digital,$ptype,$category)
        {
            
            $subscription_arr = array();
            $subscription_arr1 = array();
            $subscription_str = '';
                
            if($sub_optipromo=="1")
            {
                $subscription_arr[] = " ru.Optipromo=1 ";
            }  

            if($sub_optinews=="1")
            {
                $subscription_arr[] = " ru.Optinews=1 ";
            }   

            if($sub_envision_print=="1")
            {
                $subscription_arr[] = " ru.Envision_print=1 ";
            }   

            if($sub_envision_digital=="1")
            {
                $subscription_arr[] = " ru.Envision_digital=1 ";
            }  

            if($sub_envue_print=="1")
            {
                $subscription_arr[] = " ru.Envue_print=1 ";
            }  

            if($sub_envue_digital=="1")
            {
                $subscription_arr[] = " ru.Envue_digital=1 ";
            } 
            if(!empty($ptype))
            {
                $subscription_arr1[] = " AND ct.cat_type_id = ".$ptype;
            }
            if(!empty($category))
            {
                $subscription_arr1[] = " AND cc.category= ".$category;
            }  else {
                $subscription_arr1[] = "";
            }
            
                
            if(!empty($subscription_arr1))
            {
                $imp_substr1 =  implode(" ",$subscription_arr1);
            }  else {
                $imp_substr1 = '';
            }
            
            if(!empty($subscription_arr))
            {
                if(count($subscription_arr)>1)
                {
                   $imp_substr =  implode(" || ",$subscription_arr);
                   
                   $subscription_str = " AND  ( $imp_substr )  ".$imp_substr1;
                }else
                {
                   $subscription_str = " AND $subscription_arr[0] ".$imp_substr1;
                }    
            }else{
                $subscription_str = $imp_substr1;
            }  
              
            return $subscription_str;
        }  
        
        /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
                $this->loadModel($id)->delete();
        
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
                    Yii::app()->user->setFlash('success', 'ExportDatas Deleted Successfully!!!');
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model=new ExportDatas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ExportDatas']))
			$model->attributes=$_GET['ExportDatas'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Lists all models.
	*/
	public function actionRetailerIndex()
	{
            $model=new ExportDatas('search');
            
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['ExportDatas']))
                    $model->attributes=$_GET['ExportDatas'];

            $this->render('retailer_index',array(
                    'model'=>$model,
            ));
	}
        
        /**
	 * Lists all models.
	*/
	public function actionSupplierIndex()
	{
            $model=new ExportDatas('search');
            
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['ExportDatas']))
                    $model->attributes=$_GET['ExportDatas'];

            $this->render('supplier_index',array(
                    'model'=>$model,
            ));
	}

         /**
	 * Lists all models.
	*/
	public function actionClientIndex()
	{
            $model=new ExportDatas('search');
            
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['ExportDatas']))
                    $model->attributes=$_GET['ExportDatas'];

            $this->render('client_index',array(
                    'model'=>$model,
            ));
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ExportDatas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ExportDatas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ExportDatas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='export-datas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
