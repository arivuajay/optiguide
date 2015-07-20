<?php
/* @var $this RetailerDirectoryController */
/* @var $model RetailerDirectory */

$this->title='Modifier ce détaillant ';
$this->breadcrumbs=array(
	'Gestion des détaillants'=>array('index'),
	'Modifier ce détaillant',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('umodel', 'model')); ?></div>