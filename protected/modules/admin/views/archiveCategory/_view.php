<?php
/* @var $this ArchiveCategoryController */
/* @var $data ArchiveCategory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CATEGORIE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_CATEGORIE), array('view', 'id'=>$data->ID_CATEGORIE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_CATEGORIE_FR')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_CATEGORIE_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_CATEGORIE_EN')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_CATEGORIE_EN); ?>
	<br />


</div>