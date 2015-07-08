<?php
/* @var $this ArchiveCategoryController */
/* @var $model ArchiveCategory */

$this->title= Myclass::t('App34').' '. $model->ID_CATEGORIE;
$this->breadcrumbs=array(
	Myclass::t('App40') => array('index'),
	Myclass::t('App34'),
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>