<?php
/* @var $this SuppliersDirectoryController */
/* @var $data SuppliersDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_FOURNISSEUR')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_FOURNISSEUR), array('view', 'id'=>$data->ID_FOURNISSEUR)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COMPAGNIE')); ?>:</b>
	<?php echo CHtml::encode($data->COMPAGNIE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CLIENT')); ?>:</b>
	<?php echo CHtml::encode($data->ID_CLIENT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_TYPE_FOURNISSEUR')); ?>:</b>
	<?php echo CHtml::encode($data->ID_TYPE_FOURNISSEUR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ADRESSE')); ?>:</b>
	<?php echo CHtml::encode($data->ADRESSE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ADRESSE2')); ?>:</b>
	<?php echo CHtml::encode($data->ADRESSE2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_VILLE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_VILLE); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('CODE_POSTAL')); ?>:</b>
	<?php echo CHtml::encode($data->CODE_POSTAL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELEPHONE')); ?>:</b>
	<?php echo CHtml::encode($data->TELEPHONE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELECOPIEUR')); ?>:</b>
	<?php echo CHtml::encode($data->TELECOPIEUR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_TEL_SANS_FRAIS')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_TEL_SANS_FRAIS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_TEL_SANS_FRAIS_EN')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_TEL_SANS_FRAIS_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEL_SANS_FRAIS')); ?>:</b>
	<?php echo CHtml::encode($data->TEL_SANS_FRAIS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_TEL_SECONDAIRE')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_TEL_SECONDAIRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE_TEL_SECONDAIRE_EN')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE_TEL_SECONDAIRE_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEL_SECONDAIRE')); ?>:</b>
	<?php echo CHtml::encode($data->TEL_SECONDAIRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COURRIEL')); ?>:</b>
	<?php echo CHtml::encode($data->COURRIEL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SITE_WEB')); ?>:</b>
	<?php echo CHtml::encode($data->SITE_WEB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SUCCURSALES')); ?>:</b>
	<?php echo CHtml::encode($data->SUCCURSALES); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ETABLI_DEPUIS')); ?>:</b>
	<?php echo CHtml::encode($data->ETABLI_DEPUIS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NB_EMPLOYES')); ?>:</b>
	<?php echo CHtml::encode($data->NB_EMPLOYES); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_NOM1')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_NOM1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_TITRE1')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_TITRE1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_TITRE1_EN')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_TITRE1_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_NOM2')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_NOM2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_TITRE2')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_TITRE2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_TITRE2_EN')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_TITRE2_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_NOM3')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_NOM3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_TITRE3')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_TITRE3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PERSONNEL_TITRE3_EN')); ?>:</b>
	<?php echo CHtml::encode($data->PERSONNEL_TITRE3_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_MODIFICATION')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_MODIFICATION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('REGIONS_FR')); ?>:</b>
	<?php echo CHtml::encode($data->REGIONS_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('REGIONS_EN')); ?>:</b>
	<?php echo CHtml::encode($data->REGIONS_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bAfficher_site')); ?>:</b>
	<?php echo CHtml::encode($data->bAfficher_site); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iId_fichier')); ?>:</b>
	<?php echo CHtml::encode($data->iId_fichier); ?>
	<br />

	*/ ?>

</div>