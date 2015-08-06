<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->title='Modifier ce professionnel';
$this->breadcrumbs=array(
	'Gestion des professionnels'=>array('index'),
	'Modifier ce professionnel',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?>
</div>