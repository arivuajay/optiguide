<div class="footer-bg"> 
    <div class="container"> 
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">  
                <div class="footer-menu">
                    <ul> 
                        <li> <?php echo CHtml::link(Myclass::t('OG001', '', 'og'), array('/optiguide/')); ?></li> 
                        <li><a href="#">Terms and conditions  </a></li> 
                        <li><a href="#">  Envision  </a></li> 
                        <li><a href="#">   EnVue </a></li> 
                        <li><a href="#">Opti-News  </a></li> 
                        <li><a href="#"> Opti-Promo </a></li> 
                        <li><a href="#">    Opti-Mail </a></li> 
                        <li><a href="#"> Classified </a></li>  
                        <li><?php echo CHtml::link(Myclass::t('OG004', '', 'og'), array('/optiguide/default/contactus')); ?></li>                      
                    </ul>
                    Copyright 2015 © Breton Communications Inc. All rights reserved.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 footer-logo">  
                <?php echo CHtml::image("{$this->themeUrl}/images/breton.png", 'Breton') ?>
            </div>
        </div>
    </div>
</div>