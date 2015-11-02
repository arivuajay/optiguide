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
                        <?php
                        $rep_credential = RepCredentials::model()->findByPk(Yii::app()->user->id);
                        $rep_credential_profile = $rep_credential->repCredentialProfiles;
                        ?>
                        <p> 
                            <?php
                            if ($rep_credential_profile['rep_profile_picture']) {
                                echo CHtml::image('/' . REP_PROFILE_PICTURE . $rep_credential_profile['rep_profile_picture'], 'Profile', array('width' => 135, 'height' => 135));
                            } else {
                                echo CHtml::image($this->themeUrl . '/images/user-img.jpg', 'Profile');
                            }
                            ?> 
                        </p>
                        <p> 
                            <?php
                            echo CHtml::link(Yii::app()->user->getState('rep_username'), '/optirep/repCredential/editprofile')
                            ?>
                        </p>
                        <?php if (Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE) { ?>
                            <?php $rep_expiry_date = $rep_credential['rep_expiry_date']; ?>
                            <p>
                                <?php echo Myclass::t('OR529', '', 'or')?> :
                                <b><?php echo Myclass::dateFormat($rep_expiry_date) ?></b>
                            </p>
                        <?php } ?>
                        <p> <i class="fa fa-sign-out"></i> <?php echo CHtml::link(Myclass::t('OR659', '', 'or'), '/optirep/default/logout') ?></p>
                    </div>
                    <?php
                    $stats_disp = Myclass::stats_display();

                    $this->widget('zii.widgets.CMenu', array(
                        'encodeLabel' => false,
                        'activeCssClass' => 'active',
                        'items' => array(
                            array('label' => '<i class="fa fa-pencil-square-o"></i> ' . Myclass::t('OR552', '', 'or'), 'url' => array('/optirep/repCredential/editprofile')),
                            array('label' => '<i class="fa fa-money"></i> ' . Myclass::t('OR545', '', 'or'), 'url' => array('/optirep/repAccounts/subscriptions'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN),
                            array('label' => '<i class="fa fa-exchange"></i> ' . Myclass::t('OR656', '', 'or'), 'url' => array('/optirep/repAccounts/transactions'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN),
                            array('label' => '<i class="fa fa-briefcase"></i> ' . Myclass::t('OR524', '', 'or'), 'url' => array('/optirep/repAccounts/index'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN)),
                            array('label' => '<i class="fa fa-money"></i> ' . Myclass::t('OR545', '', 'or'), 'url' => array('/optirep/repSingleSubscriptions/index'), 'visible' => (Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE && Yii::app()->user->rep_parent_id == 0)),
                            array('label' => '<i class="fa fa-exchange"></i> ' . Myclass::t('OR656', '', 'or'), 'url' => array('/optirep/repSingleSubscriptions/transactions'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE && Yii::app()->user->rep_parent_id == 0),
                            array('label' => '<i class="fa fa-envelope"></i> ' . Myclass::t('OR623', '', 'or'), 'url' => array('/optirep/internalMessage/index'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE)),
                            array('label' => '<i class="fa fa-heart"></i> ' . Myclass::t('OR565', '', 'or'), 'url' => array('/optirep/repFavourites/index'), 'visible' => Yii::app()->user->rep_role == RepCredentials::ROLE_SINGLE),
                            array('label' => '<i class="fa fa-file-text-o"></i> ' . Myclass::t('OR521', '', 'or'), 'url' => array('/optirep/repNotes/index')),
                            array('label' => '<i class="fa fa-line-chart"></i> ' . Myclass::t('OR657', '', 'or'), 'url' => array('/optirep/repStatistics/index'), 'visible' => ($stats_disp == "1")),
                            array('label' => ' <i class="fa fa-users"></i> ' . Myclass::t('OR586', '', 'or'), 'url' => array('/optirep/repStatistics/userslogstats'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN && $stats_disp == "1")),
                            array('label' => '<i class="fa fa-eye"></i> ' . Myclass::t('OR585', '', 'or'), 'url' => array('/optirep/repStatistics/profileviewstats'), 'visible' => (isset(Yii::app()->user->rep_role) && Yii::app()->user->rep_role == RepCredentials::ROLE_ADMIN && $stats_disp == "1")),
                            array('label' => '<i class="fa fa-credit-card"></i> ' . Myclass::t('OR658', '', 'or'), 'url' => array('/optirep/repStatistics/payment')),
                            array('label' => '<i class="fa fa-key"></i> ' . Myclass::t('OR551', '', 'or'), 'url' => array('/optirep/repCredential/changePassword')),
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