<?php    $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo Myclass::t('OG040', '', 'og'); ?> </h2>
            <div class="search-list">
             <?php  
             $sectionid = ($searchModel->ID_SECTION!='')?"'sectionid' => ".$searchModel->ID_SECTION:'';
             $productid = ($searchModel->PROD_SERVICE!='')?"'productid' => ".$searchModel->PROD_SERVICE:'';
             if(!empty($model))
             {    
                foreach ($model as $proftype => $users) { ?>
                    <h2> <?php echo $proftype ?></h2>
                    <ul>
                        <?php foreach ($users as $info) { ?>
                        <li>
                            <?php
                            $dispname = $info['COMPAGNIE'];
                            $param_array[0]     = '/optirep/suppliersDirectory/view';
                             $param_array['id']  = $info['ID_FOURNISSEUR'];
                            if($searchModel->ID_MARQUE!=''){   $param_array['marqueid']  = $searchModel->ID_MARQUE; }  
                            if($searchModel->ID_SECTION!=''){   $param_array['sectionid'] = $searchModel->ID_SECTION;   }                         
                            if($searchModel->PROD_SERVICE!=''){   $param_array['productid'] = $searchModel->PROD_SERVICE;}
                              $param_array['disppage'] = 'home';
                                     
                            echo CHtml::link($dispname,$param_array) . ' ';   
                            echo $info['NOM_VILLE'].",".$info['ABREVIATION_'.$this->lang].",".$info['NOM_PAYS_'.$this->lang];
                            ?>
                        </li>
                        <?php } ?>
                    </ul>
                <?php }
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