<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */

$this->title='Ajouter une nouvelle';
$this->breadcrumbs=array(
	'Gestion des nouvelles'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
