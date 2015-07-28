<?php
/* @var $this CountryDirectoryController */
/* @var $model CountryDirectory */

$this->title= 'Ajouter un pays';
$this->breadcrumbs=array(
	'Gestion des pays',
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
