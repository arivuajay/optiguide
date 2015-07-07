<?php
$baseUrl = Yii::app()->baseUrl;
$themeUrl = Yii::app()->theme->baseUrl;
?>

<div id="main">
    <div id="content">
        <div class="row">
            <div id="page-logo">  </div>
        </div>
        <div class="row">
            <div class="panel-bg">
                <div class="panel">

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'users-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'enableAjaxValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('class' => 'form-signin cmxform', 'role' => 'form')
                    ));
                    ?>

                    <div class="panel-heading"> <span class="panel-title">
                            <span class="glyphicon glyphicon-lock text-purple2"></span> Register </span>
                        <span class="panel-header-menu pull-right mr15 text-muted fs12"><?php echo CHtml::link('Login >>', array('/site/users/login')) ?></span> </div>
                    <div class="panel-body">
                        <div class="login-avatar">
                            <img src="<?php echo $themeUrl; ?>/css/frontend/img/avatars/register.png" width="150" height="112" alt="avatar">
                            <div class="home-red">Your Own Personal Diary / Journal</div>                        </div>
                        <?php // echo $form->errorSummary($model); ?>
                        <div class="form-group">
                            <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span> </span>
                                <!--<input type="text" class="form-control" placeholder="Name">-->
                                <?php echo $form->textField($model, 'user_name', array('placeholder' => 'Name', 'class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                            </div>
                            <?php echo $form->error($model, 'user_name'); ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span> </span>
<!--                                    <input type="text" class="form-control" placeholder="E-mail Address">-->
                                <?php echo $form->textField($model, 'user_email', array('placeholder' => Users::model()->getAttributeLabel('user_email'), 'class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                            </div>
                            <?php echo $form->error($model, 'user_email'); ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-link"></span> </span>
<!--                                    <input type="text" class="form-control" placeholder="Password">-->
                                <?php echo $form->passwordField($model, 'user_password', array('placeholder' => Users::model()->getAttributeLabel('user_password'), 'class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                            </div>
                            <?php echo $form->error($model, 'user_password'); ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-link"></span> </span>
<!--                                    <input type="text" class="form-control" placeholder="Confirm Password">-->
                                <?php echo $form->passwordField($model, 'confirm_password', array('placeholder' => Users::model()->getAttributeLabel('confirm_password'), 'class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                            </div>
                            <?php echo $form->error($model, 'confirm_password'); ?>
                        </div>
                        <?php echo $form->hiddenField($model, 'user_activation_key', array('size' => 60, 'maxlength' => 250)); ?>
                        <div class="panel-footer">
                            <span class="text-muted fs12 lh30">
                                <button type="button" data-provider="facebook" class="btn btn-sm bg-blue1 pull-left oAuthLogin">Connect with Facebook &nbsp;<i class="fa fa-facebook"></i></button>
                            </span>
<!--                            <button type="button" data-provider="twitter" class="btn btn-sm bg-blue2 pull-right oAuthLogin">Connect with Twitter &nbsp;<i class="fa fa-twitter"></i></button>-->
                                <button type="button" data-provider="google" class="btn btn-sm bg-red3 pull-right oAuthLogin">Connect with Google+ &nbsp;<i class="fa fa-google-plus"></i></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="panel-footer"> <span class="text-muted fs12 lh30"><?php echo CHtml::link('Lost password ?', array('/site/users/forgot')) ?></span>
                        <?php ?>
                        <!--<a class="btn btn-sm bg-purple2 pull-right" href="#"><i class="fa fa-home"></i>Register</a>-->
                        <!--<i class="fa fa-home"></i>-->
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Register' : 'Save', array('class' => 'btn btn-sm bg-purple2 pull-right',)); ?>
                        <div class="clearfix"></div>
                    </div>
                    <?php $this->endWidget(); ?>

                </div>
            </div>
            <div class="panel-bg1">© Copyright 2015. All Rights Reserved.</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('.oAuthLogin').click(function(e) {
            var _frameUrl = "<?php echo Yii::app()->createAbsoluteUrl('/site/users/signupsocial'); ?>?provider=" + $(this).data('provider');
            window.open(_frameUrl, "SignIn", "width=580,height=410,toolbar=0,scrollbars=0,status=0,resizable=0,location=0,menuBar=0,left=400,top=150");
            e.preventDefault();
            return false;
        });
    });

</script>