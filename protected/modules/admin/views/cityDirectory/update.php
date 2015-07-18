<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */

$this->title = Myclass::t('APP505').' '.Myclass::t('APP41');
$this->breadcrumbs=array(
	Myclass::t('APP42')=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?></div>