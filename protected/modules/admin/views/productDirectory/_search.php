<?php
/* @var $this ProductDirectoryController */
/* @var $model ProductDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_PRODUIT'); ?>
		<?php echo $form->textField($model,'ID_PRODUIT',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_SECTION'); ?>
		<?php echo $form->textField($model,'ID_SECTION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_PRODUIT_FR'); ?>
		<?php echo $form->textField($model,'NOM_PRODUIT_FR',array('class'=>'form-control','size'=>60,'maxlength'=>70)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NOM_PRODUIT_EN'); ?>
		<?php echo $form->textField($model,'NOM_PRODUIT_EN',array('class'=>'form-control','size'=>60,'maxlength'=>70)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->