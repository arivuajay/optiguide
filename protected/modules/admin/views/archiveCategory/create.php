<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= Myclass::t('APP35');
$this->breadcrumbs=array(
	Myclass::t('APP40') => array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
