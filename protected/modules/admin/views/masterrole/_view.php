<?php
/* @var $this MasterroleController */
/* @var $data MasterRole */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Role_ID')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->Master_Role_ID), array('view', 'id' => $data->Master_Role_ID)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Role_Code')); ?>:</b>
    <?php echo CHtml::encode($data->Role_Code); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
    <?php echo CHtml::encode($data->Description); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('is_Admin')); ?>:</b>
    <?php echo CHtml::encode($data->is_Admin); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Active')); ?>:</b>
    <?php echo CHtml::encode($data->Active); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Created_Date')); ?>:</b>
    <?php echo CHtml::encode($data->Created_Date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Rowversion')); ?>:</b>
    <?php echo CHtml::encode($data->Rowversion); ?>
    <br />


</div>