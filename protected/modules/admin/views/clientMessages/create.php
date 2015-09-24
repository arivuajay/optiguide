<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */

$this->title='Créer l\'alerte de message';
$this->breadcrumbs=array(
	'Rappelez-vous des alertes'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
