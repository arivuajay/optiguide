<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
//$actn_url = Yii::app()->createUrl('/admin/suppliersDirectory/addproducts/');
$lstr = Yii::app()->session['language'];
$sectiontypes = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_".$lstr)), 'ID_SECTION', 'NOM_SECTION_'.$lstr);
//$archivecats = CHtml::listData(ArchiveCategory::model()->findAll(array("order" => 'NOM_CATEGORIE_FR')), 'ID_CATEGORIE', 'NOM_CATEGORIE_FR');
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont">  
                <a href="<?php echo Yii::app()->createUrl('/optiguide/suppliersDirectory/create/'); ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 1 </h4> <span> <?php echo Myclass::t('OG112'); ?>  </span> </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont">  
                <a href="<?php echo Yii::app()->createUrl('/optiguide/suppliersDirectory/addproducts/'); ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 2 </h4> <span> <?php echo Myclass::t('OG059', '', 'og'); ?></span> </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont ">  
                <a href="<?php echo Yii::app()->createUrl('/optiguide/suppliersDirectory/addmarques/'); ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 3 </h4> <span> <?php echo Myclass::t('OG135'); ?></span> </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont active-stpe">  
                <a href="<?php echo Yii::app()->createUrl('/optiguide/suppliersDirectory/payment/'); ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 4 </h4> <span> <?php echo Myclass::t('OG136'); ?> </span> </a>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
                'htmlOptions' => array('role' => 'form'),
            ));
            ?>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OGO88', '', 'og');?></div>
                <div class="row"> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'paymenttype', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($model, 'paymenttype', array('1'=>'Paypal','2'=>'Stripe'), array('class' => 'selectpicker', "empty" => Myclass::t('OGO83', '', 'og'))); ?>                          
                            <?php echo $form->error($model, 'paymenttype'); ?>
                        </div>
                    </div>                     

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO80', '', 'og'));
                        ?>
                    </div>                    

                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div> 
</div>   
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($themeUrl . '/js/pair-select.min.js', $cs_pos_end);
$jsoncde = array();

if (Yii::app()->user->hasState("product_ids")) {
    $sess_product_ids = Yii::app()->user->getState("product_ids");
    $jsoncde = json_encode($sess_product_ids);
}

$ajaxproducts = Yii::app()->createUrl('/optiguide/suppliersDirectory/getproducts');
$js = <<< EOD
$(document).ready(function(){
   
// Display the products in multiselect box based on slected category     
   var varray = {$jsoncde}; 
    
    $("#SuppliersDirectory_IDSECTION").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
    
        $.ajax({
            type: "POST",
            url: '{$ajaxproducts}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#MasterSelectBox").html(html);
                $('#MasterSelectBox').pairMaster();
              
                if(varray.length>0)
                {
                    for (var i = 0; i < varray.length; i++) {
                        var mval = varray[i];                      
                        $("#MasterSelectBox option[value="+mval+"]").remove();
                     }
                }
            
               // Hide the selected values from MasterSelectBox box
                $("#SuppliersDirectory_Products2 option").map(function () {
                     var sval = this.value;
                    $("#MasterSelectBox option[value="+sval+"]").remove();
                });
            }
         });
    }); 
 
// Add the products from multislect box            
    $('#Addmarque').click(function(){
            $('#MasterSelectBox').addSelected('#SuppliersDirectory_Products2');
    });

// Remove the products from multislect box   
    $('#Removemarque').click(function(){
            $('#SuppliersDirectory_Products2').removeSelected('#MasterSelectBox'); 
    });           
            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>
