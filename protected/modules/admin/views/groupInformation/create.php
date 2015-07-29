<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */

$this->title='Ajouter une association';
$this->breadcrumbs=array(
	'Gestion des associations' => array('index'),
	$this->title,
);
?>
<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?>
</div>
