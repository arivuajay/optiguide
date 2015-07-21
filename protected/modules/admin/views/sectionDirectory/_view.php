<?php
/* @var $this SectionDirectoryController */
/* @var $data SectionDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_SECTION')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_SECTION), array('view', 'id'=>$data->ID_SECTION)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_SECTION_FR')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_SECTION_FR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_SECTION_EN')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_SECTION_EN); ?>
	<br />


</div>