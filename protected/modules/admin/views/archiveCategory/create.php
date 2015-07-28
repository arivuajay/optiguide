<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= 'Ajouter une catégorie';
$this->breadcrumbs=array(
	Myclass::t('APP34') => array('index'),
	$this->title,
);
?>
<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
