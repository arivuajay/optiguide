<?php
/* @var $this ExportDatasController */
/* @var $model ExportDatas */
/* @var $form CActiveForm */

$this->title='Export supplier user datas';
$this->breadcrumbs=array(
	'Export supplier datas'=>array('index'),
	$this->title,
);
//
//$criteria2 = new CDbCriteria();
//$criteria2->select = array('CONCAT(countryDirectory.NOM_PAYS_EN , " - " , NOM_REGION_EN) AS fullname');
//$criteria2->with   = 'countryDirectory';
//$criteria2->order  = "countryDirectory.NOM_PAYS_EN ASC,NOM_REGION_EN ASC";
//$province_datas    = CHtml::listData(RegionDirectory::model()->findAll($criteria2), 'ID_REGION', 'fullname');


$country = Myclass::getallcountries();
$regions = Myclass::getallregions($model->country);

$criteria3 = new CDbCriteria();
$criteria3->order  = "TYPE_FOURNISSEUR_EN ASC";
$suppliertype_datas = CHtml::listData(SupplierType::model()->findAll($criteria3) , 'ID_TYPE_FOURNISSEUR' , 'TYPE_FOURNISSEUR_EN');
?>
<div class="user-create">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="box box-primary">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'export-datas-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'enableAjaxValidation' => true,
                ));
                ?>
                <div class="box-body">
                    <div class="box-header">
                        <h3 class="page-header">Step 1</h3>
                    </div>
                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'language', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                     
                            <div class="checkbox">
                                <label>
                                    <?php echo $form->checkBox($model, 'EN', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'EN'); ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <?php echo $form->checkBox($model, 'FR', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'FR'); ?>
                                </label>
                            </div>                       
                        </div>
                    </div>
                    
                    <div class="form-group">
                    <?php echo $form->labelEx($model, 'subscriptions', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            
                             <div class="checkbox">
                                 <label>
                                    <?php echo $form->checkBox($model, 'Optipromo', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'Optipromo'); ?>
                                 </label>
                             </div>
                             
                            <div class="checkbox">
                                <label>
                                    <?php echo $form->checkBox($model, 'Optinews', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'Optinews'); ?>
                                </label>
                            </div>
                            
                            <div class="checkbox">
                                 <label>
                                    <?php echo $form->checkBox($model, 'Envision_print', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'Envision_print'); ?>
                                </label>
                            </div>   
                            
                            <div class="checkbox">
                                <label>
                                    <?php echo $form->checkBox($model, 'Envision_digital', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'Envision_digital'); ?>
                                </label>
                            </div>   
                            
                            <div class="checkbox">
                                <label>
                                    <?php echo $form->checkBox($model, 'Envue_print', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'Envue_print'); ?>
                                </label>
                            </div>  
                            
                            <div class="checkbox">
                                <label>
                                <?php echo $form->checkBox($model, 'Envue_digital', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'Envue_digital'); ?>
                                </label>
                            </div>  
                            
                        </div>   
                    </div>
                    
                    <div class="box-header">
                        <h3 class="page-header">Step 2</h3>
                    </div>
                    
<!--                <div class="form-group">
                        <?php //echo $form->labelEx($model, 'province', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php
                           // $htmlOptions = array('size' => '10', 'multiple' => 'true', 'class' => 'form-control');
                           // echo $form->listBox($model, 'province', $province_datas, $htmlOptions);
                           // echo $form->error($model, 'province'); 
                            ?> 
                        </div>  
                    </div>  -->

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'form-control', 'empty' => Myclass::t('APP43'))); ?>                          
                            <?php echo $form->error($model, 'country'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'region', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'region', $regions, array('class' => 'form-control', 'empty' => Myclass::t('APP44'))); ?>                          
                            <?php echo $form->error($model, 'region'); ?>
                        </div>
                    </div>
                    
                     <div class="box-header">
                        <h3 class="page-header">Step 3</h3>
                    </div>
                    
                     <div class="form-group">
                        <?php echo $form->labelEx($model, 'S_type', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php
                            $htmlOptions = array('size' => '4', 'multiple' => 'true', 'class' => 'form-control');
                            echo $form->listBox($model, 'ptype', $suppliertype_datas, $htmlOptions);
                            echo $form->error($model, 'ptype'); 
                            ?> 
                        </div>  
                    </div>
                    
                    <div class="box-header">
                        <h3 class="page-header">Step 4</h3>
                    </div>
                    
                     <div class="form-group">
                        <?php echo $form->labelEx($model, 'export_type', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php
                              $model->export_type = 1;
                              echo $form->radioButtonList($model, 'export_type',
                                        array(  1 => 'Single File',
                                              //  2 => 'By selected Province',
                                                3 => 'By selected supplier Type' 
                                             ),
                                        array(
                                                'labelOptions'=>array('style'=>'display:inline'), // add this code
                                                'separator'=>'<br><br>',
                                            ) 
                                      );
                           ?> 
                        </div>  
                    </div>
                    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-0 col-sm-offset-2">
                            <?php
                                echo CHtml::submitButton('Export', array('class' => 'btn btn-success'));
                                echo CHtml::hiddenField('utype' , 'supplier');  
                            ?>
                            <a href="javascript:void(0);" id="calculateusers" class="btn btn-primary">Calculate</a>
                            <p id="filtercounts" style="display: none;"><b>Filtered users count </b>: <span id="totalcounts">&nbsp;</span></p>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div><!-- ./col -->
    </div>
</div>    
  
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/admin/suppliersDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/suppliersDirectory/getcities');

$filteruser_url = Yii::app()->createUrl('/admin/exportDatas/calculate_usercounts');

$js = <<< EOD
    $(document).ready(function(){
        
    $("#ExportDatas_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ExportDatas_region").html(html);
            }
         });
    }); 
            
    $("#calculateusers").click(function(){
            
        $.ajax({
             type: "POST",
              url: '{$filteruser_url}',
             data: $('#export-datas-form').serialize(),
            cache: false,
            success: function(html){             
                $("#totalcounts").html(html);
                $("#filtercounts").show();
            }
         });
    });         
            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>