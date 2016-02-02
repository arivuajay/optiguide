<div class="optinews-left" id="calendar"> 
    <div class="optinews-left-heading"> <?php echo Myclass::t('OG017', '', 'og') ?> </div>
    <div class="optinews-left-bg"> 
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
                    'Url' => Yii::app()->createAbsoluteUrl('/optiguide/calenderEvent/index', array('date' => $betweenDate)),
                   // 'Date' => strtotime($betweenDate),
                    'Date' => $caldisp
                );
            }
        }
        $list = json_encode($events_list);

        $js = <<< EOD
            var events = $list;
                
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
        Yii::app()->clientScript->registerScript('_ogCalenderWidget', $js);
        ?>

        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'datepicker-Inline-sidebar',
            'flat' => true, //remove to hide the datepicker
            'options' => array(
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'beforeShowDay' => 'js:EventHighlight',
                'onSelect' => 'js:EventRedirect',
                //'stepMonths' => 0,
            ),
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>
        <?php
        //Upcoming events display 
        $now = date("Y-m-d",time());
        $cLang = strtoupper(Yii::app()->language);   
        
        $criteria = new CDbCriteria;
        $criteria->addCondition("DATE_AJOUT1 > '".$now."'");
        $criteria->addCondition("LANGUE = '".$cLang."'");
        $criteria->order = 'DATE_AJOUT1 ASC';
        $criteria->limit = 3;
        $upcoming_events = CalenderEvent::model()->findAll($criteria);
        ?>
        <h4 class="eventList"><?php echo Myclass::t('OGO167','','og');?></h4>
        <?php
        if(!empty($upcoming_events))
        { ?>    
        <ul class="eventList">
           <?php if(Yii::app()->language == "fr"){ 
                foreach($upcoming_events as $einfo)
                {?>   
                 <li class="li-1">
                     <span class="date start"><?php $m= date("n", strtotime($einfo->DATE_AJOUT1));
                     $month = Myclass::getMonths_Fr($m);
                     echo date("d ",strtotime($einfo->DATE_AJOUT1)).$month.date(" Y",strtotime($einfo->DATE_AJOUT1)); ?></span>
                    <?php echo CHtml::link($einfo->TITRE, array('/optiguide/calenderEvent/view', 'id' => $einfo->ID_EVENEMENT));?> 
                 </li>
                <?php
                }
           }else{
               foreach($upcoming_events as $einfo)
                {?>   
                 <li class="li-1">
                     <span class="date start"><?php 
                     echo date("F d Y",strtotime($einfo->DATE_AJOUT1)); ?></span>
                    <?php echo CHtml::link($einfo->TITRE, array('/optiguide/calenderEvent/view', 'id' => $einfo->ID_EVENEMENT));?> 
                 </li>
                <?php
                }
           }
           ?>
        </ul>
        <?php }else{
            echo Myclass::t('OGO165','','og');
        }  ?> 
       <?php echo CHtml::link(Myclass::t('OGO166', '', 'og'), array('/optiguide/calenderEvent')); ?>
    </div>
</div>