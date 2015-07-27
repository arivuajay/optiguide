<?php
/* @var $this CalenderEventsController */
/* @var $model CalenderEvents */

$this->title='Update Calender Events: '. $model->ID_EVENEMENT;
$this->breadcrumbs=array(
	'Calender Events'=>array('index'),
	'Update Calender Events',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>