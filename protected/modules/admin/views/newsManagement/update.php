<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */

$this->title='Modifier cette nouvelle';
$this->breadcrumbs=array(
	'Gestion des nouvelles'=>array('index'),
	'Modifier cette nouvelle',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>