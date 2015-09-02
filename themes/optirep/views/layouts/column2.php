<?php $this->beginContent("//layouts/authenticate_page"); ?>
<div class="body-cont repadmincont"> 
    <div class="container"> 
        <div class="row">
            <?php $this->renderPartial('//layouts/_submenu'); ?>
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
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="user-left cate-bg"> 
                    <div class="user-deatils"> 
                        <p> <?php echo CHtml::image($this->themeUrl . '/images/user-img.jpg', 'Profile'); ?> </p>
                        <p> <a href="#"><?php echo Yii::app()->user->getState('rep_username'); ?></a> </p>
                        <p> <i class="fa fa-sign-out"></i> <?php echo CHtml::link('Logout', '/optirep/default/logout') ?></p>
                    </div>
                    <ul>
                        <li><a href="#" class="active2">  Change Password </a></li>
                    </ul>
                </div> 
            </div>
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">  
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>