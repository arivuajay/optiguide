<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading cate-heading3"> <i class="fa fa-calendar"></i> Calendar  </div>
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
        </div>
         <div class="viewall"><?php echo CHtml::link('View All', array('/optirep/calenderEvent')); ?></div>
    </div>
    
</div>
