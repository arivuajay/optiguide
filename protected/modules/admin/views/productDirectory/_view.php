<?php
/* @var $this ProductDirectoryController */
/* @var $data ProductDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_PRODUIT')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_PRODUIT), array('view', 'id'=>$data->ID_PRODUIT)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_SECTION')); ?>:</b>
	<?php echo CHtml::encode($data->ID_SECTION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_PRODUIT_FR')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_PRODUIT_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_PRODUIT_EN')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_PRODUIT_EN); ?>
	<br />


</div>