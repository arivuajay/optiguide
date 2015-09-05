<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <h2> <?php echo Myclass::t('OG017', '', 'og') ?> </h2>
    <div class="search-list">
        <?php foreach ($model as $month_year => $events) { ?>
            <h4> <?php echo $month_year ?></h4>
            <ul>
                <?php foreach ($events as $event) { ?>
                    <li>
                        <?php
                        echo CHtml::link($event['TITRE'], array('/optirep/calenderEvent/view', 'id' => $event['ID_EVENEMENT'])) . ' ';
                        echo Myclass::t('OG018', '', 'og') . ' ';
                        echo date("Y-m-d", strtotime($event['DATE_AJOUT1'])) . ' ';
                        echo Myclass::t('OG019', '', 'og') . ' ';
                        echo date("Y-m-d", strtotime($event['DATE_AJOUT2']))
                        ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pages,
        'header' => '',
        'selectedPageCssClass'=>'active',
            'htmlOptions'=>array(
                'class'=>'pagination',                               
            ),  
    ))
    ?>
</div>