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
            <p><?php  echo Myclass::t('OG213');?></p>
            <p> <?php echo CHtml::link(Myclass::t('OG214'), REPURL.'optirep/repCredential/step1'); ?></p>
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
<div class="breton-popup" style="display:none;">    
    <div class="ad2"> 
        <?php
        echo CHtml::image("{$this->themeUrl}/images/bretonpopup/bretonjobs.jpg", 'bretonjobs');
        if(Yii::app()->session['language']=="FR")
        {
           $find_job    = CHtml::image("{$this->themeUrl}/images/bretonpopup/FR/findajob.jpg", 'find a job');  
           $findjob_url = 'http://bretonjobs.com/jobs/?lang=fr';
           $post_job    = CHtml::image("{$this->themeUrl}/images/bretonpopup/FR/postajob.jpg", 'post a job');
           $postjob_url = 'http://bretonjobs.com/pricing/?lang=fr';           
        }else{
           $find_job    = CHtml::image("{$this->themeUrl}/images/bretonpopup/EN/findajob.jpg", 'find a job');  
           $findjob_url = 'http://bretonjobs.com/jobs/';
           $post_job    = CHtml::image("{$this->themeUrl}/images/bretonpopup/EN/postajob.jpg", 'post a job');
           $postjob_url = 'http://bretonjobs.com/pricing/';
        }
        echo "<br>";
        echo CHtml::link($find_job, $findjob_url , array('target' => '_blank'));
        echo "<br>";
        echo CHtml::link($post_job, $postjob_url, array('target' => '_blank')); 
        ?>
    </div>
    <a class="breton-popup-close" href="javascript:void(0);">
      <span><img draggable="false" class="breton" alt="✖" src="<?php echo $this->themeUrl."/images/close.png";?>"></span>      
    </a>
</div>
<?php
$js = <<< EOD
        
$(document).ready(function(){
        
    if(localStorage.getItem('popState') != 'shown'){
        $('.breton-popup').show();
        localStorage.setItem('popState','shown')
    }
        
    $('.breton-popup-close').click(function(){
       $('.breton-popup').hide();
    });
});
EOD;
Yii::app()->clientScript->registerScript('_bretonpopup', $js);
?>