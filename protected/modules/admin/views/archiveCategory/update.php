<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= Myclass::t('APP505').Myclass::t('APP33');
$this->breadcrumbs=array(
	Myclass::t('APP34') => array('index'),
	Myclass::t('APP505').' '.Myclass::t('APP33'),
);
?>
<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>