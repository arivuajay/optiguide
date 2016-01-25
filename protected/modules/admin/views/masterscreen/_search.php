<?php
/* @var $this MasterscreenController */
/* @var $model MasterScreen */
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
        <?php echo $form->label($model, 'Master_Screen_ID'); ?>
        <?php echo $form->textField($model, 'Master_Screen_ID'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Module_ID'); ?>
        <?php echo $form->textField($model, 'Module_ID'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Screen_code'); ?>
        <?php echo $form->textField($model, 'Screen_code', array('size' => 45, 'maxlength' => 45)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Description'); ?>
        <?php echo $form->textField($model, 'Description', array('size' => 60, 'maxlength' => 100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Active'); ?>
        <?php echo $form->textField($model, 'Active'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Created_Date'); ?>
        <?php echo $form->textField($model, 'Created_Date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Rowversion'); ?>
        <?php echo $form->textField($model, 'Rowversion'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->