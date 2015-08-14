<?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form')); ?>
<div class="rep-login">
    <h2> Opti-rep Login </h2>
    <?php echo $form->textField($model, 'username', array('class' => 'rep-loginfield', 'placeholder' => 'Username')); ?>
    <?php echo $form->error($model, 'username') ?>
    <?php echo $form->passwordField($model, 'password', array('class' => 'rep-loginfield', 'placeholder' => 'Password')); ?>
    <?php echo $form->error($model, 'password') ?> 
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href="#"> Forgot Password?</a>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
            <?php echo CHtml::submitButton('Login', array('class' => 'rep-login-btn', 'name' => 'sign_in')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<div class="signup-cont"> 
    <p>  Dont have account ? Signup ! <br/> 
        <?php echo CHtml::link('Register', '/optirep/default/register') ?>
    </p>
</div>