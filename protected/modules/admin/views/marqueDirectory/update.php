<?php
/* @var $this MarqueDirectoryController */
/* @var $model MarqueDirectory */

$this->title='Modifier cette marque';
$this->breadcrumbs=array(
	'Gestion des marques'=>array('index'),
	'Modifier cette marque',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>