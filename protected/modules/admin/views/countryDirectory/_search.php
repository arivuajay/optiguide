<?php
/* @var $this CountryDirectoryController */
/* @var $model CountryDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_PAYS'); ?>
		<?php echo $form->textField($model,'ID_PAYS',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_PAYS_FR'); ?>
		<?php echo $form->textField($model,'NOM_PAYS_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_PAYS_EN'); ?>
		<?php echo $form->textField($model,'NOM_PAYS_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->