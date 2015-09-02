<div class="header-cont"> 
    <div class="header-row1"> 
        <div class="container">
            <div class="row"> 
                <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6 col-lg-offset-4 welcome-user">  
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
                                <ul class="nav navbar-nav">
                                    <li><a href="#"> Accueil </a></li>
                                    <li><a href="#"> À propos  </a> </li> 
                                    <li><a href="#">    Legende </a> </li>       
                                    <li><a href="#"> Contact </a></li> 
                                </ul>
                            </div><!--/.nav-collapse -->
                        </div><!--/.container-fluid -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>