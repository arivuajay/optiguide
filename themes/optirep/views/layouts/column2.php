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
                        <p> 
                            <?php
                            echo CHtml::link(Yii::app()->user->getState('rep_username'), '/optirep/repCredential/editprofile')
                            ?>
                        </p>
                        <?php if (Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE) { ?>
                            <?php
                            $rep_credential = RepCredentials::model()->findByPk(Yii::app()->user->id);
                            $rep_expiry_date = $rep_credential['rep_expiry_date'];
                            ?>
                            <p>
                                Expiry Date :
                                <b><?php echo date("Y-m-d", strtotime($rep_expiry_date)) ?></b>
                            </p>
                        <?php } ?>
                        <p> <i class="fa fa-sign-out"></i> <?php echo CHtml::link('Logout', '/optirep/default/logout') ?></p>
                    </div>
                    <?php
                    $stats_disp = Myclass::stats_display();

                    $this->widget('zii.widgets.CMenu', array(
                        'encodeLabel' => false,
                        'activeCssClass' => 'active',
                        'items' => array(
                            array('label' => '<i class="fa fa-pencil-square-o"></i> Edit Profile', 'url' => array('/optirep/repCredential/editprofile')),
                            array('label' => '<i class="fa fa-money"></i> Subscription Details', 'url' => array('/optirep/repAccounts/subscriptions'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN),
                            array('label' => '<i class="fa fa-exchange"></i> Transaction Details', 'url' => array('/optirep/repAccounts/transactions'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN),
                            array('label' => '<i class="fa fa-briefcase"></i> Manage Rep Accounts', 'url' => array('/optirep/repAccounts/index'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN)),
                            array('label' => '<i class="fa fa-money"></i> Subscription Details', 'url' => array('/optirep/repSingleSubscriptions/index'), 'visible' => (Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE && Yii::app()->user->rep_parent_id == 0)),
                            array('label' => '<i class="fa fa-exchange"></i> Transaction Details', 'url' => array('/optirep/repSingleSubscriptions/transactions'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE && Yii::app()->user->rep_parent_id == 0),
                            array('label' => '<i class="fa fa-envelope"></i> Internal Messages', 'url' => array('/optirep/internalMessage/index'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE)),
                            array('label' => '<i class="fa fa-heart"></i> Favorite Users', 'url' => array('/optirep/repFavourites/index'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE),
                            array('label' => '<i class="fa fa-file-text-o"></i> My Notes', 'url' => array('/optirep/repNotes/index')),
                            array('label' => '<i class="fa fa-line-chart"></i> My Stats', 'url' => array('/optirep/repStatistics/index'), 'visible' => ($stats_disp == "1")),
                            array('label' => ' <i class="fa fa-users"></i> Users log stats', 'url' => array('/optirep/repStatistics/userslogstats'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN && $stats_disp == "1")),
                            array('label' => '<i class="fa fa-eye"></i> Users profile viewed stats', 'url' => array('/optirep/repStatistics/profileviewstats'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN && $stats_disp == "1")),
                            array('label' => '<i class="fa fa-credit-card"></i> Stats Payment/Infos', 'url' => array('/optirep/repStatistics/payment')),
                            array('label' => '<i class="fa fa-key"></i> Change Password', 'url' => array('/optirep/repCredential/changePassword')),
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