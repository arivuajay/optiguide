<?php
/* @var $this AuthresourcesController */
/* @var $model AuthResources */
/* @var $form CActiveForm */
/**/
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'auth-resources-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_User_ID', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_User_ID', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'Master_User_ID'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Role_ID', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_Role_ID', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'Master_Role_ID'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Module_ID', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_Module_ID', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'Master_Module_ID'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Screen_ID', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_Screen_ID', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'Master_Screen_ID'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Task_ADD', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_Task_ADD', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
                        <?php echo $form->error($model, 'Master_Task_ADD'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Task_SEE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_Task_SEE', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
                        <?php echo $form->error($model, 'Master_Task_SEE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Task_UPT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_Task_UPT', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
                        <?php echo $form->error($model, 'Master_Task_UPT'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Master_Task_DEL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Master_Task_DEL', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
                        <?php echo $form->error($model, 'Master_Task_DEL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Active', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->checkBox($model, 'Active', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'Active'); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>