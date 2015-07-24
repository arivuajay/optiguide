<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */

$this->title='Update Supplier Directories: ';
$this->breadcrumbs=array(
	'Supplier Directories'=>array('index'),
	'Update Supplier Directories',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('umodel','model','tab', 'data_products')); ?></div>