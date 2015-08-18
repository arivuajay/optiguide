<?php $this->beginContent('//layouts/main'); ?>

<?php if (isset($this->flashMessages)): ?>
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

<div class="body-cont repadmincont"> 
    <div class="container"> 
        <div class="row">
            <?php $this->renderPartial('//layouts/_submenu'); ?>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <?php $this->renderPartial('//layouts/_user_sidebar'); ?>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">  
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>