<?php
/* @var $this ProfessionalTypeController */
/* @var $model ProfessionalType */

$this->title='Modifier ce type de profession';
$this->breadcrumbs=array(
	'Gestion des types de professions'=>array('index'),
	'Modifier ce type de profession',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>