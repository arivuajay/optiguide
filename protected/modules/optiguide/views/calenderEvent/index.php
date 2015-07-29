<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo Myclass::t('OG017', '', 'og') ?> </h2>
            <div class="search-list">
                <?php foreach ($model as $month_year => $events) { ?>
                    <h2> <?php echo $month_year ?></h2>
                    <ul>
                        <?php foreach ($events as $event) { ?>
                            <li>
                                <?php
                                echo CHtml::link($event['TITRE'], array('/optiguide/calenderEvent/view', 'id' => $event['ID_EVENEMENT'])) . ' ';
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
                'header' => ''
            ))
            ?>
        </div>
    </div>
</div>