<div class="cate-bg user-right profile-pages">
    <h2> Edit profile </h2>
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
            <?php echo $form->labelEx($profile, 'rep_company'); ?>
            <?php echo $form->textField($profile, 'rep_company', array('class' => 'form-field')); ?>  
        </div>

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <?php echo $form->labelEx($profile, 'rep_territories'); ?>
            <?php echo $form->textField($profile, 'rep_territories', array('class' => 'form-field')); ?>  
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $form->labelEx($profile, 'image'); ?>
            <?php echo $form->fileField($profile, 'image'); ?> 
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <?php echo $form->labelEx($profile, 'rep_brands'); ?>
                    <input type="text" class="search form-field" placeholder="Search brands">
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 brand_search">
                    <a href="javascript:void(0)" class="search_link btn btn-primary">Search</a>
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
                                <td><i class="fa fa-warning"></i> No result</td>
                            </tr>
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

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), 'Update');
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optirep/repCredential/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optirep/repCredential/getcities');

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
            $('.counter').text(jobCount + ' item');
                
            if (jobCount == '0') {
                $('.no-result').show();
            }
            else {
                $('.no-result').hide();
            }
        });
    });
EOD;
Yii::app()->clientScript->registerScript('_editprofile', $js);
?>