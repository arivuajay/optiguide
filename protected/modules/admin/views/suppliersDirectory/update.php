<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */

$this->title='Update Suppliers Directories: '. $model->ID_FOURNISSEUR;
$this->breadcrumbs=array(
	'Suppliers Directories'=>array('index'),
	'Update Suppliers Directories',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>