<?php
/* @var $this RegionDirectoryController */
/* @var $model RegionDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_REGION'); ?>
		<?php echo $form->textField($model,'ID_REGION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_PAYS'); ?>
		<?php echo $form->textField($model,'ID_PAYS',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_REGION_FR'); ?>
		<?php echo $form->textField($model,'NOM_REGION_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_REGION_EN'); ?>
		<?php echo $form->textField($model,'NOM_REGION_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ABREVIATION_FR'); ?>
		<?php echo $form->textField($model,'ABREVIATION_FR',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ABREVIATION_EN'); ?>
		<?php echo $form->textField($model,'ABREVIATION_EN',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->