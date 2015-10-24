<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $category_names = array();
            $cat_types = CHtml::listData(ClientCategoryTypes::model()->findAll(array("order"=>"cat_type asc")), 'cat_type_id', 'cat_type');
            if($model->cat_type_id){
                $category_names = CHtml::listData(ClientCategory::model()->findAll(array("order"=>"category asc","condition"=>"cat_type_id=".$model->cat_type_id)), 'category', 'cat_name');
            }
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'client-profiles-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'company', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'company', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'company'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'job_title', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'job_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'job_title'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'member_type', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                         <?php echo $form->dropDownList($model, 'member_type', array("free_member"=>'Free member','advertiser'=>'Advertiser'), array('class' => 'form-control')); ?> 
                        
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'cat_type_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'cat_type_id', $cat_types, array('class' => 'form-control',"empty"=>"Select category type")); ?> 
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'category', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'category', $category_names, array('class' => 'form-control',"empty"=>"Select category")); ?> 
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'address', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'address'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'local_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'local_number', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'local_number'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'country', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'country'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'region', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'region', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'region'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ville', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ville', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'ville'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phonenumber1', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'phonenumber1', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'phonenumber1'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phonenumber2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'phonenumber2', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'phonenumber2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'mobile_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'mobile_number', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'mobile_number'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'tollfree_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'tollfree_number', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'tollfree_number'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'fax', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'fax', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'fax'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'site_address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'site_address', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>(http://www.monsite.com )
                        <?php echo $form->error($model, 'site_address'); ?>
                    </div>
                </div>
                <div class="box-header">
                    <h3 class="box-title">Subscription</h3>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'subscription', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                          <?php echo $form->checkBox($model, 'Optipromo', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($model, 'Optipromo'); ?>
                            <br/> 
                            <?php echo $form->checkBox($model, 'Optinews', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($model, 'Optinews'); ?>
                            <br/> 
                            <?php echo $form->checkBox($model, 'Envision_print', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($model, 'Envision_print'); ?>
                            <br/>                                   
                            <?php echo $form->checkBox($model, 'Envision_digital', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($model, 'Envision_digital'); ?>
                            <br/> 
                            <?php echo $form->checkBox($model, 'Envue_print', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($model, 'Envue_print'); ?>
                            <br/> 
                            <?php echo $form->checkBox($model, 'Envue_digital', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($model, 'Envue_digital'); ?>
                    </div>         
                    </div>
                 <div class="box-header">
                    <h3 class="box-title">Réglez l'alerte à l'employé</h3>
                </div>
                <?php
                $themeUrl = $this->themeUrl;
                $cs = Yii::app()->getClientScript();
                $cs_pos_end = CClientScript::POS_END;

                $cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
                $cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
                
                $cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
                $cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);

                if(!$cmodel->status){ $cmodel->status=0;}                
                $employees = CHtml::listData(EmployeeProfiles::model()->findall(array("order"=>"employee_name asc")), 'employee_id', 'employee_name');           
                ?>
              

                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'employee_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($cmodel, 'employee_id', $employees, array('class' => 'form-control')); ?> 
                        <?php echo $form->error($cmodel, 'employee_id'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'date_remember', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($cmodel, 'date_remember', array('class' => 'form-control date')); ?>
                        <?php echo $form->error($cmodel, 'date_remember'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'message', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($cmodel, 'message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($cmodel, 'message'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($cmodel, 'status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($cmodel, 'status'); ?>
                    </div>
                </div>
                <?php
                if(!$model->isNewRecord)
                {?>    
                <div class="box-header">
                    <h3 class="box-title">L'historique des alertes</h3>
                </div>                
                 <div class="row">
                      <?php
                            $gridColumns = array(  
                                array('header' => 'SN.',
                                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                ), 
                                array(
                               'name'    => 'employeeProfiles.employee_name',
                               'value'   => $data->employeeProfiles->employee_name,
                                ), 		
                                array('name' => 'date_remember',
                                   'type' => 'raw',
                                   'value' => function($data){
                                       echo date("d-m-Y",strtotime($data->date_remember));
                                   },
                                   'filter' => false,
                                ),
                                array('name' => 'status',
                                   'type' => 'raw',
                                   'value' => function($data){
                                       echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                                   },
                                   'filter' => false,
                                ),      
                                array('header' => 'message',
                                    'type' => 'raw',
                                    'filter' => false,
                                      //call the method 'gridDataColumn' from the controller
                                    'value' => array($this, 'gridDataColumn'),
                                ),              
                                array(
                                'header' => 'Actes',
                                'class' => 'booster.widgets.TbButtonColumn',
                                'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                                'template' => '{delete}',
                                'buttons'=>array
                                    (
                                        'delete' => array
                                        (
                                            'label'=>'Delete',                                            
                                            'url'=>'Yii::app()->createUrl("admin/clientMessages/delete", array("id"=>$data->message_id))',
                                        ),                                   
                                    ),
                                )
                            );

                            $this->widget('booster.widgets.TbExtendedGridView', array(
                            'type' => 'striped bordered datatable',
                            'enableSorting' => false,
                            'dataProvider' => $csearchmodel,
                            'responsiveTable' => true,
                            'template' => '  <div class="col-md-7"><div class="box"> <div class="box-body">{items}</div> <div class="box-footer clearfix">{pager}</div> </div></div>',
                            'columns' => $gridColumns
                            )
                            );
                            ?>
                 </div>
                <?php 
                }?>
                
                </div>   
            </div>

        </div><!-- /.box-body -->
        
        
        <div class="box-footer">
            <div class="form-group">
                <div class="col-sm-0 col-sm-offset-2">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'créer' : 'modifier', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
<div class="modal fade" id="products-disp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i> Message</h4>
                <div id="product_contents"></div>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
$ajaxCatUrl = Yii::app()->createUrl('/admin/clientProfiles/getcategories');
$ajax_getmessage  = Yii::app()->createUrl('/admin/clientProfiles/getmessage');
$js = <<< EOD

   $(document).ready(function(){
        
    $("#ClientProfiles_cat_type_id").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCatUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ClientProfiles_category").html(html);
            }
         });
    });
            
   $('.year').datepicker({ dateFormat: 'yyyy' });
   $('.date').datepicker({ format: 'dd-mm-yyyy', startDate: '+0d',});   
            
   $('.popupmessage').live('click',function(event){
        event.preventDefault();
        var message_id = $(this).attr("id");      
        var dataString = 'id='+message_id;
            
        $.ajax({
            type: "POST",
            url: '{$ajax_getmessage}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#product_contents").html(html);               
            }
         });
       
    });
  
});
EOD;
Yii::app()->clientScript->registerScript('_form_prof', $js);
?>