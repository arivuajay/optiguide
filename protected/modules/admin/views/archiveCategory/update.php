<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= 'Modifier cette catégorie';
$this->breadcrumbs=array(
	Myclass::t('APP34') => array('index'),
	'Modifier cette catégorie',
);
?>
<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>