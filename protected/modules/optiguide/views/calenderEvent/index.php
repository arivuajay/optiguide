<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-calendar"></i>  Find an event </div>
    </div>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optiguide/calenderEvent/index'),
        'htmlOptions' => array('role' => 'form')
    ));

    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions();
    $cities = Myclass::getallcities();
    $months = Myclass::getMonths();
    $connection = Yii::app()->db;
    $year_command = $connection->createCommand('SELECT ID_EVENEMENT, YEAR(DATE_AJOUT1) AS event_year FROM `optiguide`.`calendrier_calendrier` GROUP BY YEAR(`DATE_AJOUT1`)');
    $years = $year_command->queryAll();
    $list_year = CHtml::listData($years, 'event_year', 'event_year');
    ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'TITRE', array('class' => 'txtfield')); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_PAYS', $country, array('class' => '', 'empty' => Myclass::t('APP43'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_REGION', $regions, array('class' => '', 'empty' => Myclass::t('APP44'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_VILLE', $cities, array('class' => '', 'empty' => Myclass::t('APP59'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 "> 
        <?php echo $form->dropDownList($searchModel, 'EVENT_MONTH', $months, array('class' => 'selectpicker', 'empty' => Myclass::t('APP59'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 ">   
        <?php echo $form->dropDownList($searchModel, 'EVENT_YEAR', $list_year, array('class' => 'selectpicker', 'empty' => Myclass::t('APP59'))); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton('Find', array('class' => 'find-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

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
                                <a href="calendrier_details.asp?evenement=1057"><?php echo $event['TITRE'] ?></a>, 
                                <?php
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
            // display pagination
            $this->widget('CLinkPager', array(
                'pages' => $pages,
                'header' => ''
            ))
            ?>
        </div>
    </div>
</div>