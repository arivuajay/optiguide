<?php
/* @var $this CountryDirectoryController */
/* @var $model CountryDirectory */

$this->title= Myclass::t('APP46');
$this->breadcrumbs=array(
	Myclass::t('APP46') => array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
