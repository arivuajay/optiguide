<?php
/* @var $this AdminController */
/* @var $data Admin */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->admin_id), array('view', 'id'=>$data->admin_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_name')); ?>:</b>
	<?php echo CHtml::encode($data->admin_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_username')); ?>:</b>
	<?php echo CHtml::encode($data->admin_username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_password')); ?>:</b>
	<?php echo CHtml::encode($data->admin_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_status')); ?>:</b>
	<?php echo CHtml::encode($data->admin_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_email')); ?>:</b>
	<?php echo CHtml::encode($data->admin_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_last_login')); ?>:</b>
	<?php echo CHtml::encode($data->admin_last_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_login_ip')); ?>:</b>
	<?php echo CHtml::encode($data->admin_login_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role')); ?>:</b>
	<?php echo CHtml::encode($data->role); ?>
	<br />

	*/ ?>

</div>