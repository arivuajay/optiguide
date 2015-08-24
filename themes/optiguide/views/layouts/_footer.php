<div class="footer-bg"> 
    <div class="container"> 
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">  
                <div class="footer-menu">         
                    <ul> 
                        <li><?php echo CHtml::link(Myclass::t('OG001', '', 'og'), array('/optiguide/')); ?></li> 
                        <li><?php  echo CHtml::link(Myclass::t('OGO124', '', 'og'), array('/optiguide/default/termsandconditions'));?></li> 
                        <li><?php  echo CHtml::link(Myclass::t('OGO118', '', 'og'), 'http://www.bretoncom.com/envision/' , array('target' => '_blank'));?></li> 
                        <li><?php  echo CHtml::link(Myclass::t('OGO119', '', 'og'), 'http://www.bretoncom.com/envue/' , array('target' => '_blank'));?></li> 
                        <li><?php  echo CHtml::link(Myclass::t('OGO120', '', 'og'), 'http://www.bretoncom.com/optinews/' , array('target' => '_blank'));?></li> 
                        <li><?php  echo CHtml::link(Myclass::t('OGO121', '', 'og'), 'http://www.bretoncom.com/optipromos/' , array('target' => '_blank'));?></li> 
                        <li><?php  echo CHtml::link(Myclass::t('OGO122', '', 'og'), 'http://www.bretoncom.com/optimail/' , array('target' => '_blank'));?></li> 
                        <li><?php  echo CHtml::link(Myclass::t('OGO123', '', 'og'), 'http://www.bretoncom.com/classified/' , array('target' => '_blank'));?></li>  
                        <li><?php  echo CHtml::link(Myclass::t('OG004', '', 'og'), array('/optiguide/default/contactus')); ?></li>  
                        <li><?php  echo CHtml::link($displang, 'javascript:void(0);', array('onclick' => "document.getElementById('langform').submit();")); ?></li> 
                    </ul>
                    Copyright 2015 © Breton Communications Inc. <?php  echo Myclass::t('OGO125', '', 'og');?> .
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 footer-logo">  
                <?php echo CHtml::image("{$this->themeUrl}/images/breton.png", 'Breton') ?>
            </div>
        </div>
    </div>
</div>