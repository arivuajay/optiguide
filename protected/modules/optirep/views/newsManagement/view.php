<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <div class="search-list">
                <div class="news-thumbs news-details"> 
                    <h4>
                        <?php echo $model['TITRE']; ?>
                        <span> <?php echo date("Y-m-d", strtotime($model['DATE_AJOUT1'])); ?> </span>
                    </h4> 
                    <div class="clearfix"></div>
                    <p> 
                        <?php echo $model['TEXTE']; ?>
                    </p>
                    <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> '.Myclass::t('OG016', '', 'og'), array('/optirep/newsManagement'),array("class"=>"pull-left")); ?> </div>  
                </div>
            </div>
        </div>
    </div>
</div>    
</div>    