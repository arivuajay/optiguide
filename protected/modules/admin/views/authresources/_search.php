<?php
/* @var $this AuthresourcesController */
/* @var $model AuthResources */
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
        <?php echo $form->label($model, 'Master_Resource_ID'); ?>
        <?php echo $form->textField($model, 'Master_Resource_ID', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_User_ID'); ?>
        <?php echo $form->textField($model, 'Master_User_ID', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_Role_ID'); ?>
        <?php echo $form->textField($model, 'Master_Role_ID', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_Module_ID'); ?>
        <?php echo $form->textField($model, 'Master_Module_ID', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_Screen_ID'); ?>
        <?php echo $form->textField($model, 'Master_Screen_ID', array('class' => 'form-control')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_Task_ADD'); ?>
        <?php echo $form->textField($model, 'Master_Task_ADD', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_Task_SEE'); ?>
        <?php echo $form->textField($model, 'Master_Task_SEE', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_Task_UPT'); ?>
        <?php echo $form->textField($model, 'Master_Task_UPT', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Master_Task_DEL'); ?>
        <?php echo $form->textField($model, 'Master_Task_DEL', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
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