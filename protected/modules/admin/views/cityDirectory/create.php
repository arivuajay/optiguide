<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */

$this->title='Create City Directories';
$this->breadcrumbs=array(
	'City Directories'=>array('index'),
	$this->title,
);
$data1['country'] = $country;
$data1['regions'] = $regions;
$data1['model']   = $model;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?>
</div>
