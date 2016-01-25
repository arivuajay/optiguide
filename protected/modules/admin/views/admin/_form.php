<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-form',
        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	'enableAjaxValidation'=>true,
)); ?>
            <div class="box-body">
                                    <div class="form-group">
                        <?php echo $form->labelEx($model,'admin_name',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'admin_name',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'admin_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'admin_username',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'admin_username',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'admin_username'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'org_password',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'org_password',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'org_password'); ?>
                        </div>
                    </div>

                   <div class="form-group">
                        <?php echo $form->labelEx($model,'admin_email',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'admin_email',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'admin_email'); ?>
                        </div>
                    </div>
                    
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'role',  array('class' => 'col-sm-2 control-label')); ?>
                    <?php $names = CHtml::listData(MasterRole::model()->findAll(array('condition'=>"Master_Role_ID!=1",'order' => 'Role_Code')), 'Master_Role_ID', 'Description'); ?>
                    <div class="col-sm-5">
                            <?php
                                    echo $form->dropDownList($model, 'role', $names, array(
                                        'prompt' => 'Choose Role',
                                        'class' => 'form-control',                       
                                    ));
                            ?>
                    <?php echo $form->error($model,'role'); ?>
                    </div>
                </div>
                
                 <?php 
                if (!$model->admin_status) {
                    $model->admin_status = 0;
                }
                ?>
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'admin_status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($model, 'admin_status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'admin_status'); ?>
                    </div>
                </div>
                

                                </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>