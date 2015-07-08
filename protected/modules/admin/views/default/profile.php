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
                    <?php echo $form->labelEx($model, 'admin_username') ?>
                    <?php echo $form->textField($model, 'admin_username', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'admin_username') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'admin_name') ?>
                    <?php echo $form->textField($model, 'admin_name', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'admin_name') ?>
                </div>
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'admin_email') ?>
                    <?php echo $form->textField($model, 'admin_email', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'admin_email') ?>
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
