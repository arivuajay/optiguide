<?php 
$this->renderPartial('_search', array('searchModel' => $searchModel));
?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <b class="text-right"><?php echo Myclass::t('OR778', '', 'or').': '.$item_count;?></b>
            <h2> <?php echo Myclass::t('OG040', '', 'og'); ?> </h2>
            <div class="search-list">
             <?php  
             $sectionid = ($searchModel->ID_SECTION!='')?"'sectionid' => ".$searchModel->ID_SECTION:'';
             $productid = ($searchModel->PROD_SERVICE!='')?"'productid' => ".$searchModel->PROD_SERVICE:'';
             if(!empty($model))
             { ?>
                <ul>
                <?php  foreach ($model as $info) 
                    { ?>    
                    <li>
                        <?php    
                        $dispname =  $info['NOM_MARQUE'];
                        $param_array[0]     = '/optiguide/marqueDirectory/suppliers';
                        $param_array['marqueid']  = $info['ID_MARQUE'];
                        if($searchModel->ID_SECTION!=''){   $param_array['sectionid'] = $searchModel->ID_SECTION;  }                         
                        if($searchModel->PROD_SERVICE!=''){ $param_array['productid'] = $searchModel->PROD_SERVICE;}

                        echo CHtml::link($dispname,$param_array);                           
                        ?>
                    </li>
                <?php
                    } ?>
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
                            'selectedPageCssClass'=>'active',
                            'htmlOptions'=>array(
                                'class'=>'pagination',                               
                            ),                                    
                        ));
            ?>           
        </div>
    </div>
</div>