<?php
/* @var $this ProductDirectoryController */
/* @var $model ProductDirectory */

$this->title='Update Product Directories: '. $model->ID_PRODUIT;
$this->breadcrumbs=array(
	'Product Directories'=>array('index'),
	'Update Product Directories',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>