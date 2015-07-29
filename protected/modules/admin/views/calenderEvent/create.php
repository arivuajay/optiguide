<?php
/* @var $this CalenderEventsController */
/* @var $model CalenderEvents */

$this->title='Ajouter un événement';
$this->breadcrumbs=array(
	'Gestion des événements'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
