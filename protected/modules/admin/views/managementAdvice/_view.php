<?php
/* @var $this ManagementAdviceController */
/* @var $data ManagementAdvice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_CONSEIL')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_CONSEIL), array('view', 'id'=>$data->ID_CONSEIL)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LANGUE')); ?>:</b>
	<?php echo CHtml::encode($data->LANGUE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SYNOPSYS')); ?>:</b>
	<?php echo CHtml::encode($data->SYNOPSYS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEXTE')); ?>:</b>
	<?php echo CHtml::encode($data->TEXTE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LIEN_URL')); ?>:</b>
	<?php echo CHtml::encode($data->LIEN_URL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LIEN_TITRE')); ?>:</b>
	<?php echo CHtml::encode($data->LIEN_TITRE); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_SITE')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_SITE); ?>
	<br />

	*/ ?>

</div>