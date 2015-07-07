<?php
$baseUrl = Yii::app()->baseUrl;
$themeUrl = Yii::app()->theme->baseUrl;
?>

<body class="minimal login-page">
    <script> var boxtest = localStorage.getItem('boxed');
        if (boxtest === 'true') {
            document.body.className += ' boxed-layout';
        }</script>
    <a href="<?php echo Yii::app()->createAbsoluteUrl('/')?>" id="return-arrow"> <i class="fa fa-arrow-circle-left fa-3x text-light"></i> <span class="text-light"> Return <br>
            to Website </span> </a>

    <!-- Start: Main -->
    <div id="main">
        <div id="content">
            <div class="row">
                <div id="page-logo"> </div>
            </div>
            <div class="row">
                <div class="panel-bg">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'users-form',
                        'enableAjaxValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('class' => 'form-signin cmxform', 'role' => 'form')
                    ));
                    if (isset(Yii::app()->request->cookies['altimus_app_username']->value)) {
                        $model->username = Yii::app()->request->cookies['altimus_app_username']->value;
                        $model->rememberMe = 1;
                    }
                    ?>
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title"> <span class="glyphicon glyphicon-lock text-purple2"></span> Login </span>
                        </div>

                        <div class="panel-body">
                            <?php
                            foreach ($this->flashMessages as $key => $message) {
                                echo '<div class="alert flash-' . $key . '">' . $message . "</div>\n";
                            }
                            ?>
                            <div class="login-avatar"> <img src="<?php echo $themeUrl; ?>/css/frontend/img/avatars/login.png" width="150" height="112" alt="avatar">
                                <div class="home-red">Your Own Personal Diary / Journal</div>
                            </div>
                            <div class="form-group">
                                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span> </span>
                                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'autocomplete' => 'off', 'autofocus', 'placeholder' => $model->getAttributeLabel('username'))); ?>
                                    <!--<input type="text" class="form-control" placeholder="User Name">-->
                                </div>
                                <?php echo $form->error($model, 'username', array('class' => 'error')); ?>
                            </div>
                            <div class="form-group">
                                <span class="text-password">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo CHtml::link('Lost password', array('/site/users/forgot')) ?></span>
                                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-link"></span> </span>
                                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('password'))); ?>
                                    <!--<input type="text" class="form-control" placeholder="Password">-->
                                </div>
                                <?php echo $form->error($model, 'password', array('class' => 'error')); ?>
                            </div>
                            <div class="panel-footer">
                                <span class="text-muted fs12 lh30">
                                    <button type="button" data-provider="facebook" class="btn btn-sm bg-blue1 pull-left oAuthLogin">Connect with Facebook &nbsp;<i class="fa fa-facebook"></i></button>
                                </span>
<!--                                <button type="button" data-provider="twitter" class="btn btn-sm bg-blue2 pull-right oAuthLogin">Connect with Twitter &nbsp;<i class="fa fa-twitter"></i></button>-->
                                <button type="button" data-provider="google" class="btn btn-sm bg-red3 pull-right oAuthLogin">Connect with Google+ &nbsp;<i class="fa fa-google-plus"></i></button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="text-muted fs12 lh30">
                                <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'check','checked'=>'checked')); ?>
                                <?php echo ' Remember Me'; ?>
                            </span>
                            <div class="pull-right">
                                <?php echo CHtml::link('Register', array('/site/users/register'), array("class" => "btn btn-sm bg-primary register")); ?>

                                <?php echo CHtml::button('Login', array("class" => "btn btn-sm bg-purple2", "type" => "submit", 'name' => 'sign_in')); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="panel-bg1">© Copyright 2015. All Rights Reserved.</div>
            </div>
        </div>
    </div>
    <!-- End: Main -->

    <div class="overlay-black"></div>
    <script type="text/javascript">
        jQuery(document).ready(function() {

            "use strict";

            // Init Theme Core
//            Core.init();

            // Enable Ajax Loading
            Ajax.init();

            // Init Full Page BG(Backstretch) plugin
            $.backstretch("<?php echo $themeUrl; ?>/css/frontend/img/stock/splash/6.jpg");


            $('.oAuthLogin').click(function(e) {
                var _frameUrl = "<?php echo Yii::app()->createAbsoluteUrl('/site/users/signupsocial'); ?>?provider=" + $(this).data('provider');
                window.open(_frameUrl, "SignIn", "width=580,height=410,toolbar=0,scrollbars=0,status=0,resizable=0,location=0,menuBar=0,left=400,top=150");
                e.preventDefault();
                return false;
            });

        });
    </script>
</body>
