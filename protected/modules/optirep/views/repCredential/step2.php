<?php $this->renderPartial('_register_steps', array('step' => $step)); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <h2> Basic Information </h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rep-credential-form',
    ));
    echo $form->errorSummary(array($model, $profile));
    ?>
    <div class="form-group"> 
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'rep_username'); ?>
                <?php echo $form->textField($model, 'rep_username', array('class' => 'form-field')); ?>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'rep_password'); ?>
                <?php echo $form->passwordField($model, 'rep_password', array('class' => 'form-field')); ?>  
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_firstname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_firstname', array('class' => 'form-field')); ?>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_lastname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_lastname', array('class' => 'form-field')); ?>
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_email'); ?>
                <?php echo $form->textField($profile, 'rep_profile_email', array('class' => 'form-field')); ?>  
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_phone'); ?>
                <?php echo $form->textField($profile, 'rep_profile_phone', array('class' => 'form-field')); ?>  
            </div>

            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 register-select">    
                <?php echo $form->labelEx($model, 'no_of_accounts_purchase'); ?>
                <?php echo $form->numberField($model, 'no_of_accounts_purchase', array('class' => 'form-field', "min" => "1", "step" => "1")); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 pull-right steps-btn-cont"> 
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), ' Next <i class="fa fa-angle-double-right"></i>');
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div class="clearfix"> </div>