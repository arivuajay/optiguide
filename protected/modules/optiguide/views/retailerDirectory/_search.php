<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-users"></i>  <?php echo Myclass::t('OG047', '', 'og') ?> </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optiguide/retailerDirectory/index'),
        'htmlOptions' => array('role' => 'form')
    ));
    
    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions($searchModel->country);
    $cities  = Myclass::getallcities($searchModel->region);
    $categories  = array("1"=>Myclass::t('OG105'),"2"=>Myclass::t('OG106'),"3"=>Myclass::t('OG107'),"4"=>Myclass::t('OG108'),"5"=>Myclass::t('OG109'))
    ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'COMPAGNIE', array('class' => 'txtfield','placeholder'=>Myclass::t('APP2'))); ?>
    </div>
    
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'searchcat', $categories, array('class' => 'selectpicker', 'empty' => Myclass::t('OG048', '', 'og'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'country', $country, array('class' => 'selectpicker', 'empty' => Myclass::t('OG021', '', 'og'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'region', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('OG021', '', 'og'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('OG021', '', 'og'))); ?> 
    </div>
   
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'CODE_POSTAL', array('class' => 'txtfield','placeholder'=>Myclass::t('APP71'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OG024', '', 'og'), array('class' => 'find-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optiguide/calenderEvent/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optiguide/calenderEvent/getcities');
$js = <<< EOD
    $(document).ready(function(){
    $("#ProfessionalDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_region").html(html).selectpicker('refresh');
            }
         });
    });
   
   $("#ProfessionalDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_ID_VILLE").html(html).selectpicker('refresh');
            }
         });

    });
});
EOD;
Yii::app()->clientScript->registerScript('index', $js);
?>