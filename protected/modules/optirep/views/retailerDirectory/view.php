<div class="cate-bg user-right">
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <div class="row"> 
        <?php
        $rep_id = Yii::app()->user->id;
        $retailerid = $model['ID_UTILISATEUR'];      
        $criteria = new CDbCriteria;
        $criteria->condition = 'rep_credential_id=:repid and ID_UTILISATEUR= :retid';
        $criteria->params = array(":repid" => $rep_id, ":retid" => $retailerid);
        $favourites = RepFavourites::model()->find($criteria);
        $fav_retailer = $favourites->ID_UTILISATEUR;
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <div class="inner-container eventslist-cont">         
                <h2> <?php echo $model['COMPAGNIE']; ?></h2>
            </div>
        </div>

        <div class="users-links">
            
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="addfav-btn">          
                <input name="FAV" type="checkbox" id="FAV" value="<?php echo $model['ID_UTILISATEUR']; ?>" <?php
                if ($fav_user != '') {
                    echo "checked=checked";
                }
                ?>>  Add to Favorites 
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> Send message', array('/optirep/internalMessage/createnew/id/'.$model['ID_UTILISATEUR']),array("class"=>"addfav-btn pull-right")); ?>
                
        </div>

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <?php echo CHtml::link('<i class="fa fa-exclamation-triangle"></i> Report a change', array('/optirep/retailerDirectory/reportuser/id/' . $model['ID_RETAILER']), array("class" => "addfav-btn pull-right","data-toggle" => "modal","data-target"=>"#sendMessage")); ?>
            
        </div>

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <?php echo CHtml::link('<i class="fa fa fa-edit"></i> Take Note', array('/optirep/retailerDirectory/preparenote/id/' . $model['ID_UTILISATEUR']), array("class" => "addfav-btn  pull-right","data-toggle" => "modal","data-target"=>"#preparenote")); ?>
           
        </div>
            
        </div>
     

        <div class="clearfix"></div>
        
         <?php
        if ($model['FICHIER'] != '') {
            $img_url = Yii::app()->getBaseUrl(true) . '/uploads/retailer_logos/' . $model['FICHIER'];
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brand-logo"> <img src="<?php echo $img_url; ?>" width="100" height="100"  alt=""> </div>
            <?php
        }
        ?>
            
            


        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
            <div class="search-list">        
                <h2><?php echo Myclass::t('OG071', '', 'og'); ?></h2>
                <p> <?php echo $model['ADRESSE']; ?>. <br/> 
                    <?php echo $model['NOM_VILLE']; ?>,  <?php echo $model['NOM_REGION_' . $this->lang]; ?><br/> 
                    <?php echo $model['NOM_PAYS_' . $this->lang]; ?><br/> 
                    <?php echo $model['CODE_POSTAL']; ?>
                </p>
                <p> <?php echo Myclass::t('OG041', '', 'og'); ?> : <?php echo $model['TELEPHONE']; ?><br>                       
                    <?php echo Myclass::t('OG042', '', 'og'); ?> : <?php echo $model['TELECOPIEUR']; ?><br>  
                    <?php echo Myclass::t('OG046', '', 'og'); ?> : <?php echo $model['TEL_1800']; ?><br>    
                </p>
                <p><?php
                    $cat = array();
                    $cat[] = $model['CATEGORY_1'];
                    $cat[] = $model['CATEGORY_2'];
                    $cat[] = $model['CATEGORY_3'];
                    $cat[] = $model['CATEGORY_4'];
                    $cat[] = $model['CATEGORY_5'];
                    $categories = array("0" => Myclass::t('OG105'), "1" => Myclass::t('OG106'), "2" => Myclass::t('OG107'), "3" => Myclass::t('OG108'), "4" => Myclass::t('OG109'));
                    echo Myclass::t('OG050', '', 'og');
                    ?> : <?php
                    $str = '';
                    foreach ($cat as $key => $info) {
                        if ($info == 1) {
                            $str[] = $categories[$key];
                        }
                    }
                    if (!empty($str)) {
                        echo implode(',', $str);
                    }
                    ?></p>
            </div>
        </div> 

        <?php if ($model['services_offered'] != '' || $model['description'] != '' || $model['classification'] != '' || $model['contact_person'] != '' || $model['established'] != '' || $model['no_of_employee'] != '' || $model['turnover'] != '') { ?>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                <div class="search-list">       
                    <h2><?php echo Myclass::t('OG072', '', 'og'); ?></h2>
                    <p><?php
                        if ($model['services_offered'] != '') {
                            echo "<b>" . Myclass::t('OG155') . "</b> : " . $model['services_offered'] . "<br/>";
                        }
                        if ($model['description'] != '') {
                            echo "<b>" . Myclass::t('OG156') . "</b> : " . $model['description'] . "<br/>";
                        }
                        if ($model['classification'] != '') {
                            echo "<b>" . Myclass::t('OG154') . "</b> : " . $model['classification'] . "<br/>";
                        }
                        if ($model['contact_person'] != '') {
                            echo "<b>" . Myclass::t('OG158') . "</b> : " . $model['contact_person'] . "<br/>";
                        }
                        if ($model['established'] != '') {
                            echo "<b>" . Myclass::t('OG128') . "</b> : " . $model['established'] . "<br/>";
                        }
                        if ($model['no_of_employee'] != '') {
                            echo "<b>" . Myclass::t('OG129') . "</b> : " . $model['no_of_employee'] . "<br/>";
                        }
                        if ($model['turnover'] != '') {
                            echo "<b>" . Myclass::t('OG153') . "</b> : " . $model['turnover'] . "<br/>";
                        }
                        ?> 
                    </p>                         
                </div>
            </div>   
            <?php
        }
        ?> 

        <?php if ($model['language'] != '' || $model['facebooklink'] != '' || $model['linkedinlink'] != '' || $model['twitterlink'] != '') { ?>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                <div class="search-list">       
                    <h2>Other Informations</h2>    
                    <p><?php
                        if ($model['language'] != '') {
                            echo "<b>" . Myclass::t('OG159') . "</b> : " . $model['language'] . "<br/>";
                        }
                        if ($model['facebooklink'] != '') {
                            echo "<b>Facebook</b> : " . $model['facebooklink'] . "<br/>";
                        }
                        if ($model['twitterlink'] != '') {
                            echo "<b>Twitter</b> : " . $model['twitterlink'] . "<br/>";
                        }
                        if ($model['linkedinlink'] != '') {
                            echo "<b>LinkedIn</b> : " . $model['linkedinlink'] . "<br/>";
                        }
                        ?>              
                    </p> 
                </div>
            </div>  
            <?php
        }
        ?> 
            
        <?php if($model['map_lat'] && $model['map_long'])
         { ?>    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">         
         <div id="display_map" style="display:none;width:100%;height:350px; "></div> 
        </div>
         <?php 
         }?>
        
        <?php if (!empty($results)) { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                <h2> <?php echo Myclass::t('OGO157', '', 'og'); ?> </h2> 
                <div class="box" id="box1">
                    <div class="brands">               
                        <ul>
                            <?php foreach ($results as $info) { ?>
                                <li>
                                    <?php
                                    $dispname = $info['NOM'] . ',' . $info['PRENOM'];
                                    echo CHtml::link($dispname, array('/optirep/professionalDirectory/view', 'id' => $info['ID_SPECIALISTE']), array('target' => '_blank')) . ' ';
                                    echo $info['NOM_VILLE'] . "," . $info['ABREVIATION_' . $this->lang] . "," . $info['NOM_PAYS_' . $this->lang];
                                    ?>
                                </li>
                            <?php } ?>                       
                        </ul>               
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>  
        <?php } ?>  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
        <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> ' . Myclass::t('OG016', '', 'og'), array('/optirep/retailerDirectory'), array("class" => "pull-left")); ?> </div>  
        </div>
    </div>
