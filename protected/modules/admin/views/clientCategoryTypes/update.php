<?php
/* @var $this ClientCategoryTypesController */
/* @var $model ClientCategoryTypes */

$this->title='mise à jour du client catégorie types';
$this->breadcrumbs=array(
	'catégorie de types de clients'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>