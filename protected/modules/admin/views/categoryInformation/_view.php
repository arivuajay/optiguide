<?php
/* @var $this CategoryInformationController */
/* @var $data CategoryInformation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CATEGORIE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_CATEGORIE), array('view', 'id'=>$data->ID_CATEGORIE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORIE_FR')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORIE_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORIE_EN')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORIE_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_ASSOCIATION_FR')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_ASSOCIATION_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_ASSOCIATION_EN')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_ASSOCIATION_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ADRESSE')); ?>:</b>
	<?php echo CHtml::encode($data->ADRESSE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ADRESSE2')); ?>:</b>
	<?php echo CHtml::encode($data->ADRESSE2); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_VILLE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_VILLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CODE_POSTAL')); ?>:</b>
	<?php echo CHtml::encode($data->CODE_POSTAL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELEPHONE')); ?>:</b>
	<?php echo CHtml::encode($data->TELEPHONE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELECOPIEUR')); ?>:</b>
	<?php echo CHtml::encode($data->TELECOPIEUR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEL_SANS_FRAIS')); ?>:</b>
	<?php echo CHtml::encode($data->TEL_SANS_FRAIS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COURRIEL')); ?>:</b>
	<?php echo CHtml::encode($data->COURRIEL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SITE_WEB')); ?>:</b>
	<?php echo CHtml::encode($data->SITE_WEB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PREFIXE_REPRESENTANT_FR')); ?>:</b>
	<?php echo CHtml::encode($data->PREFIXE_REPRESENTANT_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PREFIXE_REPRESENTANT_EN')); ?>:</b>
	<?php echo CHtml::encode($data->PREFIXE_REPRESENTANT_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_REPRESENTANT')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_REPRESENTANT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_REPRESENTANT_FR')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_REPRESENTANT_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_REPRESENTANT_EN')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_REPRESENTANT_EN); ?>
	<br />

	*/ ?>

</div>