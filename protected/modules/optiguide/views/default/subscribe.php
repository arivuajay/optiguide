<?php //echo Yii::app()->session['language'];?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2><?php echo Myclass::t('OG028', '', 'og');?></h2>
                <?php echo Myclass::t('OG029', '', 'og');?>
            <div class="row subscribe-btncont"> 
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <?php echo CHtml::link('<i class="fa fa-briefcase"></i> '.Myclass::t('OG030', '', 'og'), array('/optiguide/professionalDirectory/create'), array('class' => 'subscribe-btn'))?>
                </div> 
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">  
                    <a href="#" class="subscribe-btn"> <i class="fa fa-users"></i> <?php echo Myclass::t('OG031', '', 'og');?> </a>
                </div> 
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">                    
                   <?php echo CHtml::link('<i class="fa fa-user"></i> '.Myclass::t('OG032', '', 'og'), array('/optiguide/retailerDirectory/create'), array('class' => 'subscribe-btn'))?>
                </div> 
            </div>
        </div>
    </div>
</div>