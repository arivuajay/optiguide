<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->title='Modifier Client Profile';
$this->breadcrumbs=array(
	'Client Profiles'=>array('index'),
	'Modifier Client Profile',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>