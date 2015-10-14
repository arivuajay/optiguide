<?php
/* @var $this ClientMessagesController */
/* @var $data ClientMessages */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('message_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->message_id), array('view', 'id'=>$data->message_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_remember')); ?>:</b>
	<?php echo CHtml::encode($data->date_remember); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_view_status')); ?>:</b>
	<?php echo CHtml::encode($data->user_view_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_sent_counts')); ?>:</b>
	<?php echo CHtml::encode($data->mail_sent_counts); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	*/ ?>

</div>