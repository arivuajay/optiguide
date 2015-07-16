<?php
/* @var $this ProfessionalTypeController */
/* @var $model ProfessionalType */

$this->title='Ajouter ce type de profession';
$this->breadcrumbs=array(
	'Gestion des types de professions'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
