<?php
/* @var $this CountryDirectoryController */
/* @var $model CountryDirectory */

$this->title= 'Modifier ce pays';
$this->breadcrumbs=array(
	 'Gestion des pays' => array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>