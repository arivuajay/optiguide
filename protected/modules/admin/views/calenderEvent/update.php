<?php
/* @var $this CalenderEventsController */
/* @var $model CalenderEvents */

$this->title='Modifier cet événement';
$this->breadcrumbs=array(
	'Gestion des événements'=>array('index'),
	'Modifier cet événement',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>