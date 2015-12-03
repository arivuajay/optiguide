<div class="pro-login">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => false,
        'clientOptions' => array('validateOnSubmit' => true),
        'htmlOptions' => array('class' => 'customClass'),
//        'action' => array('/optiguide/default/login'), // this is is the action that's going to process the data
    ));
    ?>

    <div class="login-heading"> <i class="fa fa-lock"></i>          
      <?php echo  Myclass::t('OG054', '', 'og');?>
    </div>
    <?php echo $form->textField($model, 'username', array('class' => 'login-field','placeholder'=> Myclass::t('APP3'))); ?>
    <?php echo $form->error($model, 'username'); ?>
    
    <?php echo $form->passwordField($model, 'password', array('class' => 'login-field','placeholder'=> Myclass::t('APP4'))); ?>
    <?php echo $form->error($model, 'password'); ?>
    
    <span> <?php echo CHtml::link(Myclass::t('OG056', '', 'og'), array('/optiguide/userDirectory/forgotpassword')); ?> </span> <br/>
    <div class="signin-btn-cont"> 
        <?php echo CHtml::submitButton( Myclass::t('OG055', '', 'og') , array('name' => 'sign_in', 'class' => 'signin-btn')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>