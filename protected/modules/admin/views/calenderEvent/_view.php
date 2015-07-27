<?php
/* @var $this CalendarEventsController */
/* @var $data CalendarEvents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_EVENEMENT')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_EVENEMENT), array('view', 'id'=>$data->ID_EVENEMENT)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LANGUE')); ?>:</b>
	<?php echo CHtml::encode($data->LANGUE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_AJOUT1')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_AJOUT1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_AJOUT2')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_AJOUT2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEXTE')); ?>:</b>
	<?php echo CHtml::encode($data->TEXTE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LIEN_URL')); ?>:</b>
	<?php echo CHtml::encode($data->LIEN_URL); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('LIEN_TITRE')); ?>:</b>
	<?php echo CHtml::encode($data->LIEN_TITRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_SITE')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_SITE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_ACCUEIL')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_ACCUEIL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_ARCHIVE')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_ARCHIVE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_PAYS')); ?>:</b>
	<?php echo CHtml::encode($data->ID_PAYS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_REGION')); ?>:</b>
	<?php echo CHtml::encode($data->ID_REGION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_VILLE')); ?>:</b>
	<?php echo CHtml::encode($data->ID_VILLE); ?>
	<br />

	*/ ?>

</div>