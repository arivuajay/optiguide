<div class="cate-bg user-right profile-pages">
    <h2> <?php echo Myclass::t('OR552', '', 'or'); ?> </h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rep-credential-form',
        'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    echo $form->errorSummary(array($model, $profile));

    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions($profile->country);
    $cities = Myclass::getallcities($profile->region);

    $criteria1 = new CDbCriteria();
    $criteria1->order = "NOM_MARQUE";
    $all_marques = CHtml::listData(MarqueDirectory::model()->isActive()->findAll($criteria1), 'ID_MARQUE', 'NOM_MARQUE');
    $selected_marques = $profile->rep_brands;
    $selected_marques_array = explode(',', $selected_marques);
    ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <?php echo $form->labelEx($model, 'rep_username'); ?>
            <?php echo $form->textField($model, 'rep_username', array('class' => 'form-field')); ?>                
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

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <?php echo $form->labelEx($profile, 'rep_company'); ?>
            <?php echo $form->textField($profile, 'rep_company', array('class' => 'form-field')); ?>  
        </div>

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <?php echo $form->labelEx($profile, 'rep_territories'); ?>
            <?php echo $form->textField($profile, 'rep_territories', array('class' => 'form-field')); ?>  
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
        
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="other_city" style="display:none;">
            <?php echo $form->labelEx($profile, 'autre_ville'); ?>
            <?php echo $form->textField($profile, 'autre_ville', array('class' => 'form-field')); ?>  
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <label class="required" for="#">&nbsp;</label>
            <a class="mapgenrate" href="javascript:void(0);" id="genratemap">
                <?php echo Myclass::t('OR553', '', 'or'); ?>
            </a>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                       
            <div id="display_map" style="display:none;width:auto;height:350px;"></div>                                    
        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $form->labelEx($profile, 'image'); ?>
            <?php echo $form->fileField($profile, 'image'); ?> 
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                    <?php echo $form->labelEx($profile, 'rep_brands'); ?>
                    <input type="text" class="search form-field" placeholder="<?php echo Myclass::t('OR721', '', 'or'); ?>">
                </div>
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 brand_search">
                    <a href="javascript:void(0)" class="search_link btn btn-primary">
                        <?php echo Myclass::t('OR554', '', 'or'); ?>
                    </a>
                    <span class="counter"></span>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
            <div class="inner-container"> 
                <div class="forms-cont">  
                    <div class="box" id="box1">
                        <table class="table table-bordered results">
                            <tr class="warning no-result">
                                <td><i class="fa fa-warning"></i> <?php echo Myclass::t('OR043', '', 'or'); ?> </td>
                            </tr>
                            <tbody id="yes-resulet">
                                
                            </tbody>
                            <tbody>
                                <?php
                                if (!empty($all_marques)) {
                                    foreach ($all_marques as $key => $value) {
                                        $checked = '';
                                        if (!empty($selected_marques_array)) {
                                            if (in_array($key, $selected_marques_array)) {
                                                $checked = "checked";
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="marqueid[]" class="simple checkbox1" <?php echo $checked; ?> value="<?php echo $key; ?>"> 
                                                <?php echo $value; ?>
                                            </td>
                                        </tr>    
                                        <?php
                                    }
                                }
                                ?>                         
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div>
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="add_brand">
            <div class="row">
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                    <input type="text" class="form-field" id="new_brand" placeholder="<?php echo Myclass::t('OG229');?>">
                    <div style="" id="new_brand_error" class="errorMessage" style="display:none;"></div>
                </div>
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                    <a href="javascript:void(0)" class="btn btn-success" id="add_brand_link">
                        <?php echo Myclass::t('OG230');?>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), Myclass::t('APP505'));
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<style>
    #add_brand{
        margin-top: 20px;
    }
</style>
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optirep/repCredential/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optirep/repCredential/getcities');
$ajaxbrand = Yii::app()->createUrl('/optirep/repCredential/getbrand');

$ajaxgetlocation = Yii::app()->createUrl('/optirep/repCredential/generatelatlong');
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("http://maps.google.com/maps/api/js?sensor=false");

$lat = $profile->rep_lat;
$long = $profile->rep_long;

$already=Myclass::t('OG231');
$empty=Myclass::t('OG232');

$ctyval = isset($profile->ID_VILLE) ? $profile->ID_VILLE : '';

$js = <<< EOD
    $(document).ready(function(){
        
        var already="<?php echo ?>";
        $("#add_brand_link").click(function(){
            $('#new_brand_error').hide();
            var MARQUE=$('#new_brand').val();
            if(MARQUE!=''){
                var dataString = 'MARQUE='+ MARQUE;
                $.ajax({
                    type: "POST",
                    url: '{$ajaxbrand}',
                    data: dataString,
                    cache: false,
                    success: function(reps){
                        if(reps=='exit'){
                            $('#new_brand_error').text('{$already}');
                            $('#new_brand_error').show();
                            $('.no-result').hide();

                            $(".results tbody tr").each(function (e) {
                                    $(this).attr('visible', 'true');
                                });

                            }else{
                            $('#new_brand_error').hide();
                            $('.no-result').hide();

                            $('#new_brand').val('');
                                $("#yes-resulet").append('<tr visible="true"><td><input type="checkbox" name="marqueid[]" class="simple checkbox1" checked="checked" value="'+reps+'">'+MARQUE+'<tr><td>');
                                $(".results tbody tr").each(function (e) {
                                    $(this).attr('visible', 'true');
                                });
                                }
                    }
                 });
            }else{
                $('#new_brand_error').text('{$empty}'); 
                $('#new_brand_error').show();
            }
        });
        
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
                
    //MAP display
        
    var latval  = parseFloat("{$lat}") || 0;
    var longval = parseFloat("{$long}") || 0;
        
    function initialize() {
      
        // Define the latitude and longitude positions
        var latitude  = parseFloat(latval); // Latitude get from above variable
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
                
    $(document).ready(function () {
        $(".search_link").click(function () {
            var searchTerm = $(".search").val();
            var listItem = $('.results tbody').children('tr');
            var searchSplit = searchTerm.replace(/ /g, "'):containsi('");

            $.extend($.expr[':'], {'containsi': function (elem, i, match, array) {
                    return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
                }
            });

            $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function (e) {
                $(this).attr('visible', 'false');
            });

            $(".results tbody tr:containsi('" + searchSplit + "')").each(function (e) {
                $(this).attr('visible', 'true');
            });

            var jobCount = $('.results tbody tr[visible="true"]').length;
            $('.counter').text(jobCount + ' items');
                
            if (jobCount == '0') {
                $('.no-result').show();
                
            }
            else {
                $('.no-result').hide();
            }
        });
                                  
        var ctyval = "{$ctyval}";
        if(ctyval=="-1")
        {    
            $("#other_city").show();
        }     

        $("#RepCredentialProfiles_ID_VILLE").change(function(){
            var id=$(this).val();

            $("#other_city").hide();
            if(id=="-1")
            {    
                $("#other_city").show();
            }    
        }); 
    });
EOD;
Yii::app()->clientScript->registerScript('_editprofile', $js);
?>