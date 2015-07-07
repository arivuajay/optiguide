<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading"><?php echo ($model->isNewRecord) ? "Add User" : "Update User"; ?></header>
            <div class="panel-body">
                <div class="position-center">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-form',
                        'enableAjaxValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'role' => 'form'),
                    ));
                    ?>
                    <?php echo $form->errorSummary(array($model)); ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'user_name', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo $form->textField($model, 'user_name', array('class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'user_email', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo $form->textField($model, 'user_email', array('class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </section>
    </div>
</div>
