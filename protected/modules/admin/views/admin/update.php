<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->title='Update Admins: '. $model->admin_id;
$this->breadcrumbs=array(
	'Admins'=>array('index'),
	'Update Admins',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>