<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= Myclass::t('APP504').Myclass::t('APP33');
$this->breadcrumbs=array(
	Myclass::t('APP34') => array('index'),
	$this->title,
);
?>
<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
