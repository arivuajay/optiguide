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
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo Myclass::t('OG040', '', 'og'); ?> </h2>
            <i class='fa fa-eye paidmems'></i> <?php echo Myclass::t('OG188'); ?>
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
                            $param_array[0]     = '/optiguide/suppliersDirectory/view';
                            $param_array['id']  = $info['ID_FOURNISSEUR'];
                            if($searchModel->ID_SECTION!=''){   $param_array['sectionid'] = $searchModel->ID_SECTION;   }                         
                            if($searchModel->PROD_SERVICE!=''){   $param_array['productid'] = $searchModel->PROD_SERVICE;}
                            if($parampage!=''){   $param_array['disppage'] = $parampage;}
                            
                            $expirydate = $info['profile_expirydate'];                           
                            $today      = time();
                            $expiry_str = strtotime($expirydate);
                            $disp_supp  = CHtml::link($dispname,$param_array) . ' ';   
                            $disp_supp .= $info['NOM_VILLE'].", ".$info['ABREVIATION_'.$this->lang].", ".$info['NOM_PAYS_'.$this->lang]." ";
                            
                            if($expiry_str!='' && ($expiry_str>$today))
                             $disp_supp .= "<i class='fa fa-eye paidmems'></i>";   
                            //$disp_supp .= CHtml::image("{$this->themeUrl}/images/paid.jpg", 'Paid');
                            
                            echo $disp_supp;
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
                                'selectedPageCssClass'=>'active',
                                'htmlOptions'=>array(
                                    'class'=>'pagination',                               
                                ),   
                            ));
            ?>           
        </div>
    </div>
</div>