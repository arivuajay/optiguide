<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */

$this->title='Create Group Informations';
$this->breadcrumbs=array(
	'Group Informations'=>array('index'),
	$this->title,
);
?>
<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?>
</div>
