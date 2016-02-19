<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <span class="text-right"><?php echo Myclass::t('OR778', '', 'or').': '.$total;?> </span>
    <h2> <?php echo Myclass::t('OG017', '', 'og') ?> </h2>
    <div class="search-list calendar-list">
        <?php foreach ($model as $month_year => $events) { ?>
            <h3> <?php echo $month_year ?></h3>
            <ul>
                <?php foreach ($events as $event) { 
                    
                    $dstr = '';
                    if($event['city']!='')
                    {
                        $dstr =  $event['city'].', ';
                    } 
                    if($event['region']!='')
                    {
                        $dstr .=  $event['region'].', ';
                    } 
                    if($event['country']!='')
                    {
                        $dstr .=  $event['country'].' ';
                    } 
                    ?>
                    <li>
                        <?php
                        echo CHtml::link($event['TITRE'], array('/optirep/calenderEvent/view', 'id' => $event['ID_EVENEMENT'])) . ' - '.$dstr;
                        ?>
                        <div class="frm-to">
                        <?php 
                        echo Myclass::t('OG018', '', 'og') . ' ';
                        echo '<b>'.date("Y-m-d", strtotime($event['DATE_AJOUT1'])) . '</b> ';
                        echo Myclass::t('OG019', '', 'og') . ' ';
                        echo '<b>'.date("Y-m-d", strtotime($event['DATE_AJOUT2'])). '</b> ';
                        ?>
                        </div>
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