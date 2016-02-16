<?php
/* @var $this RetailerGroupController */
/* @var $model RetailerGroup */

$this->title='Modifier les détaillants groupes';
$this->breadcrumbs=array(
	'Gestion des regroupement de détaillants'=>array('index'),
	'Modifier les détaillants groupes',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>