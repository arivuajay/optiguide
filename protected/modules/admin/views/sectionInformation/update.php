<?php
/* @var $this SectionInformationController */
/* @var $model SectionInformation */

$this->title = 'Modifier une section';
$this->breadcrumbs=array(
	'Gestion des sections' =>array('index'),
	$this->title,
);

$data1['allcat']  = $allcat;
$data1['model']   = $model;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?></div>