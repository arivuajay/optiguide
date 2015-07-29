<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */

$this->title = 'Ajouter une ville';
$this->breadcrumbs=array(
	'Gestion des villes',
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?>
</div>
