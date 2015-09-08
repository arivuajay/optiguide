<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2>  <?php echo CHtml::image("{$this->themeUrl}/images/title_optinews.gif", 'Opti News'); ?></h2>
            <div class="search-list">
                <?php foreach ($model as $news) { ?>
                    <div class="news-thumbs"> 
                        <h4> 
                            <?php echo CHtml::link($news['TITRE'], array('/optirep/newsManagement/view', 'id' => $news['ID_NOUVELLE'])); ?>
                            <span> <?php echo date("Y-m-d", strtotime($news['DATE_AJOUT1'])); ?> </span>
                        </h4> 
                        <div class="clearfix"></div>
                        <p>
                            <?php echo $news['SYNOPSYS']; ?>
                            <b> <?php echo CHtml::link(Myclass::t('OG015', '', 'og').' <i class="fa fa-arrow-circle-right"></i>', array('/optirep/newsManagement/view', 'id' => $news['ID_NOUVELLE'])); ?> </b> 
                        </p>
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

</div>