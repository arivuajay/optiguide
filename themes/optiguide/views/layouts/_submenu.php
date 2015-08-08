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
                <ul class="nav navbar-nav">
                    <li><?php echo CHtml::link(Myclass::t('OG008', '', 'og'), array('/optiguide/suppliersDirectory')); ?></li>        
                    <li><?php echo CHtml::link(Myclass::t('OG009', '', 'og'), array('/optiguide/suppliersDirectory/category')); ?></li>          
                    <li><?php echo CHtml::link(Myclass::t('OG010', '', 'og'), '#'); ?></li>  
                    <?php if (!Yii::app()->user->isGuest) { ?>
                        <li><?php echo CHtml::link(Myclass::t('OG030', '', 'og'), array('/optiguide/professionalDirectory')); ?></li>  
                        <li><?php echo CHtml::link(Myclass::t('OG032', '', 'og'), array('/optiguide/retailerDirectory')); ?></li>  
                    <?php } ?>
                    <li><?php echo CHtml::link(Myclass::t('OG011', '', 'og'), array('/optiguide/newsManagement')); ?></li>        
                    <li><?php echo CHtml::link(Myclass::t('OG012', '', 'og'), array('/optiguide/calenderEvent')); ?></li>          
                    <li><?php echo CHtml::link(Myclass::t('OG013', '', 'og'), array('/optiguide/groupInformation')); ?></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>