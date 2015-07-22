<?php
/* @var $this ManagementAdviceController */
/* @var $model ManagementAdvice */

$this->title='Ajouter un conseil';
$this->breadcrumbs=array(
	'Gestion des conseils'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
