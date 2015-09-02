<?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form')); ?>
<div class="rep-login">
    <h2> Opti-rep Login </h2>
    <?php
    echo $form->textField($model, 'username', array('autofocus', 'class' => 'rep-loginfield', 'placeholder' => 'Username'));
    echo $form->error($model, 'username');
    echo $form->passwordField($model, 'password', array('autofocus', 'class' => 'rep-loginfield', 'placeholder' => 'Password'));
    echo $form->error($model, 'password');
    ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a href="#"> Forgot Password?</a></div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
            <?php echo CHtml::submitButton('Login', array('class' => 'rep-login-btn', 'name' => 'login')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<div class="signup-cont"> 
    <p>  Dont have account ? Signup ! <br/>  </p>
    <?php echo CHtml::link('Register', '/optirep/repCredential/step1') ?>    
</div>