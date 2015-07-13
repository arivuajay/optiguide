<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */

$this->title='Update Group Informations: '. $model->ID_GROUPE;
$this->breadcrumbs=array(
	'Group Informations'=>array('index'),
	'Update Group Informations',
);

$data1['country'] = $country;
$data1['regions'] = $regions;
$data1['cities']  = $cities;
$data1['model']   = $model;
$data1['cid']     = $cid;
$data1['rid']     = $rid;
$data1['sections']  = $sections;                

?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?></div>