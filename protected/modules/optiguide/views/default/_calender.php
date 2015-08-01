<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="calendar-bg"> 
        <h2> Calendar </h2>
        <?php
        $events = CalenderEvent::model()->currentMonthYear()->findAll();
        $events_list = array();
        foreach ($events as $event) {
            $start_date = date("Y-m-d", strtotime($event['DATE_AJOUT1']));
            $end_date = date("Y-m-d", strtotime($event['DATE_AJOUT2']));
            $betweenDates = Myclass::getBetweenDates($start_date, $end_date);
            foreach ($betweenDates as $betweenDate) {
                $events_list[] = array(
                    'Url' => Yii::app()->createAbsoluteUrl('/optiguide/calenderEvent/index', array('date' => $betweenDate)),
                    'Date' => strtotime($betweenDate),
                );
            }
        }
        $list = json_encode($events_list);

        $js = <<< EOD
            var events = $list;
                
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
        Yii::app()->clientScript->registerScript('_calender', $js);
        ?>
        
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'datepicker-Inline',
            'flat' => true, //remove to hide the datepicker
            'options' => array(
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'beforeShowDay' => 'js:EventHighlight',
                'onSelect' => 'js:EventRedirect',
                'stepMonths' => 0,
            ),
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>
        <?php // echo CHtml::image("{$this->themeUrl}/images/calendar-img.jpg", 'Logo', array('width' => 337, 'height' => 256)) ?>
    </div>
</div>

<style>
    .event a {
        background-color: #42B373 !important;
        background-image :none !important;
        color: #ffffff !important;
    }
</style>