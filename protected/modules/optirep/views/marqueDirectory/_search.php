<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-search"></i>  <?php echo Myclass::t('OGO78', '', 'og') ?> </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optirep/marqueDirectory/index'),
        'htmlOptions' => array('role' => 'form')
    ));
    $prod_services = array();
    $lang = $this->lang;
    $sectiontypes = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_" . $lang)), 'ID_SECTION', 'NOM_SECTION_' . $lang);
    if ($searchModel->ID_SECTION != '') {
        $prod_services = CHtml::listData(ProductDirectory::model()->findAll(array("order" => "NOM_PRODUIT_" . $lang, "condition" => "ID_SECTION = " . $searchModel->ID_SECTION)), 'ID_PRODUIT', 'NOM_PRODUIT_' . $lang);
    }
    ?>  

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 "> 
        <?php echo $form->textField($searchModel, 'NOM_MARQUE', array('class' => 'txtfield', 'placeholder' => Myclass::t('APP2'))); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_SECTION', $sectiontypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG065', '', 'og'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
        <?php echo $form->dropDownList($searchModel, 'PROD_SERVICE', $prod_services, array('class' => 'selectpicker', 'empty' => Myclass::t('OG066', '', 'og'))); ?> 
    </div>


    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OG024', '', 'og'), array('class' => 'find-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
$ajaxproductsUrl = Yii::app()->createUrl('/optirep/suppliersDirectory/getproducts');
$js = <<< EOD
    $(document).ready(function(){    
        $("#MarqueDirectory_ID_SECTION").change(function(){
        
            var id=$(this).val();
            var dataString = 'id='+ id;

            $.ajax({
            type: "POST",
            url: '{$ajaxproductsUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#MarqueDirectory_PROD_SERVICE").html(html).selectpicker('refresh');
            }
        });
    });  
});
EOD;
Yii::app()->clientScript->registerScript('index', $js);
?>