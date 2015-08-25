<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->title='Create Payment Transactions';
$this->breadcrumbs=array(
	'Payment Transactions'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
