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
                $category_names = CHtml::listData(ClientCategory::model()->findAll(array("order"=>"cat_name asc","condition"=>"cat_type_id=".$model->cat_type_id)), 'category', 'cat_name');
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
                        <?php echo $form->textField($model, 'site_address', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'site_address'); ?>
                    </div>
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
</div><!-- ./col -->
</div>
<?php
$ajaxCatUrl = Yii::app()->createUrl('/admin/clientProfiles/getcategories');
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
});
EOD;
Yii::app()->clientScript->registerScript('_form_prof', $js);
?>