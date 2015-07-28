<?php
/* @var $this ArchiveFichierController */
/* @var $model ArchiveFichier */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_FICHIER'); ?>
		<?php echo $form->textField($model,'ID_FICHIER',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_CATEGORIE'); ?>
		<?php echo $form->textField($model,'ID_CATEGORIE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FICHIER'); ?>
		<?php echo $form->textField($model,'FICHIER',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE_FICHIER_FR'); ?>
		<?php echo $form->textField($model,'TITRE_FICHIER_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE_FICHIER_EN'); ?>
		<?php echo $form->textField($model,'TITRE_FICHIER_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MOTS_CLE'); ?>
		<?php echo $form->textField($model,'MOTS_CLE',array('class'=>'form-control','size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'EXTENSION'); ?>
		<?php echo $form->textField($model,'EXTENSION',array('class'=>'form-control','size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_DEPOT'); ?>
		<?php echo $form->textField($model,'DATE_DEPOT',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DISPONIBLE'); ?>
		<?php echo $form->textField($model,'DISPONIBLE',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->