<div class="cate-bg user-right">
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); 
    $professionalemail = $model['COURRIEL']; 
    ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <div class="inner-container eventslist-cont">         
                <h2> <?php echo strtoupper($model['PRENOM']); ?>  <?php echo strtoupper($model['NOM']); ?>, <?php echo strtoupper($model['TYPE_SPECIALISTE_' . $this->lang]); ?></h2>                  
                <?php 
                if($professionalemail=='')
                { ?>  
                   <p><?php echo Myclass::t('OR758', '', 'or');?></p>
               <?php        
                } ?>
            </div>
          
        </div>   
        
        <?php
        $rep_id = Yii::app()->user->id;
        $userid = $model['ID_UTILISATEUR'];
        $criteria = new CDbCriteria;
        $criteria->condition = 'rep_credential_id=:repid and ID_UTILISATEUR= :retid';
        $criteria->params = array(":repid" => $rep_id, ":retid" => $userid);
        $favourites = RepFavourites::model()->find($criteria);
        $fav_user = $favourites->ID_UTILISATEUR;        
        ?>
        
        <div class="users-links">
       

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="addfav-btn">          
                    <input name="FAV" type="checkbox" id="FAV" value="<?php echo $model['ID_UTILISATEUR']; ?>" <?php
                    if ($fav_user != '') {
                        echo "checked=checked";
                    }
                    ?>>  <?php echo Myclass::t('OR631', '', 'or'); ?>
                </div>
            </div>

            <?php if($professionalemail!='')
                 { ?>    
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> ' . Myclass::t('OR621', '', 'or'), array('#'), array("class" => "addfav-btn pull-right", "data-toggle" => "modal", "data-target" => "#sendmessage")); ?>
            </div>
            <?php } ?>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo CHtml::link('<i class="fa fa-exclamation-triangle"></i> ' . Myclass::t('OR632', '', 'or'), array('#'), array("class" => "addfav-btn pull-right", "data-toggle" => "modal", "data-target" => "#reportchange")); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo CHtml::link('<i class="fa fa fa-edit"></i> ' . Myclass::t('OR567', '', 'or'), array('#'), array("class" => "addfav-btn pull-right", "data-toggle" => "modal", "data-target" => "#preparenote")); ?>
            </div>

        </div>
        <?php
        // For map direction display
        $endmap = array();
        if($model['ADRESSE']!='')
        {
            $endmap[] = $model['ADRESSE'];
        }
        if($model['NOM_VILLE']!='')
        {
            $endmap[] = $model['NOM_VILLE'];
        }
        if($model['NOM_REGION_EN']!='')
        {
            $endmap[] = $model['NOM_REGION_EN'];
        }
        if($model['NOM_PAYS_EN']!='')
        {
            $endmap[] = $model['NOM_PAYS_EN'];
        }
        if($model['CODE_POSTAL']!='')
        {
            $endmap[] =$model['CODE_POSTAL'];
        }
        $destination_address = implode(",",$endmap);   
        
        // Rep address
        $startmap = array();
        if($repModel['rep_address']!='')
        {
            $startmap[] = $repModel['rep_address'];
        }
        $startmap[] = $repModel['NOM_VILLE'];
        $startmap[] = $repModel['NOM_REGION_EN'];
        $startmap[] = $repModel['NOM_PAYS_EN'];       
        $start_address = implode(",",$startmap); 
        
       
        ?>

        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">         
            <div class="search-list">                   
                <p><strong><?php echo $model['BUREAU']; ?></strong><br>
                    <?php echo $model['ADRESSE']; ?> <br/> 
                    <?php echo $model['NOM_VILLE']; ?>,  <?php echo $model['NOM_REGION_' . $this->lang]; ?><br/> 
                    <?php echo $model['NOM_PAYS_' . $this->lang]; ?><br/> 
                    <?php echo $model['CODE_POSTAL']; ?>
                </p>
                <p> <?php echo Myclass::t('OG041', '', 'og'); ?> : <?php echo $model['TELEPHONE']; ?><br>                       
                    <?php echo Myclass::t('OG042', '', 'og'); ?> : <?php echo $model['TELECOPIEUR']; ?><br>                      
                </p>
            </div>
        </div> 

        <?php if ($model['map_lat'] && $model['map_long']) {
            ?>  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">         
                <p style="color:red;"><?php echo Myclass::t('OG216');?></p>  
                <div id="display_map" style="display:none;width:100%;height:350px; margin: 0;"></div> 
                <div id="directionsPanel" style="display:none; width:100%;height: 350px; overflow: auto; margin: 0;"></div>
            </div>
        <?php }
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
            <div class="viewall">
            <?php $pre_url=Yii::app()->request->urlReferrer; 
                  if(empty($pre_url)){?>
                <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> ' . Myclass::t('OG016', '', 'og'), array('/optirep/professionalDirectory'), array("class" => "pull-left")); ?>
            <?php }else{?>
                <a class='pull-left' href="<?php echo $pre_url; ?>"><i class="fa fa-arrow-circle-left"></i><?php echo Myclass::t('OG016', '', 'og');?>  </a>
            <?php }?>
                </div>  
        </div>        

        <?php if (!empty($results)) { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                <h2> <?php echo Myclass::t('OGO158', '', 'og'); ?> </h2> 
                <div class="box" id="box1">
                    <div class="brands">    
                        <ul>
                            <?php foreach ($results as $info) { ?>
                                <li>
                                    <?php
                                    $dispname = $info['COMPAGNIE'];
                                    echo CHtml::link($dispname, array('/optirep/retailerDirectory/view', 'id' => $info['ID_RETAILER']), array('target' => '_blank')) . ' ';
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
    </div>
</div>  

<!-- Report Modal Box-->
<div class="modal fade" id="reportchange" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo Myclass::t('OR633', '', 'or'); ?></h4>
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
                        <label><?php echo Myclass::t('OR634', '', 'or'); ?> </label>
                        <select class="selectpicker" name="report_reason">
                            <option value="moved"><?php echo Myclass::t('OR635', '', 'or'); ?></option>
                            <option value="closed"><?php echo Myclass::t('OR636', '', 'or'); ?></option>                         
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label><?php echo Myclass::t('OR637', '', 'or'); ?> </label>
                        <textarea class="form-field-textarea" id="report_message" name="report_message"></textarea>
                        <div style="display:none;" class="errorMessage" id="report_error">
                            <?php echo Myclass::t('OR638', '', 'or'); ?>.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'ReportSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), Myclass::t('OR639', '', 'or'));
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
                <h4 class="modal-title"><?php echo Myclass::t('OR640', '', 'or') ?></h4>
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
                        <label><?php echo Myclass::t('OR641', '', 'or') ?>: </label>   
                        <?php echo $model['NOM_UTILISATEUR']; ?>                      
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label><?php echo Myclass::t('OR573', '', 'or') ?>: </label>
                        <textarea class="form-field-textarea" id="note_message" name="message"></textarea>
                        <div style="display:none;" class="errorMessage" id="note_error">
                            <?php echo Myclass::t('OR642', '', 'or') ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label><?php echo Myclass::t('OR574', '', 'or') ?></label>
                        <div id="" class="input-append date">
                            <input type="text" class="form-field" name="alert_date" id="reminder_datepicker">
                            <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                            <small>
                                <b><?php echo Myclass::t('OR569', '', 'or') ?>:</b> 
                                <?php echo Myclass::t('OR570', '', 'or') ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'NoteSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), Myclass::t('APP25'));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<!-- Send Message Modal Box-->
<div class="modal fade" id="sendmessage" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo Myclass::t('OR621', '', 'or') ?></h4>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'send_message_form',
                'htmlOptions' => array('role' => 'form'),
                'action' => Yii::app()->createUrl('/optirep/internalMessage/createnew'),
            ));
            ?>
            <div class="modal-body model-form">
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label><?php echo Myclass::t('OR643', '', 'or') ?>: </label>   
                        <?php echo $model['NOM_UTILISATEUR']; ?>                      
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label><?php echo Myclass::t('OR624', '', 'or') ?> </label>                       
                        <?php echo $form->textArea($internalmodel, 'message', array('class' => 'form-field-textarea', "id" => "messageval", 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?> 
                        <div style="display:none;" class="errorMessage" id="message_error">
                            <?php echo Myclass::t('OR644', '', 'or') ?>
                        </div>
                    </div>
                </div>
            </div>            
            <?php echo $form->hiddenField($internalmodel, 'user2', array("value" => $userid)); ?>
            <div class="modal-footer">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'SendMessage',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), Myclass::t('OR639', '', 'or'));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php
