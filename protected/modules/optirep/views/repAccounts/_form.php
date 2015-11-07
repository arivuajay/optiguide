<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'create-rep-account-form',
        ));

$country = Myclass::getallcountries();
$regions = Myclass::getallregions($profile->country);
$cities = Myclass::getallcities($profile->region);
?>
<div class="cate-bg user-right profile-pages">
    <?php if ($model->isNewRecord) { ?>
        <h2> <?php echo Myclass::t('OR527', '', 'or'); ?> </h2>
    <?php } else { ?>
        <h2> <?php echo Myclass::t('OR537', '', 'or'); ?> </h2>
    <?php } ?>
    <div class="row"> 
        <?php echo $form->errorSummary(array($model, $profile)); ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($model, 'rep_username'); ?>
            <?php echo $form->textField($model, 'rep_username', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($model, 'rep_password'); ?>
            <?php echo $form->passwordField($model, 'rep_password', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_firstname'); ?>
            <?php echo $form->textField($profile, 'rep_profile_firstname', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_lastname'); ?>
            <?php echo $form->textField($profile, 'rep_profile_lastname', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_email'); ?>
            <?php echo $form->textField($profile, 'rep_profile_email', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_phone'); ?>
            <?php echo $form->textField($profile, 'rep_profile_phone', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_address'); ?>
            <?php echo $form->textField($profile, 'rep_address', array('class' => 'form-field')); ?>  
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'country'); ?>
            <?php echo $form->dropDownList($profile, 'country', $country, array('class' => 'selectpicker', 'empty' => 'Select')); ?>  
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'region'); ?>
            <?php echo $form->dropDownList($profile, 'region', $regions, array('class' => 'selectpicker', 'empty' => 'Select')); ?>  
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'ID_VILLE'); ?>
            <?php echo $form->dropDownList($profile, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => 'Select')); ?>  
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="other_city" style="display:none;">
            <?php echo $form->labelEx($profile, 'autre_ville'); ?>
            <?php echo $form->textField($profile, 'autre_ville', array('class' => 'form-field')); ?>  
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $button = Myclass::t('APP505');
            if ($model->isNewRecord) {
                $button = Myclass::t('APP504');
            }
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), $button);
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optirep/repCredential/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optirep/repCredential/getcities');

$ctyval = isset($profile->ID_VILLE) ? $profile->ID_VILLE : '';

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
Yii::app()->clientScript->registerScript('_step2', $js);
?>