<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_SPECIALISTE'); ?>
		<?php echo $form->textField($model,'ID_SPECIALISTE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_CLIENT'); ?>
		<?php echo $form->textField($model,'ID_CLIENT',array('class'=>'form-control','size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PREFIXE_FR'); ?>
		<?php echo $form->textField($model,'PREFIXE_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PREFIXE_EN'); ?>
		<?php echo $form->textField($model,'PREFIXE_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PRENOM'); ?>
		<?php echo $form->textField($model,'PRENOM',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM'); ?>
		<?php echo $form->textField($model,'NOM',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_TYPE_SPECIALISTE'); ?>
		<?php echo $form->textField($model,'ID_TYPE_SPECIALISTE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TYPE_AUTRE'); ?>
		<?php echo $form->textField($model,'TYPE_AUTRE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BUREAU'); ?>
		<?php echo $form->textField($model,'BUREAU',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ADRESSE'); ?>
		<?php echo $form->textField($model,'ADRESSE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ADRESSE2'); ?>
		<?php echo $form->textField($model,'ADRESSE2',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_VILLE'); ?>
		<?php echo $form->textField($model,'ID_VILLE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CODE_POSTAL'); ?>
		<?php echo $form->textField($model,'CODE_POSTAL',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TELEPHONE'); ?>
		<?php echo $form->textField($model,'TELEPHONE',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TELEPHONE2'); ?>
		<?php echo $form->textField($model,'TELEPHONE2',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TELECOPIEUR'); ?>
		<?php echo $form->textField($model,'TELECOPIEUR',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TELECOPIEUR2'); ?>
		<?php echo $form->textField($model,'TELECOPIEUR2',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SITE_WEB'); ?>
		<?php echo $form->textField($model,'SITE_WEB',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COURRIEL'); ?>
		<?php echo $form->textField($model,'COURRIEL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_MODIFICATION'); ?>
		<?php echo $form->textField($model,'DATE_MODIFICATION',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->