<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_FOURNISSEUR'); ?>
		<?php echo $form->textField($model,'ID_FOURNISSEUR',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'COMPAGNIE'); ?>
		<?php echo $form->textField($model,'COMPAGNIE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_CLIENT'); ?>
		<?php echo $form->textField($model,'ID_CLIENT',array('class'=>'form-control','size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_TYPE_FOURNISSEUR'); ?>
		<?php echo $form->textField($model,'ID_TYPE_FOURNISSEUR',array('class'=>'form-control')); ?>
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
		<?php echo $form->label($model,'TITRE_TEL_SANS_FRAIS'); ?>
		<?php echo $form->textField($model,'TITRE_TEL_SANS_FRAIS',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE_TEL_SANS_FRAIS_EN'); ?>
		<?php echo $form->textField($model,'TITRE_TEL_SANS_FRAIS_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TEL_SANS_FRAIS'); ?>
		<?php echo $form->textField($model,'TEL_SANS_FRAIS',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE_TEL_SECONDAIRE'); ?>
		<?php echo $form->textField($model,'TITRE_TEL_SECONDAIRE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE_TEL_SECONDAIRE_EN'); ?>
		<?php echo $form->textField($model,'TITRE_TEL_SECONDAIRE_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TEL_SECONDAIRE'); ?>
		<?php echo $form->textField($model,'TEL_SECONDAIRE',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
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
		<?php echo $form->label($model,'SUCCURSALES'); ?>
		<?php echo $form->textField($model,'SUCCURSALES',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ETABLI_DEPUIS'); ?>
		<?php echo $form->textField($model,'ETABLI_DEPUIS',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NB_EMPLOYES'); ?>
		<?php echo $form->textField($model,'NB_EMPLOYES',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_NOM1'); ?>
		<?php echo $form->textField($model,'PERSONNEL_NOM1',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_TITRE1'); ?>
		<?php echo $form->textField($model,'PERSONNEL_TITRE1',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_TITRE1_EN'); ?>
		<?php echo $form->textField($model,'PERSONNEL_TITRE1_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_NOM2'); ?>
		<?php echo $form->textField($model,'PERSONNEL_NOM2',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_TITRE2'); ?>
		<?php echo $form->textField($model,'PERSONNEL_TITRE2',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_TITRE2_EN'); ?>
		<?php echo $form->textField($model,'PERSONNEL_TITRE2_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_NOM3'); ?>
		<?php echo $form->textField($model,'PERSONNEL_NOM3',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_TITRE3'); ?>
		<?php echo $form->textField($model,'PERSONNEL_TITRE3',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PERSONNEL_TITRE3_EN'); ?>
		<?php echo $form->textField($model,'PERSONNEL_TITRE3_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_MODIFICATION'); ?>
		<?php echo $form->textField($model,'DATE_MODIFICATION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'REGIONS_FR'); ?>
		<?php echo $form->textField($model,'REGIONS_FR',array('class'=>'form-control','size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'REGIONS_EN'); ?>
		<?php echo $form->textField($model,'REGIONS_EN',array('class'=>'form-control','size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bAfficher_site'); ?>
		<?php echo $form->textField($model,'bAfficher_site',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'iId_fichier'); ?>
		<?php echo $form->textField($model,'iId_fichier',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->