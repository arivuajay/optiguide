<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_UTILISATEUR'); ?>
		<?php echo $form->textField($model,'ID_UTILISATEUR',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LANGUE'); ?>
		<?php echo $form->textField($model,'LANGUE',array('class'=>'form-control','size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PREFIXE'); ?>
		<?php echo $form->textField($model,'PREFIXE',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_UTILISATEUR'); ?>
		<?php echo $form->textField($model,'NOM_UTILISATEUR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'USR'); ?>
		<?php echo $form->textField($model,'USR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PWD'); ?>
		<?php echo $form->textField($model,'PWD',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COURRIEL'); ?>
		<?php echo $form->textField($model,'COURRIEL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ABONNE_MAILING'); ?>
		<?php echo $form->textField($model,'ABONNE_MAILING',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ABONNE_PROMOTION'); ?>
		<?php echo $form->textField($model,'ABONNE_PROMOTION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ABONNE_TRANSITION'); ?>
		<?php echo $form->textField($model,'ABONNE_TRANSITION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IS_FIRST_LOG'); ?>
		<?php echo $form->textField($model,'IS_FIRST_LOG',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_TABLE'); ?>
		<?php echo $form->textField($model,'NOM_TABLE',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_RELATION'); ?>
		<?php echo $form->textField($model,'ID_RELATION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MUST_VALIDATE'); ?>
		<?php echo $form->textField($model,'MUST_VALIDATE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sGuid'); ?>
		<?php echo $form->textField($model,'sGuid',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bSubscription_envision'); ?>
		<?php echo $form->textField($model,'bSubscription_envision',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bSubscription_envue'); ?>
		<?php echo $form->textField($model,'bSubscription_envue',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->