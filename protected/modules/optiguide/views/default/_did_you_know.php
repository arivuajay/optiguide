<?php $did_you_know = ManagementAdvice::model()->random()->find(); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
    <div class="inner-container"> 
        <h2> <?php echo Myclass::t('OG014', '', 'og'); ?>  </h2>
        <?php if(!empty($did_you_know))
        {?>    
        <p>
            <?php echo CHtml::link($did_you_know['TITRE'], array('/optiguide/managementAdvice/view', 'id' => $did_you_know['ID_CONSEIL'])); ?>
        </p>
        <p>
            <?php echo $did_you_know['SYNOPSYS'] ?>
            <?php echo CHtml::link(Myclass::t('OG015', '', 'og'), array('/optiguide/managementAdvice/view', 'id' => $did_you_know['ID_CONSEIL'])); ?>
        </p>
        <?php
        }else{?>
        <p><?php echo Myclass::t('OG222');?></p>
        <?php }?>
    </div>
      <?php echo CHtml::link(Myclass::t('OG161'), array('/optiguide/managementAdvice'), array('class' => 'basic-btn right')); ?>
</div>