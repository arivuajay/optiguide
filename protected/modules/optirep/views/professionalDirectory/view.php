<div class="cate-bg user-right">
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <div class="inner-container eventslist-cont">         
                <h2> <?php echo $model['PRENOM']; ?>  <?php echo $model['NOM']; ?>  , <?php echo $model['TYPE_SPECIALISTE_' . $this->lang]; ?></h2>
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
                    ?>>  Add to Favorites 
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> Send message', array('#'), array("class" => "addfav-btn pull-right", "data-toggle" => "modal", "data-target" => "#sendmessage")); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo CHtml::link('<i class="fa fa-exclamation-triangle"></i> Report a change', array('#'), array("class" => "addfav-btn pull-right", "data-toggle" => "modal", "data-target" => "#reportchange")); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo CHtml::link('<i class="fa fa fa-edit"></i> Add Note', array('#'), array("class" => "addfav-btn pull-right", "data-toggle" => "modal", "data-target" => "#preparenote")); ?>
            </div>

        </div>


        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">         
            <div class="search-list">                   
                <p><strong><?php echo $model['BUREAU']; ?></strong><br>
                    <?php echo $model['ADRESSE']; ?>. <br/> 
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
                <div id="display_map" style="display:none;width:100%;height:350px; "></div> 
            </div>
        <?php }
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">            
            <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> ' . Myclass::t('OG016', '', 'og'), array('/optirep/professionalDirectory'), array("class" => "pull-left")); ?> </div>  
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
                        <textarea class="form-field-textarea" id="report_message" name="report_message"></textarea>
                        <div style="display:none;" class="errorMessage" id="report_error">Comments required.</div>
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
                        <textarea class="form-field-textarea" id="note_message" name="message"></textarea>
                        <div style="display:none;" class="errorMessage" id="note_error">Notes required.</div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Reminder Date</label>
                        <div id="reminder_datepicker" class="input-append date">
                            <input type="text" class="form-field" name="alert_date">
                            <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                            <small><b>NOTE:</b> If you choose any date in the above field, you will get the reminder email in that particular date.</small>
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
                        ), 'Save');
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
                <h4 class="modal-title">Send Message</h4>
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
                        <label>To: </label>   <?php echo $model['NOM_UTILISATEUR']; ?>                      
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Message </label>                       
                        <?php echo $form->textArea($internalmodel, 'message', array('class' => 'form-field-textarea', "id" => "messageval", 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?> 
                        <div style="display:none;" class="errorMessage" id="message_error">Message required.</div>
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
                        ), 'Send');
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php
$ajaxUpdatefav = Yii::app()->createUrl('/optirep/repFavourites/updatefav');
$lat = $model['map_lat'];
$long = $model['map_long'];
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("http://maps.google.com/maps/api/js?sensor=false");
$js = <<< EOD
$(document).ready(function(){
        
        $('#reminder_datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '+1d'
        });
        
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
            
});
EOD;
Yii::app()->clientScript->registerScript('_form_view', $js);
?>