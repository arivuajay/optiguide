<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID_PUBLICITE'); ?>
		<?php echo $form->textField($model,'ID_PUBLICITE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NO_PUB'); ?>
		<?php echo $form->textField($model,'NO_PUB',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LANGUE'); ?>
		<?php echo $form->textField($model,'LANGUE',array('class'=>'form-control','size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TITRE'); ?>
		<?php echo $form->textField($model,'TITRE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_DEBUT'); ?>
		<?php echo $form->textField($model,'DATE_DEBUT',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_FIN'); ?>
		<?php echo $form->textField($model,'DATE_FIN',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_FICHIER'); ?>
		<?php echo $form->textField($model,'ID_FICHIER',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LIEN_URL'); ?>
		<?php echo $form->textField($model,'LIEN_URL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MOTS_CLES_RECHERCHE'); ?>
		<?php echo $form->textField($model,'MOTS_CLES_RECHERCHE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NB_IMPRESSIONS_FAITES'); ?>
		<?php echo $form->textField($model,'NB_IMPRESSIONS_FAITES',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NB_IMPRESSIONS'); ?>
		<?php echo $form->textField($model,'NB_IMPRESSIONS',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PRIORITE'); ?>
		<?php echo $form->textField($model,'PRIORITE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PRIX'); ?>
		<?php echo $form->textField($model,'PRIX',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PAYE'); ?>
		<?php echo $form->textField($model,'PAYE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CLIENT'); ?>
		<?php echo $form->textField($model,'CLIENT',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ZONE_AFFICHAGE'); ?>
		<?php echo $form->textField($model,'ZONE_AFFICHAGE',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ID_POSITION'); ?>
		<?php echo $form->textField($model,'ID_POSITION',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AFFICHER_ACCUEIL'); ?>
		<?php echo $form->textField($model,'AFFICHER_ACCUEIL',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DATE_AJOUT'); ?>
		<?php echo $form->textField($model,'DATE_AJOUT',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ACCUEIL_SECTION'); ?>
		<?php echo $form->textField($model,'ACCUEIL_SECTION',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->