<?php
/* @var $this ArchiveFichierController */
/* @var $data ArchiveFichier */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_FICHIER')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_FICHIER), array('view', 'id'=>$data->ID_FICHIER)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CATEGORIE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_CATEGORIE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FICHIER')); ?>:</b>
	<?php echo CHtml::encode($data->FICHIER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_FICHIER_FR')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_FICHIER_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_FICHIER_EN')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_FICHIER_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MOTS_CLE')); ?>:</b>
	<?php echo CHtml::encode($data->MOTS_CLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EXTENSION')); ?>:</b>
	<?php echo CHtml::encode($data->EXTENSION); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_DEPOT')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_DEPOT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DISPONIBLE')); ?>:</b>
	<?php echo CHtml::encode($data->DISPONIBLE); ?>
	<br />

	*/ ?>

</div>