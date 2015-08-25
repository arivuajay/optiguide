<?php
/* @var $this PaymentTransactionController */
/* @var $data PaymentTransaction */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscription_price')); ?>:</b>
	<?php echo CHtml::encode($data->subscription_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_status')); ?>:</b>
	<?php echo CHtml::encode($data->payment_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payer_email')); ?>:</b>
	<?php echo CHtml::encode($data->payer_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verify_sign')); ?>:</b>
	<?php echo CHtml::encode($data->verify_sign); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('txn_id')); ?>:</b>
	<?php echo CHtml::encode($data->txn_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_type')); ?>:</b>
	<?php echo CHtml::encode($data->payment_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receiver_email')); ?>:</b>
	<?php echo CHtml::encode($data->receiver_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('txn_type')); ?>:</b>
	<?php echo CHtml::encode($data->txn_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_name')); ?>:</b>
	<?php echo CHtml::encode($data->item_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NOMTABLE')); ?>:</b>
	<?php echo CHtml::encode($data->NOMTABLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expirydate')); ?>:</b>
	<?php echo CHtml::encode($data->expirydate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_number')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_number); ?>
	<br />

	*/ ?>

</div>