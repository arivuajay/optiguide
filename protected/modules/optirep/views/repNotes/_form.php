<?php
/* @var $this RepNotesController */
/* @var $model RepNotes */
/* @var $form CActiveForm */
?>
<div class="cate-bg user-right">
    <h2> <?php echo $model->isNewRecord ? 'Add Note' : 'Update Note';?></h2>
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
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'message'); ?>
                 <?php echo $form->textArea($model, 'message', array( 'rows' => 5, 'cols' => 50)); ?>               
            </div>        
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), 'Save');
                ?>
            </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

