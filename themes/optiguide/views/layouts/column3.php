<?php $this->beginContent('//layouts/main'); ?>
<?php
if (isset($this->flashMessages)): ?>
    <?php foreach ($this->flashMessages as $key => $message) { ?>
    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 flashmessage"> 
            <div class="alert alert-<?php echo $key; ?> fade in">
                <button type="button" class="close close-sm" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <?php echo $message; ?>
            </div>
        </div>
    <?php } ?>
<?php endif ?>

<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">  
    <?php
    if (Yii::app()->user->isGuest) {
        $this->widget('OgLoginFormWidget');
    } else {
        ?>
        <div class="pro-login">
            <p>
                Welcome <?php echo Yii::app()->user->name?>
            </p>
            <p>
                <?php echo CHtml::link("Logout", array('/optiguide/default/logout'))?>
            </p>
        </div>
    <?php } ?>
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