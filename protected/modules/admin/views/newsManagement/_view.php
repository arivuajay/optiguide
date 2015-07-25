<?php
/* @var $this NewsManagementController */
/* @var $data NewsManagement */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_NOUVELLE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_NOUVELLE), array('view', 'id'=>$data->ID_NOUVELLE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LANGUE')); ?>:</b>
	<?php echo CHtml::encode($data->LANGUE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SYNOPSYS')); ?>:</b>
	<?php echo CHtml::encode($data->SYNOPSYS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEXTE')); ?>:</b>
	<?php echo CHtml::encode($data->TEXTE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_FICHIER')); ?>:</b>
	<?php echo CHtml::encode($data->ID_FICHIER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LIEN_URL')); ?>:</b>
	<?php echo CHtml::encode($data->LIEN_URL); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('LIEN_TITRE')); ?>:</b>
	<?php echo CHtml::encode($data->LIEN_TITRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HIERARCHIE')); ?>:</b>
	<?php echo CHtml::encode($data->HIERARCHIE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_AJOUT1')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_AJOUT1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_SITE')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_SITE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_SECTION')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_SECTION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_ACCUEIL')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_ACCUEIL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_AJOUT2')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_AJOUT2); ?>
	<br />

	*/ ?>

</div>