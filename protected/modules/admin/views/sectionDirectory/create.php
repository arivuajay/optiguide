<?php
/* @var $this SectionDirectoryController */
/* @var $model SectionDirectory */

$this->title='Ajouter une section';
$this->breadcrumbs=array(
	'Gestion des sections'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
