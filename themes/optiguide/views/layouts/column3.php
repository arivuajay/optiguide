<?php $this->beginContent('//layouts/main'); ?>
<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">  
    <div class="pro-login"> 
        <div class="login-heading"> <i class="fa fa-lock"></i>  
            Secure Area For Professionals
        </div>
        <input name="" type="text" class="login-field" value="User Name">
        <input name="" type="text" class="login-field" value="Password">
        <span> <a href="#">Forgot your password? </a> </span> <br/>
        <div class="signin-btn-cont"> <input name="" type="button" class="signin-btn" value="Sign in"> </div>
    </div>
    <div class="ad2"> 
        <?php echo CHtml::image("{$this->themeUrl}/images/ad3.jpg", 'Ad') ?>
    </div>
    <div class="ad2"> 
        <?php echo CHtml::image("{$this->themeUrl}/images/ad4.jpg", 'Ad') ?>
    </div>
    <div class="ad2"> 
        <?php echo CHtml::image("{$this->themeUrl}/images/ad5.jpg", 'Ad') ?>
    </div>
</div>

<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
    <?php echo $content; ?>
</div>

<div class="col-xs-12 col-sm-3 col-md-2  col-lg-2"> 
    <div class="ad3">
        <?php echo CHtml::image("{$this->themeUrl}/images/ad2.jpg", 'Logo') ?>
    </div>
    <div class="ad3">
        <?php echo CHtml::image("{$this->themeUrl}/images/ad6.jpg", 'Logo') ?>
    </div>
</div>
<?php $this->endContent(); ?>