<?php
/* @var $this ManagementAdviceController */
/* @var $model ManagementAdvice */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_CONSEIL'); ?>
		<?php echo $form->textField($model,'ID_CONSEIL',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LANGUE'); ?>
		<?php echo $form->textField($model,'LANGUE',array('class'=>'form-control','size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE'); ?>
		<?php echo $form->textField($model,'TITRE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SYNOPSYS'); ?>
		<?php echo $form->textField($model,'SYNOPSYS',array('class'=>'form-control','size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TEXTE'); ?>
		<?php echo $form->textField($model,'TEXTE',array('class'=>'form-control','size'=>60,'maxlength'=>5000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LIEN_URL'); ?>
		<?php echo $form->textField($model,'LIEN_URL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LIEN_TITRE'); ?>
		<?php echo $form->textField($model,'LIEN_TITRE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AFFICHER_SITE'); ?>
		<?php echo $form->textField($model,'AFFICHER_SITE',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->