<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR735', '', 'or'); ?> </h2>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'change-password-form',
        'enableClientValidation' => true,
    ));

    echo $form->errorSummary(array($model));
    ?>

    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($model, 'old_password'); ?>
            <?php echo $form->passwordField($model, 'old_password', array('class' => "form-field")); ?>
            <?php // echo $form->error($model, 'old_password'); ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($model, 'new_password'); ?>
            <?php echo $form->passwordField($model, 'new_password', array('class' => "form-field")); ?>
            <?php // echo $form->error($model, 'new_password'); ?> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($model, 'confirm_password'); ?>
            <?php echo $form->passwordField($model, 'confirm_password', array('class' => "form-field")); ?>
            <?php // echo $form->error($model, 'confirm_password'); ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), Myclass::t('OR735', '', 'or'));
            ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>
