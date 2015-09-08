<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'create-rep-account-form',
        ));
?>
<div class="cate-bg user-right">
    <?php if($model->isNewRecord){ ?>
        <h2> Create New Rep Account </h2>
    <?php } else { ?>
        <h2> Edit Rep Account </h2>
    <?php } ?>
    <div class="row"> 
        <?php echo $form->errorSummary(array($model, $profile)); ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($model, 'rep_username'); ?>
            <?php echo $form->textField($model, 'rep_username', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($model, 'rep_password'); ?>
            <?php echo $form->passwordField($model, 'rep_password', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_firstname'); ?>
            <?php echo $form->textField($profile, 'rep_profile_firstname', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_lastname'); ?>
            <?php echo $form->textField($profile, 'rep_profile_lastname', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_email'); ?>
            <?php echo $form->textField($profile, 'rep_profile_email', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php echo $form->labelEx($profile, 'rep_profile_phone'); ?>
            <?php echo $form->textField($profile, 'rep_profile_phone', array('class' => "form-field")); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $button = 'Edit';
            if($model->isNewRecord){
                $button = 'Create';
            }
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), $button);
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>