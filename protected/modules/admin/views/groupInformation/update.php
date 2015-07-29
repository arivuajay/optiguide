<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */

$this->title='Modifier cette association';
$this->breadcrumbs=array(
	'Gestion des associations'=>array('index'),
	'Modifier cette association',
);

?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?></div>