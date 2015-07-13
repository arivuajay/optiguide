<?php
/* @var $this SectionInformationController */
/* @var $data SectionInformation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_SECTION')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_SECTION), array('view', 'id'=>$data->ID_SECTION)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CATEGORIE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_CATEGORIE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SECTION_FR')); ?>:</b>
	<?php echo CHtml::encode($data->SECTION_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SECTION_EN')); ?>:</b>
	<?php echo CHtml::encode($data->SECTION_EN); ?>
	<br />


</div>