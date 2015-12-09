<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-calendar"></i>  <?php echo Myclass::t('OG020', '', 'og') ?> </div>
    </div>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optirep/calenderEvent/index'),
        'htmlOptions' => array('role' => 'form')
    ));

    $country = Myclass::getallcountries();
    $regions = Myclass::getallregions($searchModel['ID_PAYS']);
    $cities = Myclass::getallcities($searchModel['ID_REGION']);
    $months = Myclass::getMonths();
    $connection = Yii::app()->db;
    $year_command = $connection->createCommand('SELECT ID_EVENEMENT, YEAR(DATE_AJOUT1) AS event_year FROM calendrier_calendrier GROUP BY YEAR(`DATE_AJOUT1`)');
    $years = $year_command->queryAll();
    $list_year = CHtml::listData($years, 'event_year', 'event_year');
    ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'TITRE', array('class' => 'txtfield', 'placeholder' => Myclass::t('OG209'))); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_PAYS', $country, array('class' => 'selectpicker', 'empty' => Myclass::t('OG202'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_REGION', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('OG203'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo $form->dropDownList($searchModel, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('OG204'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 "> 
        <?php echo $form->dropDownList($searchModel, 'EVENT_MONTH', $months, array('class' => 'selectpicker', 'empty' => Myclass::t('OG022', '', 'og'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 ">   
        <?php echo $form->dropDownList($searchModel, 'EVENT_YEAR', $list_year, array('class' => 'selectpicker', 'empty' => Myclass::t('OG023', '', 'og'))); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OG024', '', 'og'), array('class' => 'find-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optirep/calenderEvent/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optirep/calenderEvent/getcities');
$js = <<< EOD
    $(document).ready(function(){
    $("#CalenderEvent_ID_PAYS").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id +'&search=yes';;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#CalenderEvent_ID_REGION").html(html).selectpicker('refresh');
            }
         });
    });
   
   $("#CalenderEvent_ID_REGION").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id +'&search=yes';;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#CalenderEvent_ID_VILLE").html(html).selectpicker('refresh');
            }
         });

    });
});
EOD;
Yii::app()->clientScript->registerScript('index', $js);
?>