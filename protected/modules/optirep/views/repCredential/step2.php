<?php $this->renderPartial('_register_steps', array('step' => $step)); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <h2> <?php echo Myclass::t('OR549', '', 'or'); ?> </h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rep-credential-form',
    ));
    echo $form->errorSummary(array($model, $profile));

    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions($profile->country);
    $cities = Myclass::getallcities($profile->region);
    $no_of_months = Myclass::noOfMonths();
    ?>
    <div class="form-group"> 
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'rep_username'); ?>
                <?php echo $form->textField($model, 'rep_username', array('class' => 'form-field')); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'rep_password'); ?>
                <?php echo $form->passwordField($model, 'rep_password', array('class' => 'form-field')); ?>  
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_firstname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_firstname', array('class' => 'form-field')); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_lastname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_lastname', array('class' => 'form-field')); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_email'); ?>
                <?php echo $form->textField($profile, 'rep_profile_email', array('class' => 'form-field')); ?>  
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_phone'); ?>
                <?php echo $form->textField($profile, 'rep_profile_phone', array('class' => 'form-field')); ?>  
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 register-select">    
                <?php echo $form->labelEx($model, 'no_of_accounts_purchase'); ?>
                <?php echo $form->numberField($model, 'no_of_accounts_purchase', array('class' => 'form-field', "min" => "1", "step" => "1")); ?>
            </div>            


            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_address'); ?>
                <?php echo $form->textField($profile, 'rep_address', array('class' => 'form-field')); ?>  
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'country'); ?>
                <?php echo $form->dropDownList($profile, 'country', $country, array('class' => 'selectpicker', 'empty' => 'Select')); ?>  
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'region'); ?>
                <?php echo $form->dropDownList($profile, 'region', $regions, array('class' => 'selectpicker', 'empty' => 'Select')); ?>  
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'ID_VILLE'); ?>
                <?php echo $form->dropDownList($profile, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => 'Select')); ?>  
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'no_of_months'); ?>
                <?php echo $form->dropDownList($model, 'no_of_months', $no_of_months, array('class' => 'selectpicker')); ?>  
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                        
                <a class="mapgenrate" href="javascript:void(0);" id="genratemap">
                    <?php echo Myclass::t('OR553', '', 'or'); ?>
                </a>
                <div id="display_map" style="display:none;width:auto;height:350px;"></div>                                   
            </div>

            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 pull-right steps-btn-cont"> 
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), Myclass::t('OR557', '', 'or') . ' <i class="fa fa-angle-double-right"></i>');
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div class="clearfix"> </div>

<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optirep/repCredential/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optirep/repCredential/getcities');

$ajaxgetlocation = Yii::app()->createUrl('/optirep/repCredential/generatelatlong');
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("http://maps.google.com/maps/api/js?sensor=false");

$js = <<< EOD
    $(document).ready(function(){
        $("#RepCredentialProfiles_country").change(function(){
            var id=$(this).val();
            var dataString = 'id='+ id;

            $.ajax({
                type: "POST",
                url: '{$ajaxRegionUrl}',
                data: dataString,
                cache: false,
                success: function(html){             
                    $("#RepCredentialProfiles_region").html(html).selectpicker('refresh');
                }
             });
        });

       $("#RepCredentialProfiles_region").change(function(){
            var id=$(this).val();
            var dataString = 'id='+ id;

            $.ajax({
                type: "POST",
                url: '{$ajaxCityUrl}',
                data: dataString,
                cache: false,
                success: function(html){             
                    $("#RepCredentialProfiles_ID_VILLE").html(html).selectpicker('refresh');
                }
             });

        });
        
    
     $('#genratemap').click(function(){
        var form = $('#rep-credential-form');
        $.ajax({
            type: "POST",
            url: '{$ajaxgetlocation}',
            data: form.serialize(),
            success: function( response ) {
            
                if(response!='')
                {
                    var res = response.split("~");                   

                    // Define the latitude and longitude positions
                    var latitude  = parseFloat(res[0]);
                    var longitude = parseFloat(res[1]);
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

                    // Define the map and show
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
            }
        });
     });        
                
});
EOD;
Yii::app()->clientScript->registerScript('_step2', $js);
?>