<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */

$this->title = Myclass::t('APP58');
$this->breadcrumbs=array(
	Myclass::t('APP57') => array('index'),
	$this->title,
);
$data1['country'] = $country;
$data1['regions'] = $regions;
$data1['model']   = $model;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?>
</div>
