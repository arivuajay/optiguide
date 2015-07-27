<?php
/* @var $this CalendarEventsController */
/* @var $model CalendarEvents */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_EVENEMENT'); ?>
		<?php echo $form->textField($model,'ID_EVENEMENT',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LANGUE'); ?>
		<?php echo $form->textField($model,'LANGUE',array('class'=>'form-control','size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_AJOUT1'); ?>
		<?php echo $form->textField($model,'DATE_AJOUT1',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_AJOUT2'); ?>
		<?php echo $form->textField($model,'DATE_AJOUT2',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE'); ?>
		<?php echo $form->textField($model,'TITRE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
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

	<div class="row">
		<?php echo $form->label($model,'AFFICHER_ACCUEIL'); ?>
		<?php echo $form->textField($model,'AFFICHER_ACCUEIL',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AFFICHER_ARCHIVE'); ?>
		<?php echo $form->textField($model,'AFFICHER_ARCHIVE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_PAYS'); ?>
		<?php echo $form->textField($model,'ID_PAYS',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_REGION'); ?>
		<?php echo $form->textField($model,'ID_REGION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_VILLE'); ?>
		<?php echo $form->textField($model,'ID_VILLE',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->