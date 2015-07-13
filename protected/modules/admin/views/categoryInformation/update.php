<?php
/* @var $this CategoryInformationController */
/* @var $model CategoryInformation */

$this->title= Myclass::t('APP88').': ';
$this->breadcrumbs=array(
	Myclass::t('APP87') => array('index'),
	Myclass::t('APP88'),
);

$data1['country'] = $country;
$data1['regions'] = $regions;
$data1['cities']  = $cities;
$data1['model']   = $model;
$data1['cid']     = $cid;
$data1['rid']     = $rid;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1);  ?>
</div>