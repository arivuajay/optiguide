<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */

$this->title='Update Group Informations: '. $model->ID_GROUPE;
$this->breadcrumbs=array(
	'Group Informations'=>array('index'),
	'Update Group Informations',
);

?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?></div>