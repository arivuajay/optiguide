<?php
/* @var $this UserDirectoryController */
/* @var $data UserDirectory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_UTILISATEUR')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_UTILISATEUR), array('view', 'id'=>$data->ID_UTILISATEUR)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LANGUE')); ?>:</b>
	<?php echo CHtml::encode($data->LANGUE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PREFIXE')); ?>:</b>
	<?php echo CHtml::encode($data->PREFIXE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_UTILISATEUR')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_UTILISATEUR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('USR')); ?>:</b>
	<?php echo CHtml::encode($data->USR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PWD')); ?>:</b>
	<?php echo CHtml::encode($data->PWD); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('COURRIEL')); ?>:</b>
	<?php echo CHtml::encode($data->COURRIEL); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ABONNE_MAILING')); ?>:</b>
	<?php echo CHtml::encode($data->ABONNE_MAILING); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ABONNE_PROMOTION')); ?>:</b>
	<?php echo CHtml::encode($data->ABONNE_PROMOTION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ABONNE_TRANSITION')); ?>:</b>
	<?php echo CHtml::encode($data->ABONNE_TRANSITION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IS_FIRST_LOG')); ?>:</b>
	<?php echo CHtml::encode($data->IS_FIRST_LOG); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOM_TABLE')); ?>:</b>
	<?php echo CHtml::encode($data->NOM_TABLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_RELATION')); ?>:</b>
	<?php echo CHtml::encode($data->ID_RELATION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MUST_VALIDATE')); ?>:</b>
	<?php echo CHtml::encode($data->MUST_VALIDATE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sGuid')); ?>:</b>
	<?php echo CHtml::encode($data->sGuid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bSubscription_envision')); ?>:</b>
	<?php echo CHtml::encode($data->bSubscription_envision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bSubscription_envue')); ?>:</b>
	<?php echo CHtml::encode($data->bSubscription_envue); ?>
	<br />

	*/ ?>

</div>