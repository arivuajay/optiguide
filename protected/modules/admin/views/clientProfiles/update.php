<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->title='Update Client Profiles: '. $model->client_id;
$this->breadcrumbs=array(
	'Client Profiles'=>array('index'),
	'Update Client Profiles',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>