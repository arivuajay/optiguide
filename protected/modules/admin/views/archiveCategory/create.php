<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= Myclass::t('App35');
$this->breadcrumbs=array(
	Myclass::t('App40') => array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
