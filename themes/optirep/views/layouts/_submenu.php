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
                <ul class="nav navbar-nav">
                    <li><?php echo CHtml::link(Myclass::t('OG008', '', 'og'), array('/optirep/suppliersDirectory')); ?></li>        
                    <li><?php echo CHtml::link(Myclass::t('OG009', '', 'og'), array('/optirep/suppliersDirectory/category')); ?></li>          
                    <li><?php echo CHtml::link(Myclass::t('OG010', '', 'og'), array('/optirep/marqueDirectory')); ?></li>     
                    <li><?php echo CHtml::link(Myclass::t('OG011', '', 'og'), array('/optirep/newsManagement')); ?></li>        
                    <li><?php echo CHtml::link(Myclass::t('OG012', '', 'og'), array('/optirep/calenderEvent')); ?></li>          
                    <li><?php echo CHtml::link(Myclass::t('OG013', '', 'og'), array('/optirep/groupInformation')); ?></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>         