<?php 
$envision_url = 'http://bretoncommunications.com/products/envision-magazine/';
$envue_url = 'http://bretoncommunications.com/products/envue-magazine/';
$optinews_url = 'http://bretoncommunications.com/products/opti-news/';
$optipromo_url = 'http://bretoncommunications.com/products/opti-promo/';
$optimail_url = 'http://bretoncommunications.com/products/opti-mail/';


if(Yii::app()->language == 'fr'){
    $envision_url = 'http://bretoncommunications.com/fr/produits/envision-seeing-beyond/';
    $envue_url = 'http://bretoncommunications.com/fr/produits/envue-voir-plus-loin/';
    $optinews_url = 'http://bretoncommunications.com/fr/produits/optinews/';
    $optipromo_url = 'http://bretoncommunications.com/fr/produits/opti-promo/';
    $optimail_url = 'http://bretoncommunications.com/fr/produits/optimail/';
}
?>
<div class="footer-bg"> 
    <div class="container"> 
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">  
                <div class="footer-menu">         
                    <ul> 
                        <li>
                            <?php echo CHtml::link(Myclass::t('OG001', '', 'og'), array('/optiguide/')); ?>
                        </li> 
                        <li>
                            <?php  echo CHtml::link(Myclass::t('OGO124', '', 'og'), array('/optiguide/default/termsandconditions'));?>
                        </li> 
                        <li>
                            <?php  echo CHtml::link(Myclass::t('OGO118', '', 'og'), $envision_url , array('target' => '_blank'));?>
                        </li> 
                        <li>
                            <?php  echo CHtml::link(Myclass::t('OGO119', '', 'og'), $envue_url , array('target' => '_blank'));?>
                        </li> 
                        <li>
                            <?php  echo CHtml::link(Myclass::t('OGO120', '', 'og'), $optinews_url , array('target' => '_blank'));?>
                        </li> 
                        <li>
                            <?php  echo CHtml::link(Myclass::t('OGO121', '', 'og'), $optipromo_url , array('target' => '_blank'));?>
                        </li> 
                        <li>
                            <?php  echo CHtml::link(Myclass::t('OGO122', '', 'og'), $optimail_url , array('target' => '_blank'));?>
                        </li> 
                        <li>
                            <?php  echo CHtml::link(Myclass::t('OG004', '', 'og'), array('/optiguide/default/contactus')); ?>
                        </li>  
                        <li>
                            <?php  echo CHtml::link($displang, 'javascript:void(0);', array('onclick' => "document.getElementById('langform').submit();")); ?>
                        </li> 
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
