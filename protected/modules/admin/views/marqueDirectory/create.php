<?php
/* @var $this MarqueDirectoryController */
/* @var $model MarqueDirectory */

$this->title='Ajouter cette marque';
$this->breadcrumbs=array(
	'Gestion des marques'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
