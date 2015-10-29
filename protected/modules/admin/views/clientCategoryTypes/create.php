<?php
/* @var $this ClientCategoryTypesController */
/* @var $model ClientCategoryTypes */

$this->title='Créer une catégorie de types de clients';
$this->breadcrumbs=array(
	'catégorie de types de clients'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
