<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading cate-heading3"> 
            <i class="fa fa-calendar"></i> 
            <?php
            //echo Myclass::t('OR518', '', 'or');
            echo CHtml::link(Myclass::t('OR518', '', 'or'), array('/optirep/calenderEvent'), array('class' => ''));
            echo CHtml::link(Myclass::t('OR038', '', 'or'), array('/optirep/calenderEvent'), array('class' => 'topviewall'));
            ?> 
        </div>
        <div class="calc-cont"> 
            <?php
            $events = CalenderEvent::model()->currentMonthYear()->findAll();
            $events_list = array();
            foreach ($events as $event) {
                $start_date = date("Y-m-d", strtotime($event['DATE_AJOUT1']));
                $end_date = date("Y-m-d", strtotime($event['DATE_AJOUT2']));
                $betweenDates = Myclass::getBetweenDates($start_date, $end_date);
                foreach ($betweenDates as $betweenDate) {
                    $caldisp = date("m/d/Y", strtotime($betweenDate));
                    $events_list[] = array(
                        'Url' => Yii::app()->createAbsoluteUrl('/optirep/calenderEvent/index', array('date' => $betweenDate)),
                         // 'Date' => strtotime($betweenDate),
                        'Date' => $caldisp
                    );
                }
            }

            $list = json_encode($events_list);

            $js = <<< EOD
            var events = {$list};
                
            function EventHighlight(date) {
                var result = [true, '', null];
                var matching = $.grep(events, function(event) {
                    //return event.Date == date.valueOf() / 1000;
                    return event.Date == $.datepicker.formatDate("mm/dd/yy", date );
                });

                if (matching.length) {
                    result = [true, 'event', null];
                }
                return result;
            }

            function EventRedirect(dateText){
                for (var k in events) 
                {                    
                 if( events[k].Date == dateText) 
                 {   
                   window.location = events[k].Url;
                 }                       
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
            <h4 class="eventList">
                <?php echo Myclass::t('OR519', '', 'or'); ?>
            </h4>
            <?php
            if (!empty($upcoming_events)) {
                ?>    
                <ul class="eventList">
                    <?php
                    foreach ($upcoming_events as $einfo) {
                        ?>   
                        <li class="li-1">
                            <span class="date start">
                            <?php 
                            if (Yii::app()->session['language'] == 'FR') { 
                                        $time = strtotime($einfo->DATE_AJOUT1);
                                        $m= date("n", $time);
                                        $month = Myclass::getMonths_Fr($m);
                                        $year = date("d Y", $time);
                                        $res= $month.' '.$year;
                                }else{
                                        $time = strtotime($einfo->DATE_AJOUT1);
                                        $month = date("F", $time);
                                        $year = date("d Y", $time);
                                        $res= $month.' '.$year;
                                }
                                echo $res;
                            ?></span>
                            <?php echo CHtml::link($einfo->TITRE, array('/optirep/calenderEvent/view', 'id' => $einfo->ID_EVENEMENT)); ?> 
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            } else {
                echo Myclass::t('OR520', '', 'or');
            }
            ?> 
        </div>
    </div>

</div>
