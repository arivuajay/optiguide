<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title='Update Archive Categories: '. $model->ID_CATEGORIE;
$this->breadcrumbs=array(
	'Archive Categories'=>array('index'),
	'Update Archive Categories',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>