<div class="cate-bg user-right">
<?php 
    $actionpage = Yii::app()->controller->action->id;
    if($actionpage == "index")
    {    
        $this->renderPartial('_search', array('searchModel' => $searchModel));
        $parampage = "home";
    }elseif($actionpage == "category")
    {
        $this->renderPartial('_search_cat', array('searchModel' => $searchModel)); 
       $parampage = "category";
    }
?>
    <div class="search-list">
        <h2><?php echo Myclass::t('OG040', '', 'og'); ?> </h2>
        <?php  
        $sectionid = ($searchModel->ID_SECTION!='')?"'sectionid' => ".$searchModel->ID_SECTION:'';
        $productid = ($searchModel->PROD_SERVICE!='')?"'productid' => ".$searchModel->PROD_SERVICE:'';
        if(!empty($model))
        {    
           foreach ($model as $proftype => $users) { ?>
               <h4> <?php echo $proftype ?></h4>
               <ul>
                   <?php foreach ($users as $info) { ?>
                   <li class="noBorder">
                       <?php
                       $dispname = $info['COMPAGNIE'];
                       $param_array[0]     = '/optirep/suppliersDirectory/view';
                       $param_array['id']  = $info['ID_FOURNISSEUR'];
                       if($searchModel->ID_SECTION!=''){   $param_array['sectionid'] = $searchModel->ID_SECTION;   }                         
                       if($searchModel->PROD_SERVICE!=''){   $param_array['productid'] = $searchModel->PROD_SERVICE;}
                       if($parampage!=''){   $param_array['disppage'] = $parampage;}

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
        }?>
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