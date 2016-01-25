<?php
/* @var $this MasterscreenController */
/* @var $data MasterScreen */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Screen_ID')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->Master_Screen_ID), array('view', 'id' => $data->Master_Screen_ID)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Module_ID')); ?>:</b>
    <?php echo CHtml::encode($data->Module_ID); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Screen_code')); ?>:</b>
    <?php echo CHtml::encode($data->Screen_code); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
    <?php echo CHtml::encode($data->Description); ?>
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