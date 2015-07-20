<?php
/* @var $this RetailerDirectoryController */
/* @var $model RetailerDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_RETAILER'); ?>
		<?php echo $form->textField($model,'ID_RETAILER',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_CLIENT'); ?>
		<?php echo $form->textField($model,'ID_CLIENT',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COMPAGNIE'); ?>
		<?php echo $form->textField($model,'COMPAGNIE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_VILLE'); ?>
		<?php echo $form->textField($model,'ID_VILLE',array('class'=>'form-control')); ?>
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
		<?php echo $form->label($model,'URL'); ?>
		<?php echo $form->textField($model,'URL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COURRIEL'); ?>
		<?php echo $form->textField($model,'COURRIEL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TEL_1800'); ?>
		<?php echo $form->textField($model,'TEL_1800',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_MODIFICATION'); ?>
		<?php echo $form->textField($model,'DATE_MODIFICATION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_RETAILER_TYPE'); ?>
		<?php echo $form->textField($model,'ID_RETAILER_TYPE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_GROUPE'); ?>
		<?php echo $form->textField($model,'ID_GROUPE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GROUPE'); ?>
		<?php echo $form->textField($model,'GROUPE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HEAD_OFFICE_NAME'); ?>
		<?php echo $form->textField($model,'HEAD_OFFICE_NAME',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CATEGORY_1'); ?>
		<?php echo $form->textField($model,'CATEGORY_1',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CATEGORY_2'); ?>
		<?php echo $form->textField($model,'CATEGORY_2',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CATEGORY_3'); ?>
		<?php echo $form->textField($model,'CATEGORY_3',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CATEGORY_4'); ?>
		<?php echo $form->textField($model,'CATEGORY_4',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CATEGORY_5'); ?>
		<?php echo $form->textField($model,'CATEGORY_5',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->