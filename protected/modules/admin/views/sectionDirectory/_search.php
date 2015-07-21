<?php
/* @var $this SectionDirectoryController */
/* @var $model SectionDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_SECTION'); ?>
		<?php echo $form->textField($model,'ID_SECTION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_SECTION_FR'); ?>
		<?php echo $form->textField($model,'NOM_SECTION_FR',array('class'=>'form-control','size'=>60,'maxlength'=>70)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_SECTION_EN'); ?>
		<?php echo $form->textField($model,'NOM_SECTION_EN',array('class'=>'form-control','size'=>60,'maxlength'=>70)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->