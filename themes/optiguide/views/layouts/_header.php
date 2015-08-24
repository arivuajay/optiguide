<div class="header"> 
    <div class="header-row1"> 
        <div class="container"> 
            <ul class="orion-menu red">
                <li>
                    <?php echo CHtml::link(Myclass::t('OG001', '', 'og'), array('/optiguide/')); ?>
                </li>  
                <li>
                    <?php echo CHtml::link(Myclass::t('OG002', '', 'og'), array('/optiguide/default/advertise')); ?>
                </li>                
                <li>
                    <?php
                    if (Yii::app()->user->isGuest) {
                        echo CHtml::link(Myclass::t('OG003', '', 'og'), array('/optiguide/default/subscribe'));
                    } else {
                        echo CHtml::link(Myclass::t('OG033', '', 'og'), array('/optiguide/userDirectory/update'));
                    }
                    ?>
                </li>    
                <li>
                    <?php echo CHtml::link(Myclass::t('OG004', '', 'og'), array('/optiguide/default/contactus')); ?>
                </li>     
                <li>
                     <?php echo CHtml::link($displang, 'javascript:void(0);', array('onclick' => "document.getElementById('langform').submit();")); ?>
                </li> 
                <li>
                    <?php
                    if (!Yii::app()->user->isGuest)
                        echo CHtml::link('<i class="fa fa-sign-out"></i> ' . Myclass::t('OG025', '', 'og'), array('/optiguide/default/logout'), array('class' => 'loginbg'));
                    ?>
                </li> 
            </ul>
        </div>
    </div>  

    <div class="header-row2">
        <div class="container"> 
            <div class="row">  
                <div class="col-xs-12 col-sm-3 col-md-3  col-lg-3 logo"> 
                    <?php echo CHtml::link(CHtml::image("{$this->themeUrl}/images/logo.jpg", 'Logo'), array('/optiguide/default')); ?>
                </div>                
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 ad1"> 
                 <!--  Supper Banner (Top) - position 1 -->
                 <?php echo Myclass::banner_display(1);?>
                </div>
            </div>
        </div>
    </div>
</div>