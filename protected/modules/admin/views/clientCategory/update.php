<?php
/* @var $this ClientCategoryController */
/* @var $model ClientCategory */

$this->title='Update Client Categories';
$this->breadcrumbs=array(
	'Client Categories'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>