<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo Myclass::t('OG014', '', 'og'); ?>  </h2>
            <div class="search-list">
                <?php foreach ($model as $infos) { ?>
                    <div class="news-thumbs"> 
                        <h4>
                            <?php echo CHtml::link($infos['TITRE'], array('/optiguide/managementAdvice/view', 'id' => $infos['ID_CONSEIL'])); ?>
                        </h4> 
                        <div class="clearfix"></div>
                        <p>
                            <?php echo $infos['SYNOPSYS']; ?>                            
                        </p>
                        <b> <?php echo CHtml::link(Myclass::t('OG015', '', 'og'), array('/optiguide/managementAdvice/view', 'id' => $infos['ID_CONSEIL'])); ?> </b> 
                    </div>
                <?php } ?>
                <?php
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                    'currentPage'=>$pages->getCurrentPage(),
                    'header' => '',    
                    'selectedPageCssClass'=>'active',
                    'htmlOptions'=>array(
                        'class'=>'pagination',                               
                    ),   
                ))
                ?>
            </div>
        </div>
    </div>
</div>
