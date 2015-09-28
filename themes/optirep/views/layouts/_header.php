<div class="header-cont"> 
    <div class="header-row1"> 
        <div class="container">
            <div class="row"> 
                <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6 col-lg-offset-4 welcome-user"> 
                    <a class="btn btn-default">
                        <i class="fa fa-envelope"><span class="icon_counter icon_counter_red">5</span></i>
                    </a> &nbsp;
                    Welcome, <?php echo CHtml::link(Yii::app()->user->getState('rep_username'), array('/optirep/repCredential/editprofile')); ?>
                </div>
                <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 login"> 
                    <?php echo CHtml::link('<i class="fa fa-sign-out"></i> Logout', '/optirep/default/logout') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="header-row2"> 
        <div class="container">
            <div class="row">
                <div class="col-xs-8 col-sm-4 col-md-3 col-lg-3 col-xs-offset-2 logo"> 
                    <?php
                    $image = CHtml::image($this->themeUrl . '/images/logo.png', 'OptiRep Logo');
                    echo CHtml::link($image, array('/optirep/dashboard'))
                    ?>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6 menu">  
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a href="#" class="navbar-brand">Menu</a>
                            </div>
                            <div class="navbar-collapse collapse" id="navbar">
                                <?php
                                // Current controller name
                                $_controller = Yii::app()->controller->id;
                                $_action = Yii::app()->controller->action->id;
                                $this->widget('zii.widgets.CMenu', array(
                                    'activateParents' => true,
                                    'activeCssClass' => 'active2',
                                    'encodeLabel' => false,
                                    'activateItems' => true,
                                    'items' => array(
                                        array('label' => 'Home', 'url' => array('/optirep/dashboard'), 'active' => ($_controller == 'default' && $_action == 'index')),
                                        array('label' => 'About', 'url' => array('/optirep/default/aboutus'), 'active' => ($_controller == 'default' && $_action == 'aboutus')),
                                        array('label' => 'Legend', 'url' => array('/optirep/default/legend'), 'active' => ($_controller == 'default' && $_action == 'legend')),
                                        array('label' => 'Contact', 'url' => array('/optirep/default/contactus'), 'active' => ($_controller == 'default' && $_action == 'contactus')),
                                    ),
                                    'htmlOptions' => array('class' => 'nav navbar-nav')
                                ));
                                ?>
                            </div><!--/.nav-collapse -->
                        </div><!--/.container-fluid -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>