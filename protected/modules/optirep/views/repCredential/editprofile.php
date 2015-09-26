<div class="cate-bg user-right profile-pages">
    <h2> Edit profile </h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rep-credential-form',
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    echo $form->errorSummary(array($model, $profile));

    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions($profile->country);
    $cities = Myclass::getallcities($profile->region);
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
EOD;
Yii::app()->clientScript->registerScript('_editprofile', $js);
?>

