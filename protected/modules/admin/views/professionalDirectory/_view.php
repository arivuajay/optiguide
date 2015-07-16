<?php
/* @var $this ProfessionalDirectoryController */
/* @var $data ProfessionalDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_SPECIALISTE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_SPECIALISTE), array('view', 'id'=>$data->ID_SPECIALISTE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CLIENT')); ?>:</b>
	<?php echo CHtml::encode($data->ID_CLIENT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PREFIXE_FR')); ?>:</b>
	<?php echo CHtml::encode($data->PREFIXE_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PREFIXE_EN')); ?>:</b>
	<?php echo CHtml::encode($data->PREFIXE_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRENOM')); ?>:</b>
	<?php echo CHtml::encode($data->PRENOM); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM')); ?>:</b>
	<?php echo CHtml::encode($data->NOM); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_TYPE_SPECIALISTE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_TYPE_SPECIALISTE); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('TYPE_AUTRE')); ?>:</b>
	<?php echo CHtml::encode($data->TYPE_AUTRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BUREAU')); ?>:</b>
	<?php echo CHtml::encode($data->BUREAU); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('CODE_POSTAL')); ?>:</b>
	<?php echo CHtml::encode($data->CODE_POSTAL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELEPHONE')); ?>:</b>
	<?php echo CHtml::encode($data->TELEPHONE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELEPHONE2')); ?>:</b>
	<?php echo CHtml::encode($data->TELEPHONE2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELECOPIEUR')); ?>:</b>
	<?php echo CHtml::encode($data->TELECOPIEUR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TELECOPIEUR2')); ?>:</b>
	<?php echo CHtml::encode($data->TELECOPIEUR2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SITE_WEB')); ?>:</b>
	<?php echo CHtml::encode($data->SITE_WEB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COURRIEL')); ?>:</b>
	<?php echo CHtml::encode($data->COURRIEL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_MODIFICATION')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_MODIFICATION); ?>
	<br />

	*/ ?>

</div>