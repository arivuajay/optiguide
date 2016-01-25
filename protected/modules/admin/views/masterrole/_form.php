<?php
/* @var $this MasterroleController */
/* @var $model MasterRole */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'master-role-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Role_Code', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Role_Code', array('class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
                        <?php echo $form->error($model, 'Role_Code'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Description', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Description', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                        <?php echo $form->error($model, 'Description'); ?>
                    </div>
                </div>

                <?php
                if (isset(Yii::app()->user->id) && !$model->isNewRecord) {
                   // $user = User::model()->find('id = :U', array(':U' => Yii::app()->user->id));
                    //$show_rank = $user->roleMdl->Rank <= $model->Rank;
                }
                ?>

                <?php if($show_rank){ ?>
<!--                <div class="form-group">
                    <?php //echo $form->labelEx($model, 'Rank', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php //echo $form->textField($model, 'Rank', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                        <?php //echo $form->error($model, 'Rank'); ?>
                    </div>
                </div>-->
                <?php } ?>

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