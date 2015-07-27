<?php
/* @var $this CalenderEventsController */
/* @var $model CalenderEvents */

$this->title='Create Calender Events';
$this->breadcrumbs=array(
	'Calender Events'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
