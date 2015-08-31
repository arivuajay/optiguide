<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl   = $this->themeUrl;
$rdatas    = array();

foreach ($results as $userinfo)
{
    $rid = $userinfo['ID_RETAILER'];
    $dispname = $userinfo['COMPAGNIE'].",".$userinfo['NOM_VILLE'].",".$userinfo['ABREVIATION_'.$this->lang].",".$userinfo['NOM_PAYS_'.$this->lang];              
    $rdatas[$rid]= $dispname;  
}

?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO145', '', 'og'); ?> </h2>


            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'professional-directory-form',
                'htmlOptions' => array('role' => 'form'),
                 'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            //$retailertypes = CHtml::listData(RetailerType::model()->findAll(), 'ID_RETAILER_TYPE', 'NOM_TYPE_FR');
           // $groupetypes = array();

            // $country = Myclass::getallcountries();
            // $regions = array();
            // $cities  = array();
            ?>
            <div class="forms-cont">                
                <div class="row"> 

<!--                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php //echo $form->labelEx($model, 'ID_RETAILER_TYPE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                 
                            <?php //echo $form->dropDownList($model, 'ID_RETAILER_TYPE', $retailertypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG118'))); ?>    
                        </div>
                    </div>-->

<!--                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php //echo $form->labelEx($model, 'ID_GROUPE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                 
                            <?php //echo $form->dropDownList($model, 'ID_GROUPE', $groupetypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG119'))); ?>  
                        </div>
                    </div>-->
                    
                     <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo Myclass::t('OGO147', '', 'og'); ?> 
                            <?php                           
                            $data = array();
                            $htmlOptions = array('size' => '8', 'multiple' => 'true', 'id' => 'MasterSelectBox', 'class' => 'form-control');
                            echo $form->listBox($model, 'Retailers1', $rdatas, $htmlOptions);
                            ?>  
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                           
                            <div class="col-sm-5">
                                <a href='javascript:void(0);' class="btn btn-info btn-sm" id="Addretailer"><?php echo Myclass::t('OGO86', '', 'og'); ?></a>
                            </div>
                            <div class="col-sm-5">
                                <a href='javascript:void(0);' class="btn btn-danger btn-sm" id="Removeretailer"><?php echo Myclass::t('OGO87', '', 'og'); ?></a>          
                            </div>
                        </div>  
                    </div>    

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo Myclass::t('OGO148', '', 'og'); ?> 
                            <?php
                            // $data = $get_selected_marques;
                            $htmlOptions = array('size' => '8', 'multiple' => 'true', 'class' => 'form-control', 'options' => $selected);
                            echo $form->listBox($model, 'Retailers2', $data, $htmlOptions);
                            ?>
                           <?php echo $form->error($model, 'Retailers2'); ?>
                        </div>
                        
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OG120'));
                        ?>
                    </div>   
                    
                    <?php $this->endWidget(); ?>
                </div>
            </div>                    
        </div>
    </div> 
</div>   
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($themeUrl . '/js/pair-select.min.js', $cs_pos_end);
//$ajaxRegionUrl = Yii::app()->createUrl('/optiguide/professionalDirectory/getregions');
//$ajaxCityUrl = Yii::app()->createUrl('/optiguide/professionalDirectory/getcities');
//$ajaxGroupUrl = Yii::app()->createUrl('/optiguide/professionalDirectory/getgroups');
//$ajaxretailers = Yii::app()->createUrl('/optiguide/professionalDirectory/getretailers');
$js = <<< EOD
    $(document).ready(function(){
        
         $('#MasterSelectBox').pairMaster();
        
//    $("#RetailerDirectory_ID_RETAILER_TYPE").change(function(){
//        var id=$(this).val();
//        var dataString = 'typeid='+ id;
//   
//        $.ajax({
//            type: "POST",
//            url: '{$ajaxretailers}',
//            data: dataString,
//            cache: false,
//            success: function(html){             
//                $("#MasterSelectBox").html(html);
//                $('#MasterSelectBox').pairMaster();
//                         
//               // Hide the selected values from MasterSelectBox box
//                $("#RetailerDirectory_Retailer2 option").map(function () {
//                     var sval = this.value;
//                    $("#MasterSelectBox option[value="+sval+"]").remove();
//                });
//            }
//         });
//    }); 


 
// Add the retailers from multislect box            
    $('#Addretailer').click(function(){
            $('#MasterSelectBox').addSelected('#RetailerDirectory_Retailers2');
    });

// Remove the retailers from multislect box   
    $('#Removeretailer').click(function(){
            $('#RetailerDirectory_Retailers2').removeSelected('#MasterSelectBox'); 
    });       
        
        
//    $("#RetailerDirectory_country").change(function(){
//        var id=$(this).val();
//        var dataString = 'id='+ id;
//            
//        $.ajax({
//            type: "POST",
//            url: '{$ajaxRegionUrl}',
//            data: dataString,
//            cache: false,
//            success: function(html){             
//                $("#RetailerDirectory_region").html(html).selectpicker('refresh');
//            }
//         });
//    });
//   
//   $("#RetailerDirectory_region").change(function(){
//        var id=$(this).val();
//        var dataString = 'id='+ id;
//            
//        $.ajax({
//            type: "POST",
//            url: '{$ajaxCityUrl}',
//            data: dataString,
//            cache: false,
//            success: function(html){             
//                $("#RetailerDirectory_ID_VILLE").html(html).selectpicker('refresh');
//            }
//         });
//
//    });
            
//   $("#RetailerDirectory_ID_RETAILER_TYPE").change(function(){
//        var id=$(this).val();
//        var dataString = 'id='+ id;
//            
//        $.ajax({
//            type: "POST",
//            url: '{$ajaxGroupUrl}',
//            data: dataString,
//            cache: false,
//            success: function(html){             
//                $("#RetailerDirectory_ID_GROUPE").html(html).selectpicker('refresh');
//            }
//         });
//    });         
            
});
EOD;
Yii::app()->clientScript->registerScript('_form_mappingretailer', $js);
?>