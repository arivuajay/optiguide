<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'message_id'); ?>
		<?php echo $form->textField($model,'message_id',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'client_id'); ?>
		<?php echo $form->textField($model,'client_id',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_id'); ?>
		<?php echo $form->textField($model,'employee_id',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_remember'); ?>
		<?php echo $form->textField($model,'date_remember',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_view_status'); ?>
		<?php echo $form->textField($model,'user_view_status',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mail_sent_counts'); ?>
		<?php echo $form->textField($model,'mail_sent_counts',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->