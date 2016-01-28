<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <div class="inner-container eventslist-cont"> 
                <h2> <?php echo $model['TITRE'] ?></h2>
                <div class="search-list">
                    <h4> 
                        <?php
                        echo Myclass::t('OG018', '', 'og') . ' ';
                        echo date("Y-m-d", strtotime($model['DATE_AJOUT1'])) . ' ';
                        echo Myclass::t('OG019', '', 'og') . ' ';
                        echo date("Y-m-d", strtotime($model['DATE_AJOUT2']))
                        ?>
                    </h4>
                    <div class="clearfix"></div>
                    <div> 
                        <?php echo $model['TEXTE']; ?>
                        <p>
                            <a target="_blank" href="<?php echo $model['LIEN_URL']; ?>"><?php echo $model['LIEN_TITRE']; ?></a>
                        </p>
                        <div class="clearfix"></div>  
                        <div class="viewall">
                        <?php $pre_url=Yii::app()->request->urlReferrer; 
                              if(empty($pre_url)){?>
                            <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> '.Myclass::t('OG016', '', 'og'), array('/optirep/calenderEvent'),array("class"=>"pull-left")); ?>
                        <?php }else{?>
                            <a class='pull-left' href="<?php echo $pre_url; ?>"><i class="fa fa-arrow-circle-left"></i><?php echo Myclass::t('OG016', '', 'og');?>  </a>
                        <?php }?>
                            </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>