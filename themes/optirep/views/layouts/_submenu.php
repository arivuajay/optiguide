<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 submenu-cont">  
    <nav class="navbar navbar-default submenu">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button aria-expanded="false" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">Sub Menu</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                <?php
                // Current controller name
                $_controller = Yii::app()->controller->id;     
                $_action     = Yii::app()->controller->action->id;
                $this->widget('zii.widgets.CMenu', array(
                    'activateParents' => true,
                    'activeCssClass' => 'active2',
                    'encodeLabel' => false,
                    'activateItems' => true,
                    'items' => array(
                        array('label' => Myclass::t('OG008', '', 'og'), 'url' => array('/optirep/suppliersDirectory'), 'active' => ($_controller == 'suppliersDirectory' && ($_action == 'index' || $_action == 'view'))),
                        array('label' => Myclass::t('OG009', '', 'og'), 'url' => array('/optirep/suppliersDirectory/category') , 'active' => ($_controller == 'suppliersDirectory' && $_action == 'category')),
                        array('label' => Myclass::t('OG010', '', 'og'), 'url' => array('/optirep/marqueDirectory'), 'active' => $_controller == 'marqueDirectory'),                       
                        array('label' => Myclass::t('OG030', '', 'og'), 'url' => array('/optirep/professionalDirectory'), 'active' => $_controller == 'professionalDirectory'),
                        array('label' => Myclass::t('OG032', '', 'og'), 'url' => array('/optirep/retailerDirectory'), 'active' => $_controller == 'retailerDirectory'),
                        array('label' => Myclass::t('OG011', '', 'og'), 'url' => array('/optirep/newsManagement'), 'active' => $_controller == 'newsManagement'),
                        array('label' => Myclass::t('OG012', '', 'og'), 'url' => array('/optirep/calenderEvent'), 'active' => $_controller == 'calenderEvent'),
                        array('label' => Myclass::t('OG013', '', 'og'), 'url' => array('/optirep/groupInformation'), 'active' => $_controller == 'groupInformation'),
                        ),
                    'htmlOptions' => array('class' => 'nav navbar-nav')
                ));
                ?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>         