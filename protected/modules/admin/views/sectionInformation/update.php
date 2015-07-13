<?php
/* @var $this SectionInformationController */
/* @var $model SectionInformation */

$this->title = Myclass::t('APP505')." ".Myclass::t('APP53');
$this->breadcrumbs=array(
	Myclass::t('APP54') =>array('index'),
	$this->title,
);

$data1['allcat']  = $allcat;
$data1['model']   = $model;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?></div>