<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <div class="search-list">
                <div class="news-thumbs news-details"> 
                    <h2> <?php echo Myclass::t('OG014', '', 'og'); ?> </h2>
                    <h4> <?php echo $model['TITRE']?></h4> 
                    <div class="clearfix"></div>
                    <p> <?php echo nl2br($model['TEXTE'])?> </p>
                    <p> <?php echo CHtml::link( Myclass::t('OG016', '', 'og'), array('/optiguide/managementAdvice/index'), array('class' => 'basic-btn')); ?> </p>
                </div>
            </div>
        </div>
    </div>
</div>