<?php
   
    $_controller = Yii::app()->controller->id;   
    $_action     = Yii::app()->controller->action->id;
    
    if(($_controller=="professionalDirectory" || $_controller=="retailerDirectory") && $_action=="index" )
    {    
        // ext is your protected.extensions folder
        // gmaps means the subfolder name under your protected.extensions folder
        Yii::import('ext.gmaps.*');    
        $gMap = new EGMap();       
        
        $mapTypeControlOptions = array(
            'sensor'=>true,
            'position'=> EGMapControlPosition::LEFT_BOTTOM,
            'style'=>EGMap::MAPTYPECONTROL_STYLE_DROPDOWN_MENU
        );
        $gMap->mapTypeControlOptions= $mapTypeControlOptions; 
        $lat  = 45.477825;
        $long = -75.692627;
        $gMap->setWidth('100%');
        $gMap->setHeight(400);
        $gMap->zoom = 5;        
        $gMap->setCenter($lat, $long);
        
        $page  = Yii::app()->request->getParam('page');
        $page  = isset($page) ? $page : 1; 
        $limit = 0;

         if($page>1){
          $offset = $page-1;   
          $limit  = LISTPERPAGE * $offset;
         }   

        $sname_qry   = '';
        $scat_query  = '';
        $scntry_qry  = '';
        $sregion_qry = '';  
        $scity_qry   = ''; 
        $spostal_qry = '';
     ?>   
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">       
                <?php
                if($_controller=="retailerDirectory")
                {  
                    // $searchModel->unsetAttributes();
                   if (isset($_GET['RetailerDirectory'])) 
                   { 
                       $search_name    = isset($_GET['RetailerDirectory']['COMPAGNIE'])?$_GET['RetailerDirectory']['COMPAGNIE']:'';
                       $search_cat     = isset($_GET['RetailerDirectory']['searchcat'])?$_GET['RetailerDirectory']['searchcat']:'';
                       $search_country = isset($_GET['RetailerDirectory']['country'])?$_GET['RetailerDirectory']['country']:'';
                       $search_region  = isset($_GET['RetailerDirectory']['region'])?$_GET['RetailerDirectory']['region']:'';
                       $search_ville   = isset($_GET['RetailerDirectory']['ID_VILLE'])?$_GET['RetailerDirectory']['ID_VILLE']:'';
                       $search_postal  = isset($_GET['RetailerDirectory']['CODE_POSTAL'])?$_GET['RetailerDirectory']['CODE_POSTAL']:'';

                       if( $search_name != ''){ $sname_qry  = " AND rs.COMPAGNIE like '%$search_name%' ";    }  
                       if( $search_cat != ''){ $scat_query = " AND CATEGORY_$search_cat ";               }
                       if( $search_country != ''){ $scntry_qry  = " AND rp.ID_PAYS = ". $search_country;     } 
                       if( $search_region != ''){ $sregion_qry  = " AND rr.ID_REGION = ". $search_region;   } 
                       if( $search_ville != ''){ $scity_qry    = " AND rs.ID_VILLE = ". $search_ville; } 
                       if( $search_postal != '') { $spostal_qry    = " AND CODE_POSTAL = ". $search_postal;}
                      
                        $results = Yii::app()->db->createCommand() //this query contains all the data
                        ->select(' COMPAGNIE , NOM_TYPE_'.$this->lang.' ,  NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.', map_lat , map_long')
                        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                        ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS "
                                . "AND ru.status=1 AND ru.NOM_TABLE ='Detaillants' ".$sname_qry.$scntry_qry.$sregion_qry.$scity_qry.$scat_query.$spostal_qry)
                        ->order('COMPAGNIE ASC')
                        ->limit( LISTPERPAGE , $limit) // the trick is here!
                        ->queryAll();
                   }               
                    
                
                }
                
                if($_controller=="professionalDirectory")
                {   
                    // $searchModel->unsetAttributes();
                    if (isset($_GET['ProfessionalDirectory'])) {

                        $search_name = isset($_GET['ProfessionalDirectory']['NOM']) ? $_GET['ProfessionalDirectory']['NOM'] : '';
                        $search_country = isset($_GET['ProfessionalDirectory']['country']) ? $_GET['ProfessionalDirectory']['country'] : '';
                        $search_region = isset($_GET['ProfessionalDirectory']['region']) ? $_GET['ProfessionalDirectory']['region'] : '';
                        $search_ville = isset($_GET['ProfessionalDirectory']['ID_VILLE']) ? $_GET['ProfessionalDirectory']['ID_VILLE'] : '';

                        if ($search_name != '') { $sname_qry = " AND NOM like '%$search_name%' "; }
                        if ($search_country != '') {  $scntry_qry = " AND rp.ID_PAYS = " . $search_country; }
                        if ($search_region != '') {   $sregion_qry = " AND rr.ID_REGION = " . $search_region; }
                        if ($search_ville != '') { $scity_qry = " AND rs.ID_VILLE = " . $search_ville; }
                    }

                    // Get all records list  with limit
                    $results = Yii::app()->db->createCommand() //this query contains all the data
                            ->select('NOM , PRENOM , TYPE_SPECIALISTE_'.$this->lang.' , NOM_VILLE ,  NOM_REGION_'.$this->lang.' , ABREVIATION_'.$this->lang.' ,  NOM_PAYS_'.$this->lang.' , map_lat , map_long')
                            ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                            ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' " . $sname_qry . $scntry_qry . $sregion_qry . $scity_qry)
                            ->order('rst.TYPE_SPECIALISTE_' . $this->lang . ',NOM')
                            ->limit(LISTPERPAGE, $limit) // the trick is here!
                            ->queryAll();
                     
                }

                if (!empty($results)) {
                    foreach ($results as $rinfo) {
                         // Create marker
                         $dispname ='';
                         $pickup_latitude  = $rinfo['map_lat']; 
                         $pickup_longitude = $rinfo['map_long'];
                         
                         if($pickup_latitude!='' && $pickup_longitude!='')
                         {
                             
                            if($_controller=="professionalDirectory")
                            {
                                $titlename = $rinfo['NOM'].",".$rinfo['PRENOM'];
                                $dispname  = $rinfo['NOM'].",".$rinfo['PRENOM'].",".$rinfo['NOM_VILLE'].",".$rinfo['ABREVIATION_'.$this->lang].",".$rinfo['NOM_PAYS_'.$this->lang];                                 
                            }elseif ($_controller=="retailerDirectory") {
                                $titlename = $rinfo['COMPAGNIE'];
                                $dispname  = $rinfo['COMPAGNIE'].",".$rinfo['NOM_VILLE'].",".$rinfo['ABREVIATION_'.$this->lang].",".$rinfo['NOM_PAYS_'.$this->lang]; 
                            }   
                             
                            $info_window = new EGMapInfoWindow('<div>'.$dispname.'</div>');
                            
                            $gMap->setCenter($pickup_latitude, $pickup_longitude);                   
                            
                            // Create marker
                            $marker = new EGMapMarker($pickup_latitude, $pickup_longitude, array('title' => $titlename));
                            $marker->addHtmlInfoWindow($info_window);
                            $gMap->addMarker($marker);

                         }   
                     }      
                     // enabling marker clusterer just for fun
                     // to view it zoom-out the map
                    // $gMap->addMarker( new EGMapMarker(39.721089311812094, 2.91165944519042) );
                     $gMap->enableMarkerClusterer(new EGMapMarkerClusterer());
                     
                }  
                $gMap->renderMap();
                //end of egmap
                ?>      
            </div>   
    <?php }?>