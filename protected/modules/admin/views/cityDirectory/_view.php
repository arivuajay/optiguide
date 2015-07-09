<?php
/* @var $this CityDirectoryController */
/* @var $data CityDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_VILLE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_VILLE), array('view', 'id'=>$data->ID_VILLE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_REGION')); ?>:</b>
	<?php echo CHtml::encode($data->ID_REGION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_VILLE')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_VILLE); ?>
	<br />


</div>