$themeUrl = $this->themeUrl;

$ajaxUpdatefav = Yii::app()->createUrl('/optirep/repFavourites/updatefav');
$lat = $model['map_lat']; 
$long = $model['map_long'];

$lang_started  = Myclass::t('OG217');
$lang_Walk     = Myclass::t('OG218');
$lang_Highways = Myclass::t('OG219');
$lang_Destination    = Myclass::t('OG220');
$lang_getdirections  = Myclass::t('OG221');

$startval = $start_address;
$endval   = $destination_address;

$rep_address = $destination_address;

$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("http://maps.google.com/maps/api/js");
$cs->registerCssFile($themeUrl . '/css/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/bootstrap-datepicker.js', $cs_pos_end);

$js = <<< EOD
$(document).ready(function(){
        
    $('#reminder_datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '+1d'
    });
            
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
               
    $('#note_form').on('submit', function() {
               
        var notmsg = $("#note_message").val();      
        $("#note_error").hide();
        if(notmsg=='')
        {
             $("#note_error").show();
             return false; 
        }    
    });
               
    $('#report_form').on('submit', function() {
               
        var rprtmsg = $("#report_message").val();      
        $("#report_error").hide();
        if(rprtmsg=='')
        {
             $("#report_error").show();
             return false; 
        }    
    });  
    
   $('#send_message_form').on('submit', function() {
               
         var msgval= $("#messageval").val();      
         $("#message_error").hide();
         if(msgval=='')
         {
              $("#message_error").show();
              return false; 
         }    
    }); 
        
    $("body").on('click','#viewpaths', function() {
             myDirections();          
    });            
});
                   
    // MAP display           
    var latval   = parseFloat("{$lat}") || 0;
    var longval  = parseFloat("{$long}") || 0;
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();
    var gmarkers = [];
    var htmls    = [];
    var map      = null;
    
    var infowindow = new google.maps.InfoWindow({
       size: new google.maps.Size(150, 50)
     });
    
    function initialize() 
    {
       var location   = new google.maps.LatLng(latval, longval);
       var mapOptions = {
         center: location,
         zoom: 8,
         scrollwheel: true
       };

       map = new google.maps.Map(document.getElementById("display_map"), mapOptions);

       directionsDisplay.setMap(map);
       directionsDisplay.setPanel(document.getElementById("directionsPanel"));
       google.maps.event.addListener(map, 'click', function() {
         infowindow.close();
       });

       var marker = new google.maps.Marker({
         position: location,
         map: map,
         animation: google.maps.Animation.DROP,
         icon : '{$this->themeUrl}/images/map-red.png',   
         title: '{$rep_address}'    
       });

       var i  = gmarkers.length;
       latlng = location;    
         
        var html = 
         '<strong>{$lang_started}:</strong><form action="#">' +
         '<input type="text" SIZE=40 MAXLENGTH=60 name="saddr" id="saddr" value="" /><br>' +
         '<input value="{$lang_getdirections}" id="viewpaths" TYPE="button"><br>' +    
         '{$lang_Walk} <input type="checkbox" name="walk" id="walk" /> &nbsp; {$lang_Highways} <input type="checkbox" name="highways" id="highways" />' +
         '<input type="hidden" id="daddr" value="' + latlng.lat() + ',' + latlng.lng() +     
         '"/><br><br><strong>{$lang_Destination}:</strong>' + marker.getTitle();
        var contentString = html;

       google.maps.event.addListener(marker, 'click', function() {
         map.setZoom(15);
         map.setCenter(marker.getPosition());
         infowindow.setContent(contentString);
         infowindow.open(map, marker);
       });
       // save the info we need to use later for the side_bar
       gmarkers.push(marker);
       htmls[i] = html;
    }

    if(latval!=0 && longval!=0)
    { 
        google.maps.event.addDomListener(window, 'load', initialize);
        $("#display_map").show();       
    }
    
    // ===== request the directions =====
    function myDirections() 
    {
       // ==== Set up the walk and avoid highways options ====
       var request = {};
       if (document.getElementById("walk").checked) {
         request.travelMode = google.maps.DirectionsTravelMode.WALKING;
       } else {
         request.travelMode = google.maps.DirectionsTravelMode.DRIVING;
       }

       if (document.getElementById("highways").checked) {
         request.avoidHighways = true;
       }
       // ==== set the start and end locations ====
       var saddr = document.getElementById("saddr").value;
       var daddr = '{$rep_address}';

       request.origin = saddr;
       request.destination = daddr;
       directionsService.route(request, function(response, status) {
         if (status == google.maps.DirectionsStatus.OK) {
           directionsDisplay.setDirections(response);
           $("#directionsPanel").show();   
         } else alert("Directions not found: " + status);
       });
     }         
