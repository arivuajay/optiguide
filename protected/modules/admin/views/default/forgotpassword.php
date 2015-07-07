<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'forgotform',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-signin')
        ));
//echo $form->errorSummary($newmodel, '');
?>
<h2 class="form-signin-heading">Forgot Password ?</h2>
<?php echo $form->errorSummary($newmodel, ''); ?>
<?php 
if (isset($this->flashMessages)):
//    echo '<div class="col-lg-5 col-md-5  col-sm-5 center-block fn clearfix mt20 alert-notify">';
    foreach ($this->flashMessages as $key => $message) {
        echo "<div class='alert alert-$key'>$message</div>";
    }
//    echo '</div>';
endif;
?>
<div class="login-wrap">
    <div class="user-login-info">
        <?php echo $form->textField($newmodel, 'admin_email', array('placeholder' => $newmodel->getAttributeLabel('admin_email'), 'id' => 'input-email', 'class' => 'form-control')); ?>
    </div>


    <button class="btn btn-lg btn-login btn-block" type="submit">Get Reset Link</button>
    <label class="checkbox">
        <span class="pull-right">
            <a href="<?php echo $this->createUrl('/admin/default/login'); ?>"> Login >></a>
        </span>
    </label>
</div>

<?php $this->endWidget(); ?>
