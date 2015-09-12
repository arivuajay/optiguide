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
            
            <?php $this->renderPartial('//layouts/_map'); ?>
   
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="user-left cate-bg"> 
                    <div class="user-deatils"> 
                        <p> <?php echo CHtml::image($this->themeUrl . '/images/user-img.jpg', 'Profile'); ?> </p>
                        <p> <a href="#"><?php echo Yii::app()->user->getState('rep_username'); ?></a> </p>
                        <p> <i class="fa fa-sign-out"></i> <?php echo CHtml::link('Logout', '/optirep/default/logout') ?></p>
                    </div>
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'activeCssClass' => 'active',
                        'items' => array(
                            array('label' => 'Edit Profile', 'url' => array('/optirep/repCredential/editprofile')),                          
                            array('label' => 'Manage Rep Accounts', 'url' => array('/optirep/repAccounts/index')),
                            array('label' => 'Favourite Retailers', 'url' => array('/optirep/repFavourites/index')),
                            array('label' => 'Change Password', 'url' => array('/optirep/repCredential/changePassword')),
                        ),
                    ));
                    ?>
                </div> 
            </div>
            
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">  
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>