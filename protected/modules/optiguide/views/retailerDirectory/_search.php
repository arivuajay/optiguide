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
    $cities  = Myclass::getallcities_other($searchModel->region);
    $categories  = array("1"=>Myclass::t('OG105'),"2"=>Myclass::t('OG106'),"3"=>Myclass::t('OG107'),"4"=>Myclass::t('OG108'),"5"=>Myclass::t('OG109'));
    
    $retailertypes = CHtml::listData(RetailerType::model()->findAll(), 'ID_RETAILER_TYPE', 'NOM_TYPE_FR');
    $groupetypes = array();
    if ($searchModel->ID_RETAILER_TYPE) {
        $groupetypes = CHtml::listData(RetailerGroup::model()->findAll("ID_RETAILER_TYPE=" . $searchModel->ID_RETAILER_TYPE), 'ID_GROUPE', 'NOM_GROUPE');
    }
    ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'COMPAGNIE', array('class' => 'txtfield','placeholder'=>Myclass::t('APP2'))); ?>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 ">                      
     <?php echo $form->dropDownList($searchModel, 'ID_RETAILER_TYPE', $retailertypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG118'))); ?>                          
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 ">                      
        <?php echo $form->dropDownList($searchModel, 'ID_GROUPE', $groupetypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG119'))); ?>                          
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
$ajaxGroupUrl = Yii::app()->createUrl('/optiguide/retailerDirectory/getgroups');

$js = <<< EOD
    $(document).ready(function(){
    $("#RetailerDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_region").html(html).selectpicker('refresh');
            }
         });
    });
   
   $("#RetailerDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_ID_VILLE").html(html).selectpicker('refresh');
            }
         });

    });
            
    $("#RetailerDirectory_ID_RETAILER_TYPE").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxGroupUrl}',
            data: dataString+'&client_dis=1',
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_ID_GROUPE").html(html).selectpicker('refresh');
            }
         });
    });                 
});
EOD;
Yii::app()->clientScript->registerScript('index', $js);
?>