<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_CATEGORIE'); ?>
		<?php echo $form->textField($model,'ID_CATEGORIE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_CATEGORIE_FR'); ?>
		<?php echo $form->textField($model,'NOM_CATEGORIE_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_CATEGORIE_EN'); ?>
		<?php echo $form->textField($model,'NOM_CATEGORIE_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->