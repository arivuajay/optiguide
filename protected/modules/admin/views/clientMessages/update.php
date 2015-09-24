<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */

$this->title='Modifier message d\'alerte ';
$this->breadcrumbs=array(
	'Rappelez-vous des alertes'=>array('index'),
	'Modifier message d\'alerte',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>