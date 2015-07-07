<?php
$this->title = 'My Profile';
$this->breadcrumbs = array(
    $this->title
);
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <!-- small box -->
        <div class="box box-primary">
            <?php $form = $this->beginWidget('CActiveForm', array('id' => 'profile-form', 'htmlOptions' => array('role' => 'form'))); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'username') ?>
                    <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'username') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'name') ?>
                    <?php echo $form->textField($model, 'name', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'name') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'new_password') ?>
                    <?php echo $form->passwordField($model, 'new_password', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'new_password') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'confirm_password') ?>
                    <?php echo $form->passwordField($model, 'confirm_password', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'confirm_password') ?>
                </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
                <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')) ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<?php
$script = <<< JS
    $(document).ready(function(){
        $(':password').val('');
    });
JS;

Yii::app()->getClientScript()->registerScript($script, CClientScript::POS_END);
?>
