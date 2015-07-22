<?php
/* @var $this ManagementAdviceController */
/* @var $model ManagementAdvice */

$this->title='Modifier ce conseil';
$this->breadcrumbs=array(
	'Gestion des conseils'=>array('index'),
	'Modifier ce conseil',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>