<?php
/* @var $this ProductDirectoryController */
/* @var $model ProductDirectory */

$this->title='Ajouter un produit ou service';
$this->breadcrumbs=array(
	'Gestion des produits & services'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
