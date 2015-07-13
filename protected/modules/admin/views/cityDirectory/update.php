<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */

$this->title = Myclass::t('APP505').' '.Myclass::t('APP41');
$this->breadcrumbs=array(
	Myclass::t('APP42')=>array('index'),
	$this->title,
);

$data1['country'] = $country;
$data1['regions'] = $regions;
$data1['model']   = $model;
$data1['cid']     = $cid;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?></div>