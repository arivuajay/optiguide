<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_GROUPE'); ?>
		<?php echo $form->textField($model,'ID_GROUPE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_SECTION'); ?>
		<?php echo $form->textField($model,'ID_SECTION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_GROUPE'); ?>
		<?php echo $form->textField($model,'NOM_GROUPE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
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
		<?php echo $form->label($model,'TELECOPIEUR'); ?>
		<?php echo $form->textField($model,'TELECOPIEUR',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COURRIEL'); ?>
		<?php echo $form->textField($model,'COURRIEL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SITE_WEB'); ?>
		<?php echo $form->textField($model,'SITE_WEB',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PREFIXE_REPRESENTANT_FR'); ?>
		<?php echo $form->textField($model,'PREFIXE_REPRESENTANT_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PREFIXE_REPRESENTANT_EN'); ?>
		<?php echo $form->textField($model,'PREFIXE_REPRESENTANT_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_REPRESENTANT'); ?>
		<?php echo $form->textField($model,'NOM_REPRESENTANT',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE_REPRESENTANT_FR'); ?>
		<?php echo $form->textField($model,'TITRE_REPRESENTANT_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE_REPRESENTANT_EN'); ?>
		<?php echo $form->textField($model,'TITRE_REPRESENTANT_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->