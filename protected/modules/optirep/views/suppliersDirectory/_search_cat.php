<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-users"></i>  <?php echo Myclass::t('OR077', '', 'or') ?> </div>
    </div>
    <?php
     $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optirep/suppliersDirectory/category'),
        'htmlOptions' => array('role' => 'form')
    ));
    $prod_services = array();  
    $lang =  $this->lang;  
    $sectiontypes  = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_".$lang)), 'ID_SECTION', 'NOM_SECTION_'.$lang); 
    if($searchModel->ID_SECTION!='')
    {    
        $prod_services = CHtml::listData(ProductDirectory::model()->findAll(array("order" => "NOM_PRODUIT_".$lang , "condition" => "ID_SECTION = ".$searchModel->ID_SECTION)) , 'ID_PRODUIT', 'NOM_PRODUIT_'.$lang);
    }    
    ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_SECTION', $sectiontypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OR065', '', 'or'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'PROD_SERVICE', $prod_services, array('class' => 'selectpicker', 'empty' => Myclass::t('OR066', '', 'or'))); ?> 
    </div>
   

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OR024', '', 'or'), array('class' => 'find-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
$ajaxproductsUrl = Yii::app()->createUrl('/optirep/suppliersDirectory/getproducts');
$js = <<< EOD
    $(document).ready(function(){    
        $("#SuppliersDirectory_ID_SECTION").change(function(){
        
            var id=$(this).val();
            var dataString = 'id='+ id;

            $.ajax({
            type: "POST",
            url: '{$ajaxproductsUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#SuppliersDirectory_PROD_SERVICE").html(html).selectpicker('refresh');
            }
        });
    });  
});
EOD;
Yii::app()->clientScript->registerScript('index', $js);
?>