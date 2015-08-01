<?php $latest_news = NewsManagement::model()->latest()->findAll(); ?>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="latest-newscont"> 
        <h2> <?php echo Myclass::t('OG037', '', 'og'); ?>  </h2>
        <?php foreach ($latest_news as $latest_new) { ?>
            <div class="news-cont"> 
                <div class="news-date"> <?php echo date("M", strtotime($latest_new['DATE_AJOUT1'])) . ' ' . date("d", strtotime($latest_new['DATE_AJOUT1'])) ?> </div> 
                <div class="news-txt">
                    <?php echo CHtml::link($latest_new['TITRE'], array('/optiguide/newsManagement/view', 'id' => $latest_new['ID_NOUVELLE'])); ?>
                </div>
            </div>
        <?php } ?>
        <?php echo CHtml::link(Myclass::t('OG038', '', 'og'), array('/optiguide/newsManagement'), array('class' => 'basic-btn right')); ?>
    </div>
</div>