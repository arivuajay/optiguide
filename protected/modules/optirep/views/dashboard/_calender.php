<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading cate-heading3"> <i class="fa fa-calendar"></i> Calendar  <?php echo CHtml::link(Myclass::t('OG038', '', 'og'), array('/optirep/calenderEvent'), array('class' => 'topviewall')); ?> </div>
        <div class="calc-cont"> 
            <?php
            $events = CalenderEvent::model()->currentMonthYear()->findAll();
            $events_list = array();
            foreach ($events as $event) {
                $start_date = date("Y-m-d", strtotime($event['DATE_AJOUT1']));
                $end_date = date("Y-m-d", strtotime($event['DATE_AJOUT2']));
                $betweenDates = Myclass::getBetweenDates($start_date, $end_date);
                foreach ($betweenDates as $betweenDate) {
                    $events_list[] = array(
                        'Url' => Yii::app()->createAbsoluteUrl('/optirep/calenderEvent/index', array('date' => $betweenDate)),
                        'Date' => strtotime($betweenDate),
                    );
                }
            }

            $list = json_encode($events_list);

            $js = <<< EOD
            var events = {$list};
                
            function EventHighlight(date) {
                var result = [true, '', null];
                var matching = $.grep(events, function(event) {
                    return event.Date == date.valueOf() / 1000;
                });

                if (matching.length) {
                    result = [true, 'event', null];
                }
                return result;
            }

            function EventRedirect(dateText){
                var date,
                selectedDate = new Date(dateText),
                i = 0,
                event = null;

                /* Determine if the user clicked an event: */
                while (i < events.length && !event) {
                    date = events[i].Date;

                    if (selectedDate.valueOf() / 1000 == date) {
                        event = events[i];
                    }
                    i++;
                }
                if (event) {
                    window.location = event.Url;
                }
            }
EOD;
            Yii::app()->clientScript->registerScript('_calender_rep', $js);
            ?>

            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'datepicker-Inline',
                'flat' => true, //remove to hide the datepicker
                'options' => array(
                    'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                    'beforeShowDay' => 'js:EventHighlight',
                    'onSelect' => 'js:EventRedirect',
                // 'stepMonths' => 0,
                ),
                'htmlOptions' => array(
                    'style' => ''
                ),
            ));
            ?>
            <?php
            //Upcoming events display 
            $now = date("Y-m-d", time());
            $cLang = strtoupper(Yii::app()->language);

            $criteria = new CDbCriteria;
            $criteria->addCondition("DATE_AJOUT1 > '" . $now . "'");
            $criteria->addCondition("LANGUE = '" . $cLang . "'");
            $criteria->order = 'DATE_AJOUT1 ASC';
            $criteria->limit = 3;
            $upcoming_events = CalenderEvent::model()->findAll($criteria);
            ?>
            <h4 class="eventList"><?php echo Myclass::t('OGO167', '', 'og'); ?></h4>
            <?php
            if (!empty($upcoming_events)) {
                ?>    
                <ul class="eventList">
                    <?php
                    foreach ($upcoming_events as $einfo) {
                        ?>   
                        <li class="li-1">
                            <span class="date start"><?php echo date("F d Y", strtotime($einfo->DATE_AJOUT1)); ?></span>
                            <?php echo CHtml::link($einfo->TITRE, array('/optiguide/calenderEvent/view', 'id' => $einfo->ID_EVENEMENT)); ?> 
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            <?php
            } else {
                echo Myclass::t('OGO165', '', 'og');
            }
            ?> 
        </div>
<!--         <div class="viewall"><?php //echo CHtml::link('View All', array('/optirep/calenderEvent'));  ?></div>-->
    </div>

</div>
