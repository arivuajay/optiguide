<?php
/* @var $this RetailerGroupController */
/* @var $model RetailerGroup */

$this->title='Ajouter un détaillants groupes';
$this->breadcrumbs=array(
	'Gestion des regroupement de détaillants'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
