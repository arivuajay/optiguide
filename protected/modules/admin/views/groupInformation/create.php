<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */

$this->title='Create Group Informations';
$this->breadcrumbs=array(
	'Group Informations'=>array('index'),
	$this->title,
);

$data1['country'] = $country;
$data1['regions'] = $regions;
$data1['cities']  = $cities;
$data1['model']   = $model;
$data1['sections'] = $sections;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?>
</div>
