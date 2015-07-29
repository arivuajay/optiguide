<?php
/* @var $this ProductDirectoryController */
/* @var $model ProductDirectory */

$this->title='Modifier ce produit / service';
$this->breadcrumbs=array(
	'Gestion des produits & services'=>array('index'),
	'Modifier ce produit / service',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>