<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */

$this->title='Update Client Messages: '. $model->message_id;
$this->breadcrumbs=array(
	'Client Messages'=>array('index'),
	'Update Client Messages',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>