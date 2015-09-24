<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->title='Create Client Profiles';
$this->breadcrumbs=array(
	'Client Profiles'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
