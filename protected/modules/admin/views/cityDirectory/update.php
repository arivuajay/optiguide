<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */

$this->title='Update City Directories: '. $model->ID_VILLE;
$this->breadcrumbs=array(
	'City Directories'=>array('index'),
	'Update City Directories',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>