</div>  

<!-- Report Modal Box-->
<div class="modal fade" id="sendMessage" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Report</h4>
            </div>
             <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'report_form',
                'htmlOptions' => array('role' => 'form'),               
            ));
            ?>
            <div class="modal-body model-form">
                <div class="row"> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Report as </label>
                        <select class="selectpicker" name="report_reason">
                            <option value="moved">Moved</option>
                            <option value="closed">Closed</option>                         
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Comments </label>
                        <textarea class="form-field-textarea" name="report_message"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'ReportSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), 'Send');
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>


<!-- Note Modal Box-->
<div class="modal fade" id="preparenote" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Note</h4>
            </div>
             <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'note_form',
                'htmlOptions' => array('role' => 'form'),               
            ));
            ?>
            <div class="modal-body model-form">
                <div class="row"> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>For: </label>   <?php echo $model['NOM_UTILISATEUR']; ?>                      
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Notes </label>
                        <textarea class="form-field-textarea" name="message"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'NoteSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), 'Submit');
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php
$lat  = $model['map_lat'];
$long = $model['map_long'];
$ajaxUpdatefav = Yii::app()->createUrl('/optirep/repFavourites/updatefav');
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("http://maps.google.com/maps/api/js?sensor=false");
$js = <<< EOD
$(document).ready(function(){
        
     var latval  = parseFloat("{$lat}") || 0;
     var longval = parseFloat("{$long}") || 0;
        
     function initialize() {
      
        // Define the latitude and longitude positions
        var latitude = parseFloat(latval); // Latitude get from above variable
        var longitude = parseFloat(longval); // Longitude from same
        var latlngPos = new google.maps.LatLng(latitude, longitude);

        // Set up options for the Google map
        var mapOptions = {
            zoom: 15,
            center: latlngPos,
            zoomControlOptions: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE
            }
        };
        // Define the map
        $("#display_map").show();
        map = new google.maps.Map(document.getElementById("display_map"), mapOptions);

        var marker = new google.maps.Marker({
                  position: latlngPos,
                  map: map,
                  icon:'{$this->themeUrl}/images/map-red.png',
                  draggable:false,
                  animation: google.maps.Animation.DROP
          });
    }   
    
    if(latval!=0 && longval!=0)
    {    
        google.maps.event.addDomListener(window, 'load', initialize);    
    }       
        
        
    $('input').iCheck({
                    checkboxClass: 'icheckbox_flat-pink',
                    radioClass: 'iradio_flat-pink'
                });
        
    $('.box').lionbars();    
        
    $('input[name="FAV"]').on('ifClicked', function(event){      
      
        var ret_val =  $(this).attr("value");   
        if($(this).attr('checked')){
            var fav_status = 'removefav';
        }else{
       
            var fav_status = 'addfav';
        }
        
        var dataString = 'id='+ ret_val+'&favstatus='+fav_status;
           $.ajax({
               type: "POST",
               url: '{$ajaxUpdatefav}',
               data: dataString,
               cache: false,
               success: function(html){             
               }
            });
      
    });  

        
});
EOD;
Yii::app()->clientScript->registerScript('_form_view', $js);
?>