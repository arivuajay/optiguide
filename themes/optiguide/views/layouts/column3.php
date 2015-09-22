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

<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">  
    <?php
    if (Yii::app()->user->isGuest) {
        $this->widget('OgLoginFormWidget');
    } else {
        ?>
        <div class="pro-login">
            <div class="user-thumb"> 
                <?php echo CHtml::image("{$this->themeUrl}/images/user-img.jpg", 'Ad'); ?> 
                <?php echo Myclass::t('OG051', '', 'og'); ?><br/><b><?php echo Yii::app()->user->name ?></b>
            </div>
            <?php
            if (Yii::app()->user->role == "Professionnels") {
                $professional_id = Yii::app()->user->relationid;
                $mr_model = MappingRetailers::model()->findAll("ID_SPECIALISTE=" . $professional_id);
                if (!empty($mr_model)) {
                    $profile_perc = 100;
                } else {
                    $profile_perc = 75;
                }
                ?>
                <div style="float:left; width:100%; margin-top: 15px; ">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $profile_perc; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $profile_perc; ?>%">
                            <?php echo $profile_perc; ?>% Complete
                        </div>
                    </div>  
                    <?php if ($profile_perc == "75") {
                        ?>
                        <p> <?php echo CHtml::link(Myclass::t('OGO146', '', 'og') . ' (+25%)', array('/optiguide/professionalDirectory/mappingretailers'), array('class' => 'dotBullet blank')); ?></p>
                    <?php } ?>
                </div>
                <?php
            }
            ?> 

            <?php
            if (Yii::app()->user->role == "Professionnels") {
                $profileurl = '/optiguide/professionalDirectory/update';
            } else if (Yii::app()->user->role == "Detaillants") {
                $profileurl = '/optiguide/retailerDirectory/update';
            } else if (Yii::app()->user->role == "Fournisseurs") {
                $profileurl = '/optiguide/suppliersDirectory/update';
            }

            // Current controller name
            $_controller = Yii::app()->controller->id;
            $_action = Yii::app()->controller->action->id;
            $this->widget('zii.widgets.CMenu', array(
                'activateParents' => true,
                'activeCssClass' => 'active2',
                'encodeLabel' => false,
                'activateItems' => true,
                'items' => array(
                    // For all users 
                    array('label' => Myclass::t('OG033', '', 'og'), 'url' => array($profileurl), 'active' => (($_controller == "professionalDirectory" || $_controller == "retailerDirectory" || $_controller == "suppliersDirectory") && $_action == "update")),
                    // For suppliers
                    array('label' => Myclass::t('OG059', '', 'og'), 'url' => array('/optiguide/suppliersDirectory/updateproducts'), 'active' => ($_controller == 'suppliersDirectory' && ($_action == "updateproducts" || $_action == "updatemarques")), 'visible' => (Yii::app()->user->role == "Fournisseurs")),
                    array('label' => Myclass::t('OGO168', '', 'og'), 'url' => array('/optiguide/suppliersDirectory/mappingreps'), 'active' => ($_controller == 'suppliersDirectory' && $_action == "mappingreps"), 'visible' => (Yii::app()->user->role == "Fournisseurs")),
                    array('label' => Myclass::t('OGO169', '', 'og'), 'url' => array('/optiguide/suppliersDirectory/listreps'), 'active' => ($_controller == 'suppliersDirectory' && $_action == "listreps"), 'visible' => (Yii::app()->user->role == "Fournisseurs")),
                    array('label' => Myclass::t('OGO139', '', 'og'), 'url' => array('/optiguide/suppliersDirectory/transactions'), 'active' => ($_controller == 'suppliersDirectory' && $_action == "transactions"), 'visible' => (Yii::app()->user->role == "Fournisseurs")),
                    array('label' => Myclass::t('OGO187', '', 'og'), 'url' => array('/optiguide/suppliersDirectory/renewsubscription'), 'active' => ($_controller == 'suppliersDirectory' && $_action == "renewsubscription"), 'visible' => (Yii::app()->user->role == "Fournisseurs")),
                    // For Professionals
                    array('label' => Myclass::t('OGO146', '', 'og'), 'url' => array('/optiguide/professionalDirectory/mappingretailers'), 'active' => ($_controller == 'professionalDirectory' && $_action == "mappingretailers"), 'visible' => (Yii::app()->user->role == "Professionnels")),
                    array('label' => Myclass::t('OGO149', '', 'og'), 'url' => array('/optiguide/professionalDirectory/listretailers'), 'active' => ($_controller == 'professionalDirectory' && $_action == "listretailers"), 'visible' => (Yii::app()->user->role == "Professionnels")),
                    array('label' => Myclass::t('OGO160', '', 'og'), 'url' => array('/optiguide/professionalDirectory/retailersrequest'), 'active' => ($_controller == 'professionalDirectory' && $_action == "retailersrequest"), 'visible' => (Yii::app()->user->role == "Professionnels")),
                    // Internal messages
                    array('label' => 'Internal Messages', 'url' => array('/optiguide/internalMessage/'), 'active' => $_controller == 'internalMessage', 'visible' => (Yii::app()->user->role == "Professionnels" || Yii::app()->user->role == "Detaillants")),   
                    // For all users
                    array('label' => Myclass::t('OGO112', '', 'og'), 'url' => array('/optiguide/userDirectory/changepassword'), 'active' => ($_controller == "userDirectory" && $_action == "changepassword")),
                    array('label' => "<i class='fa fa-sign-out'></i> " . Myclass::t('OG025', '', 'og'), 'url' => array('/optiguide/default/logout')),
                ),
                'htmlOptions' => array('class' => 'sidebar-menu')
            ));
            ?>
        </div>
    <?php } ?>

    <div class="ad2"> 
        <!--  Menu - position - 3 -->
        <?php echo Myclass::banner_display(3); ?>
    </div>


    <div class="ad2"> 
        <!--  Island- position - 4 -->
        <?php echo Myclass::banner_display(4); ?>
    </div>

    <?php
    // if (!Yii::app()->user->isGuest)
    $this->widget('OgCalenderWidget');
    ?>

    <div class="ad2"> 
        <?php
        echo CHtml::image("{$this->themeUrl}/images/bretonJOBS_logo_noslogan.jpg", 'Ad');
        $find_job = CHtml::image("{$this->themeUrl}/images/boutons-find.png", 'Ad');
        echo CHtml::link($find_job, 'http://bretonjobs.com/jobs/', array('target' => '_blank'));
        $post_job = CHtml::image("{$this->themeUrl}/images/boutons-post.png", 'Ad');
        echo CHtml::link($post_job, 'http://bretonjobs.com/pricing/', array('target' => '_blank'));
        ?>
    </div>
</div>

<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
    <?php echo $content; ?>
</div>

<div class="col-xs-12 col-sm-3 col-md-2  col-lg-2"> 

    <div class="ad3">
        <!--  Sky Scraper - position - 5 -->
        <?php echo Myclass::banner_display(5); ?>
    </div>


    <div class="ad3">   
        <!--  Parking - position - 6 -->
        <?php echo Myclass::banner_display(6); ?>
    </div>

</div>
<?php $this->endContent(); ?>