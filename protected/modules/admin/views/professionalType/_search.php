<?php
/* @var $this ProfessionalTypeController */
/* @var $model ProfessionalType */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_TYPE_SPECIALISTE'); ?>
		<?php echo $form->textField($model,'ID_TYPE_SPECIALISTE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TYPE_SPECIALISTE_FR'); ?>
		<?php echo $form->textField($model,'TYPE_SPECIALISTE_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TYPE_SPECIALISTE_EN'); ?>
		<?php echo $form->textField($model,'TYPE_SPECIALISTE_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'iOrder'); ?>
		<?php echo $form->textField($model,'iOrder',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->