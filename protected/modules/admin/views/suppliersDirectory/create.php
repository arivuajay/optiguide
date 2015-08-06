<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */

$this->title='Ajouter un fournisseur';
$this->breadcrumbs=array(
	'Gestion des fournisseurs'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','tab', 'data_products')); ?>
</div>
