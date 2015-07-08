<?php
$this->title = 'Forgot Password';
$this->breadcrumbs[] = $this->title;
?>

<div class="form-box" id="login-box">
    <div class="header"><?php echo CHtml::encode($this->title) ?></div>
    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form')); ?>
    <div class="body bg-gray">
        <?php if (isset($this->flashMessages)): ?>
            <?php foreach ($this->flashMessages as $key => $message) { ?>
                <div class="alert alert-<?php echo $key; ?> fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $message; ?>
                </div>
            <?php } ?>
        <?php endif ?>  
        <div class="form-group">
            <?php echo $form->labelEx($model, 'email') ?>
            <?php echo $form->textField($model, 'email', array('autofocus', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'email') ?>
        </div>
    </div>
    <div class="footer">
        <?php echo CHtml::submitButton('Send', array('class' => 'btn bg-olive btn-block', 'name' => 'forget_password')) ?>   
    </div>
    <?php $this->endWidget(); ?>
</div>






