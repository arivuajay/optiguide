<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-search"></i> </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optirep/repNotes/index'),
        'htmlOptions' => array('role' => 'form')
    ));
    ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'utilisateur', array('class' => 'form-control', 'placeholder' => Myclass::t('OR572', '', 'or'))); ?>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
<!--        <div class="input-group">
                <input type="text" id="datepicker-my" class="form-control" placeholder="Select Date" />
                
                <span class="input-group-addon" id="btn" style="cursor:pointer;">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>-->
            <?php echo $form->textField($searchModel, 'alert_date', array('class' => 'form-control ', 'placeholder' => Myclass::t('OR574', '', 'or'))); ?> 
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OG024', '', 'og'), array('class' => 'find-btn1')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerCssFile($themeUrl . '/css/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/bootstrap-datepicker.js', $cs_pos_end);

$ajaxRegionUrl = Yii::app()->createUrl('/optirep/calenderEvent/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optirep/calenderEvent/getcities');
$js = <<< EOD
    $(document).ready(function(){
//       $('#btn').click(function(){
//            $(document).ready(function(){
//                $("#RepNotes_alert_date").datepicker({
//        dateFormat: 'yy-mm-dd'}).focus();
//            });
//        });
        
        $('#RepNotes_alert_date').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '+1d'
    });
        
    $("#ProfessionalDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id +'&search=yes';
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_region").html(html).selectpicker('refresh');
            }
         });
    });
            
   $("#ProfessionalDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id +'&search=yes';
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString+'&client_dis=1',
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_ID_VILLE").html(html).selectpicker('refresh');
            }
         });

    });
});
EOD;
Yii::app()->clientScript->registerScript('index', $js);
?>