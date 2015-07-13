<?php
/* @var $this CountryDirectoryController */
/* @var $model CountryDirectory */

$this->title= Myclass::t('APP504').' '.Myclass::t('APP35');
$this->breadcrumbs=array(
	Myclass::t('APP36') => array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
