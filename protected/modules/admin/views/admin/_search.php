<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'admin_id'); ?>
		<?php echo $form->textField($model,'admin_id',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_name'); ?>
		<?php echo $form->textField($model,'admin_name',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_username'); ?>
		<?php echo $form->textField($model,'admin_username',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_status'); ?>
		<?php echo $form->textField($model,'admin_status',array('class'=>'form-control','size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_email'); ?>
		<?php echo $form->textField($model,'admin_email',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_last_login'); ?>
		<?php echo $form->textField($model,'admin_last_login',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_login_ip'); ?>
		<?php echo $form->textField($model,'admin_login_ip',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role'); ?>
		<?php echo $form->textField($model,'role',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->