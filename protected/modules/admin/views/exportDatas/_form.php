<?php
/* @var $this ExportDatasController */
/* @var $model ExportDatas */
/* @var $form CActiveForm */

$this->title='Export professional user datas';
$this->breadcrumbs=array(
	'Export professional datas'=>array('index'),
	$this->title,
);

$criteria2 = new CDbCriteria();
$criteria2->select = array('CONCAT(countryDirectory.NOM_PAYS_EN , " - " , NOM_REGION_EN) AS fullname');
$criteria2->with   = 'countryDirectory';
$criteria2->order  = "countryDirectory.NOM_PAYS_EN ASC,NOM_REGION_EN ASC";
$province_datas    = CHtml::listData(RegionDirectory::model()->findAll($criteria2), 'ID_REGION', 'fullname');

$criteria3 = new CDbCriteria();
$criteria3->order  = "TYPE_SPECIALISTE_EN ASC";
$professionaltype_datas = CHtml::listData(ProfessionalType::model()->findAll($criteria3) , 'ID_TYPE_SPECIALISTE' , 'TYPE_SPECIALISTE_EN');
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
                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'province', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php
                            $htmlOptions = array('size' => '10', 'multiple' => 'true', 'class' => 'form-control');
                            echo $form->listBox($model, 'province', $province_datas, $htmlOptions);
                            ?> 
                        </div>  
                    </div>  
                    
                     <div class="box-header">
                        <h3 class="page-header">Step 3</h3>
                    </div>
                    
                     <div class="form-group">
                        <?php echo $form->labelEx($model, 'professional_type', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php
                            $htmlOptions = array('size' => '8', 'multiple' => 'true', 'class' => 'form-control');
                            echo $form->listBox($model, 'professional_type', $professionaltype_datas, $htmlOptions);
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
                              $model->export_type = 0;
                              echo $form->radioButtonList($model, 'export_type',
                                        array(  0 => 'Single File',
                                                1 => 'By Province',
                                                2 => 'By Type' ),

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
                            <?php echo CHtml::submitButton('Export', array('class' => 'btn btn-success')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div><!-- ./col -->
    </div>
</div>    