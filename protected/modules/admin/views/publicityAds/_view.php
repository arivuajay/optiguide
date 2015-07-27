<?php
/* @var $this PublicityAdsController */
/* @var $data PublicityAds */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_PUBLICITE')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID_PUBLICITE), array('view', 'id'=>$data->ID_PUBLICITE)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NO_PUB')); ?>:</b>
	<?php echo CHtml::encode($data->NO_PUB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LANGUE')); ?>:</b>
	<?php echo CHtml::encode($data->LANGUE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TITRE')); ?>:</b>
	<?php echo CHtml::encode($data->TITRE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_DEBUT')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_DEBUT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_FIN')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_FIN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_FICHIER')); ?>:</b>
	<?php echo CHtml::encode($data->ID_FICHIER); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('LIEN_URL')); ?>:</b>
	<?php echo CHtml::encode($data->LIEN_URL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MOTS_CLES_RECHERCHE')); ?>:</b>
	<?php echo CHtml::encode($data->MOTS_CLES_RECHERCHE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NB_IMPRESSIONS_FAITES')); ?>:</b>
	<?php echo CHtml::encode($data->NB_IMPRESSIONS_FAITES); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NB_IMPRESSIONS')); ?>:</b>
	<?php echo CHtml::encode($data->NB_IMPRESSIONS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRIORITE')); ?>:</b>
	<?php echo CHtml::encode($data->PRIORITE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRIX')); ?>:</b>
	<?php echo CHtml::encode($data->PRIX); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PAYE')); ?>:</b>
	<?php echo CHtml::encode($data->PAYE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CLIENT')); ?>:</b>
	<?php echo CHtml::encode($data->CLIENT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ZONE_AFFICHAGE')); ?>:</b>
	<?php echo CHtml::encode($data->ZONE_AFFICHAGE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_POSITION')); ?>:</b>
	<?php echo CHtml::encode($data->ID_POSITION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AFFICHER_ACCUEIL')); ?>:</b>
	<?php echo CHtml::encode($data->AFFICHER_ACCUEIL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DATE_AJOUT')); ?>:</b>
	<?php echo CHtml::encode($data->DATE_AJOUT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ACCUEIL_SECTION')); ?>:</b>
	<?php echo CHtml::encode($data->ACCUEIL_SECTION); ?>
	<br />

	*/ ?>

</div>