<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */

$this->title='Ajouter un utilisateur indépendant';
$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
