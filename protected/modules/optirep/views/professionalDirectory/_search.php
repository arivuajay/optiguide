<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-users"></i>  <?php echo Myclass::t('OG039', '', 'og') ?> </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optirep/professionalDirectory/index'),
        'htmlOptions' => array('role' => 'form')
    ));

    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions($searchModel->country);
    $cities = Myclass::getallcities($searchModel->region);
    $professional_types = CHtml::listData(ProfessionalType::model()->findAll(), 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_' . $this->lang . '');
    ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'NOM', array('class' => 'txtfield', 'placeholder' => Myclass::t('OG049', '', 'og'))); ?>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_TYPE_SPECIALISTE', $professional_types, array('class' => 'selectpicker', 'empty' => Myclass::t('OG201'))); ?>   
    </div>    

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'CODE_POSTAL', array('class' => 'txtfield', 'placeholder' => Myclass::t('APP71'))); ?>  
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'country', $country, array('class' => 'selectpicker', 'empty' => Myclass::t('OG202'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'region', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('OG203'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('OG204'))); ?> 
    </div>


    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OG024', '', 'og'), array('class' => 'find-btn')); ?>
    </div>
    <?php echo CHtml::hiddenField('listperpage', $searchModel->listperpage, array('id' => 'listperpage')); ?>   
    <?php $this->endWidget(); ?>
</div>

<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optirep/calenderEvent/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optirep/calenderEvent/getcities');
$js = <<< EOD
    $(document).ready(function(){
    $("#ProfessionalDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id +'&search=yes';
            
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
        var dataString = 'id='+ id +'&search=yes';
            
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