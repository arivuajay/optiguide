<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */

$this->title='Create Suppliers Directories';
$this->breadcrumbs=array(
	'Suppliers Directories'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('umodel','model','tab', 'data_products')); ?>
</div>
