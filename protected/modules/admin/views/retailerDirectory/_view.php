<?php
/* @var $this RetailerDirectoryController */
/* @var $data RetailerDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_RETAILER')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_RETAILER), array('view', 'id'=>$data->ID_RETAILER)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CLIENT')); ?>:</b>
	<?php echo CHtml::encode($data->ID_CLIENT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COMPAGNIE')); ?>:</b>
	<?php echo CHtml::encode($data->COMPAGNIE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_VILLE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_VILLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ADRESSE')); ?>:</b>
	<?php echo CHtml::encode($data->ADRESSE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ADRESSE2')); ?>:</b>
	<?php echo CHtml::encode($data->ADRESSE2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CODE_POSTAL')); ?>:</b>
	<?php echo CHtml::encode($data->CODE_POSTAL); ?>
	<br />

	<?php /*
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('URL')); ?>:</b>
	<?php echo CHtml::encode($data->URL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COURRIEL')); ?>:</b>
	<?php echo CHtml::encode($data->COURRIEL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEL_1800')); ?>:</b>
	<?php echo CHtml::encode($data->TEL_1800); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_MODIFICATION')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_MODIFICATION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_RETAILER_TYPE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_RETAILER_TYPE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_GROUPE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_GROUPE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GROUPE')); ?>:</b>
	<?php echo CHtml::encode($data->GROUPE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HEAD_OFFICE_NAME')); ?>:</b>
	<?php echo CHtml::encode($data->HEAD_OFFICE_NAME); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORY_1')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORY_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORY_2')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORY_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORY_3')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORY_3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORY_4')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORY_4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CATEGORY_5')); ?>:</b>
	<?php echo CHtml::encode($data->CATEGORY_5); ?>
	<br />

	*/ ?>

</div>