EOD;
Yii::app()->clientScript->registerScript('_form_view', $js);

//
//var latval  = parseFloat("{$lat}") || 0;
//    var longval = parseFloat("{$long}") || 0;
//        
//     function initialize() {
//      
//        // Define the latitude and longitude positions
//        var latitude = parseFloat(latval); // Latitude get from above variable
//        var longitude = parseFloat(longval); // Longitude from same
//        var latlngPos = new google.maps.LatLng(latitude, longitude);
//
//        // Set up options for the Google map
//        var mapOptions = {
//            zoom: 15,
//            center: latlngPos,
//            zoomControlOptions: true,
//            zoomControlOptions: {
//                style: google.maps.ZoomControlStyle.LARGE
//            }
//        };
//        // Define the map
//        $("#display_map").show();
//        map = new google.maps.Map(document.getElementById("display_map"), mapOptions);
//
//        var marker = new google.maps.Marker({
//                  position: latlngPos,
//                  map: map,
//                  icon:'{$this->themeUrl}/images/map-red.png',
//                  draggable:false,
//                  animation: google.maps.Animation.DROP
//          });
//    }   
//    
//    if(latval!=0 && longval!=0)
//    {    
//        google.maps.event.addDomListener(window, 'load', initialize);    
//    } 


// HIDE on JAN 09
//var latval   = parseFloat("{$lat}") || 0;
//    var longval  = parseFloat("{$long}") || 0;
//    var startval = "{$startval}";
//    var endval   = "{$endval}";
//               
//    var directionsDisplay;
//    var directionsService = new google.maps.DirectionsService();
//    function initialize() 
//    {
//        directionsDisplay = new google.maps.DirectionsRenderer();
//        var latlng = new google.maps.LatLng(latval, longval);
//        var myOptions =
//        {
//            zoom: 8,
//            center: latlng,
//            mapTypeId: google.maps.MapTypeId.ROADMAP
//        };
//        calcRoute(startval,endval); 
//        // Define the map
//        $("#display_map").show();
//        var map = new google.maps.Map(document.getElementById("display_map"), myOptions);
//        directionsDisplay.setMap(map);
//    }
//    function calcRoute(startval,endval) 
//    {
//       // var selectedMode = document.getElementById("mode").value;
//       // var start = document.getElementById("start").value;
//       // var end = document.getElementById("end").value;
// 
//       var selectedMode = "DRIVING";
//       var start = startval;
//       var end   = endval;
//    
//        google.maps.DirectionsTravelMode.DRIVING
//
//            if(selectedMode=="DRIVING")
//            {
//                var request = {
//                origin: start,
//                destination: end,
//                travelMode:google.maps.DirectionsTravelMode.DRIVING
//                };
//            }
//            else if(selectedMode=="WALKING")
//            {
//                var request = {
//                origin: start,
//                destination: end,
//                travelMode:google.maps.DirectionsTravelMode.WALKING
//                };
//            }
//            else if(selectedMode=="BICYCLING")
//            {
//                var request = {
//                origin: start,
//                destination: end,
//                travelMode:google.maps.DirectionsTravelMode.BICYCLING
//                };
//            }
//
//            directionsService.route(request, function (response, status) {
//            if (status == google.maps.DirectionsStatus.OK) {   
//                directionsDisplay.setDirections(response);
//            }
//        });
//
//    }
?>   