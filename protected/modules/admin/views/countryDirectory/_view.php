<?php
/* @var $this CountryDirectoryController */
/* @var $data CountryDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_PAYS')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_PAYS), array('view', 'id'=>$data->ID_PAYS)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_PAYS_FR')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_PAYS_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_PAYS_EN')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_PAYS_EN); ?>
	<br />


</div>