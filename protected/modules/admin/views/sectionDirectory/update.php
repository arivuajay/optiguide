<?php
/* @var $this SectionDirectoryController */
/* @var $model SectionDirectory */

$this->title='Modifier cette section';
$this->breadcrumbs=array(
	'Gestion des sections'=>array('index'),
	'Modifier cette section',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>