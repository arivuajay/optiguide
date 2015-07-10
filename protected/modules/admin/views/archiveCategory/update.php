<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= Myclass::t('APP34').' '. $model->ID_CATEGORIE;
$this->breadcrumbs=array(
	Myclass::t('APP40') => array('index'),
	Myclass::t('APP34'),
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>