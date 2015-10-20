<?php
/* @var $this RepNotesController */
/* @var $model RepNotes */
/* @var $form CActiveForm */
?>
<div class="cate-bg user-right">
    <h2> <?php echo $model->isNewRecord ? Myclass::t('OR567', '', 'or') : Myclass::t('OR568', '', 'or') ; ?> </h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rep-notes-form',
        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        )
    ));
    echo $form->errorSummary(array($model));
    ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $form->labelEx($model, 'message'); ?>
            <?php echo $form->textArea($model, 'message', array("class" => "form-field-textarea")); ?>               
        </div>        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $form->labelEx($model, 'alert_date'); ?>
            <div id="reminder_datepicker" class="input-append date">
                <?php echo $form->textField($model, 'alert_date', array("class" => "form-field")); ?>
                <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                <small>
                    <b><?php echo Myclass::t('OR569', '', 'or') ?> : </b> 
                    <?php echo Myclass::t('OR570', '', 'or') ?>
                </small>
            </div>
        </div>        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), Myclass::t('APP25'));

            echo CHtml::link(Myclass::t('OR571', '', 'or'), '/optirep/repNotes/index', array('class' => 'back'))
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerCssFile($themeUrl . '/css/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/bootstrap-datepicker.js', $cs_pos_end);

$js = <<< EOD
$(document).ready(function(){
    $('#reminder_datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '+1d'
    });
});
EOD;
Yii::app()->clientScript->registerScript('_form_notes', $js);
?>