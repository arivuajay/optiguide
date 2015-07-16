<?php
/* @var $this ProfessionalTypeController */
/* @var $data ProfessionalType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_TYPE_SPECIALISTE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_TYPE_SPECIALISTE), array('view', 'id'=>$data->ID_TYPE_SPECIALISTE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TYPE_SPECIALISTE_FR')); ?>:</b>
	<?php echo CHtml::encode($data->TYPE_SPECIALISTE_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TYPE_SPECIALISTE_EN')); ?>:</b>
	<?php echo CHtml::encode($data->TYPE_SPECIALISTE_EN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iOrder')); ?>:</b>
	<?php echo CHtml::encode($data->iOrder); ?>
	<br />


</div>