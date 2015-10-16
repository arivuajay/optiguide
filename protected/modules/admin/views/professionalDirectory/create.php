<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->title='Ajouter un professionnel';
$this->breadcrumbs=array(
	'Gestion des professionnels'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','pmodel')); ?>
</div>
