<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_VILLE'); ?>
		<?php echo $form->textField($model,'ID_VILLE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_REGION'); ?>
		<?php echo $form->textField($model,'ID_REGION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_VILLE'); ?>
		<?php echo $form->textField($model,'NOM_VILLE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->