<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-users"></i> <?php echo Myclass::t('OG074', '', 'og'); ?>  </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optirep/groupInformation/index'),
        'htmlOptions' => array('role' => 'form')
    ));

    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions($searchModel->country);
    $categories = CategoryInformation::model()->findAll();
    $category_list = CHtml::listData($categories, 'ID_CATEGORIE', 'CATEGORIE_'.$this->lang)
    ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'NOM_GROUPE', array('class' => 'txtfield', 'placeholder' => Myclass::t('OG027', '', 'og'))); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'category', $category_list, array('class' => 'selectpicker', 'empty' => Myclass::t('OG208'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'country', $country, array('class' => 'selectpicker', 'empty' => Myclass::t('OG202'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'region', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('OG203'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OG024', '', 'og'), array('class' => 'find-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optirep/groupInformation/getregions');
$js = <<< EOD
    $(document).ready(function(){
    $("#GroupInformation_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#GroupInformation_region").html(html).selectpicker('refresh');
            }
         });
    });
});
EOD;
Yii::app()->clientScript->registerScript('_search', $js);
?>