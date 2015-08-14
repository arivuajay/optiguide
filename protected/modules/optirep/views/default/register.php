<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <h2> Registration </h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'sales-rep-form',
        'htmlOptions' => array('role' => 'form'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'hideErrorMessage' => true,
        ),
        'enableAjaxValidation' => true,
    ));

    $subscription_types = SalesRepSubscriptionTypes::model()->findAll();
    ?>
    <div class="form-group"> 
        <div class="row">
            <?php echo $form->errorSummary(array($model, $profile)); ?>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'rep_username'); ?>
                <?php echo $form->textField($model, 'rep_username', array('class' => 'form-field')); ?>
                <?php echo $form->error($model, 'rep_username'); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'rep_password'); ?>
                <?php echo $form->passwordField($model, 'rep_password', array('class' => 'form-field')); ?>
                <?php echo $form->error($model, 'rep_password'); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_firstname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_firstname', array('class' => 'form-field')); ?>
                <?php echo $form->error($profile, 'rep_profile_firstname'); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_lastname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_lastname', array('class' => 'form-field')); ?>
                <?php echo $form->error($profile, 'rep_profile_lastname'); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_email'); ?>
                <?php echo $form->textField($profile, 'rep_profile_email', array('class' => 'form-field')); ?>
                <?php echo $form->error($profile, 'rep_profile_email'); ?> 
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_phone'); ?>
                <?php echo $form->textField($profile, 'rep_profile_phone', array('class' => 'form-field')); ?>
                <?php echo $form->error($profile, 'rep_profile_phone'); ?> 
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h4> Price and subscription  </h4>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php foreach ($subscription_types as $subscription_type) { ?>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 subscribtion-txt" >
                        <?php echo $form->radioButton($model, 'rep_subscription_type_id', array('value' => $subscription_type['rep_subscription_type_id'], 'uncheckValue' => null)); ?>
                        <b> <?php echo $subscription_type['rep_subscription_type_name']; ?> </b>
                        <?php echo $subscription_type['rep_subscription_type_amount']; ?> CAD <br/>
                        <span> <?php echo $subscription_type['rep_subscription_type_description']; ?>  </span>
                    </div>
                <?php } ?>
                <?php echo $form->error($model, 'rep_subscription_type_id'); ?> 
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> 
                <?php echo CHtml::submitButton('Register !', array('class' => 'register-btn')); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
    <div class="clearfix"> </div>
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-sm-offset-2 col-md-offset-3 col-lg-offset-4"></div>
</div>