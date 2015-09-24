<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */

$this->title='Create Client Messages';
$this->breadcrumbs=array(
	'Client Messages'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
