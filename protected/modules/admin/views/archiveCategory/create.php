<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title='Create Archive Categories';
$this->breadcrumbs=array(
	'Archive Categories'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
