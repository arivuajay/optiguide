<?php
/* @var $this MasterroleController */
/* @var $model MasterRole */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'Master_Role_ID'); ?>
        <?php echo $form->textField($model, 'Master_Role_ID', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Role_Code'); ?>
        <?php echo $form->textField($model, 'Role_Code', array('class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Description'); ?>
        <?php echo $form->textField($model, 'Description', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'is_Admin'); ?>
        <?php echo $form->checkBox($model, 'is_Admin', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Active'); ?>
        <?php echo $form->checkBox($model, 'Active', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Created_Date'); ?>
        <?php echo $form->textField($model, 'Created_Date', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Rowversion'); ?>
        <?php echo $form->textField($model, 'Rowversion', array('class' => 'form-control')); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->