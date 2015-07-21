<?php
/* @var $this MarqueDirectoryController */
/* @var $data MarqueDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_MARQUE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_MARQUE), array('view', 'id'=>$data->ID_MARQUE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_MARQUE')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_MARQUE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHAGE')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHAGE); ?>
	<br />


</div>