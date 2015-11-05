<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 submenu-cont">  
    <nav class="navbar navbar-default submenu">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <?php echo Myclass::t('OG007', '', 'og') ?>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">   
                <?php                
                // Current controller name
                $_controller = Yii::app()->controller->id;
                $_action = Yii::app()->controller->action->id;
                $this->widget('zii.widgets.CMenu', array(
                    'activateParents' => true,
                    'activeCssClass' => 'active',
                    'encodeLabel' => false,
                    'activateItems' => true,
                    'items' => array(
                        array('label' => Myclass::t('OG008', '', 'og'), 'url' => array('/optiguide/suppliersDirectory'), 'active' => ($_controller == 'suppliersDirectory' && $_action == "index")),
                        array('label' => Myclass::t('OG010', '', 'og'), 'url' => array('/optiguide/marqueDirectory'), 'active' => $_controller == 'marqueDirectory'),     
                        array('label' => Myclass::t('OG009', '', 'og'), 'url' => array('/optiguide/suppliersDirectory/category'), 'active' => ($_controller == 'suppliersDirectory' && $_action == "category")),
                        array('label' => Myclass::t('OG030', '', 'og'), 'url' => array('/optiguide/professionalDirectory'), 'active' => ($_controller == 'professionalDirectory' && $_action == "index") , 'visible'=>(!Yii::app()->user->isGuest)),
                        array('label' => Myclass::t('OG032', '', 'og'), 'url' => array('/optiguide/retailerDirectory'), 'active' => ($_controller == 'retailerDirectory' && $_action == "index"), 'visible'=>(!Yii::app()->user->isGuest)),
                        array('label' => Myclass::t('OG011', '', 'og'), 'url' => array('/optiguide/newsManagement'), 'active' => $_controller == 'newsManagement'),
                        array('label' => Myclass::t('OG012', '', 'og'), 'url' => array('/optiguide/calenderEvent'), 'active' => $_controller == 'calenderEvent'),
                        array('label' => Myclass::t('OG013', '', 'og'), 'url' => array('/optiguide/groupInformation'), 'active' => $_controller == 'groupInformation'),
                        array('label' => Myclass::t('OGO206', '', 'og'), 'url' => array('/optiguide/default/classifieds'), 'active' => $_controller == 'classifieds'),
                    ),
                    'htmlOptions' => array('class' => 'nav navbar-nav')
                ));
                ?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>