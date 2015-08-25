<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->title='Mise à jour de l\'état de paiement: ';
$this->breadcrumbs=array(
	'Fournisseurs transactions de paiement'=>array('index'),
	'Mise à jour de l\'état de paiement',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>