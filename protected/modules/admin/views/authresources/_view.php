<?php
/* @var $this AuthresourcesController */
/* @var $data AuthResources */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Resource_ID')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->Master_Resource_ID), array('view', 'id' => $data->Master_Resource_ID)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_User_ID')); ?>:</b>
    <?php echo CHtml::encode($data->Master_User_ID); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Role_ID')); ?>:</b>
    <?php echo CHtml::encode($data->Master_Role_ID); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Module_ID')); ?>:</b>
    <?php echo CHtml::encode($data->Master_Module_ID); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Screen_ID')); ?>:</b>
    <?php echo CHtml::encode($data->Master_Screen_ID); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Task_ADD')); ?>:</b>
    <?php echo CHtml::encode($data->Master_Task_ADD); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Task_SEE')); ?>:</b>
    <?php echo CHtml::encode($data->Master_Task_SEE); ?>
    <br />

    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Task_UPT')); ?>:</b>
      <?php echo CHtml::encode($data->Master_Task_UPT); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('Master_Task_DEL')); ?>:</b>
      <?php echo CHtml::encode($data->Master_Task_DEL); ?>
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

     */ ?>

</div>