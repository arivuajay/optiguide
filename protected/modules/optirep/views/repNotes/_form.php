<?php
/* @var $this RepNotesController */
/* @var $model RepNotes */
/* @var $form CActiveForm */
?>
<div class="cate-bg user-right">
    <h2> <?php echo $model->isNewRecord ? 'Add Note' : 'Update Note'; ?></h2>
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
                <small><b>NOTE:</b> If you choose any date in the above field, you will get the reminder email in that particular date.</small>
            </div>
        </div>        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), 'Save');

            echo CHtml::link('Back', '/optirep/repNotes/index', array('class' => 'back'))
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
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