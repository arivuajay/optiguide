<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo Myclass::t('OG040', '', 'og'); ?> </h2>
            <div class="search-list">
             <?php  
             if(!empty($model))
             {    
                 ?>
                <ul>
                <?php
                foreach ($model as $userinfo) { ?>      
                        <li>
                            <?php
                            $dispname = $userinfo['COMPAGNIE'];
                            echo CHtml::link($dispname, array('/optiguide/retailerDirectory/view', 'id' => $userinfo['ID_RETAILER'])) . ' ';   
                            echo $userinfo['NOM_VILLE'].",".$userinfo['ABREVIATION_'.$this->lang].",".$userinfo['NOM_PAYS_'.$this->lang];
                            ?>
                        </li>    
                <?php }?>
                 </ul>
            <?php
             }else
             {
                 echo Myclass::t('OG043', '', 'og');               
                 
             }    ?>
            </div>
              <?php
            $this->widget('CLinkPager', array(
                                'pages' => $pages,
                                'currentPage'=>$pages->getCurrentPage(),
                                'itemCount'=>$item_count,
                                'pageSize'=>$page_size,
                                'maxButtonCount'=>10,                                  
                                'header'=>'',                                    
                            ));
            ?>           
        </div>
    </div>
</div>