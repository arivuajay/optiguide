<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>

    <h2> <?php echo Myclass::t('OG040', '', 'og'); ?> </h2>
    <div class="search-list">
     <?php  
     if(!empty($model))
     {    
        foreach ($model as $proftype => $users) { ?>
            <h2> <?php echo $proftype ?></h2>
            <ul>
                <?php foreach ($users as $info) { ?>
                <li>
                    <?php
                    $dispname = $info['NOM'].','.$info['PRENOM'];
                    echo CHtml::link($dispname, array('/optirep/professionalDirectory/view', 'id' => $info['ID_SPECIALISTE'])) . ' ';   
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
                        'selectedPageCssClass'=>'active',
                        'htmlOptions'=>array(
                            'class'=>'pagination',                               
                        ),                                       
                    ));
    ?>           
</div>
    