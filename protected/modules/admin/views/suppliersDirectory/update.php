<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */

$this->title='Modifier ce fournisseur ';
$this->breadcrumbs=array(
	'Gestion des fournisseurs'=>array('index'),
	'Modifier ce fournisseur',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','tab', 'data_products','pmodel')); ?></div>