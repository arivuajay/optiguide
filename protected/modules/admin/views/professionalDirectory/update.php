<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->title='Update Professional Directories: '. $model->ID_SPECIALISTE;
$this->breadcrumbs=array(
	'Professional Directories'=>array('index'),
	'Update Professional Directories',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>