<?php echo  $this->renderPartial('/suppliersDirectory/_search', array('searchModel' => $searchModel)); ?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7"> 
        <div class="welcome-cont"> 
            <h2>  <?php echo Myclass::t('OG051', '', 'og'); ?></h2>
            <?php echo Myclass::t('OG057', '', 'og'); ?>
            <?php if (Yii::app()->user->isGuest) { ?>
                <p><?php echo Myclass::t('OG058', '', 'og'); ?>  <?php echo CHtml::link(Myclass::t('OG045', '', 'og'), array('/optiguide/default/subscribe')); ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5"> 
        <div class="opti-rep-cont">
            <div class="opti-rep-logo"> 
                <?php echo CHtml::image("{$this->themeUrl}/images/opti-rep-logo.png", 'Logo') ?>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas congue nibh ipsum, rhoncus. Suspendisse eget purus tellus fermentum.</p>
            <p> <p><?php echo Myclass::t('OG058', '', 'og'); ?>   <?php echo CHtml::link(Myclass::t('OG045', '', 'og'), REPURL); ?></p>
        </div>
    </div>

    <?php
   // if (!Yii::app()->user->isGuest) {
        $this->renderPartial('_latest_news');
        //$this->renderPartial('_calender');
        $this->renderPartial('_poll');
  //  }

    $this->renderPartial('_did_you_know');
    ?>
</div>