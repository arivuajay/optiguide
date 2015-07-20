<?php
/* @var $this RetailerDirectoryController */
/* @var $model RetailerDirectory */

$this->title='Ajouter un détaillant';
$this->breadcrumbs=array(
	'Gestion des détaillants'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('umodel','model')); ?>
</div>
