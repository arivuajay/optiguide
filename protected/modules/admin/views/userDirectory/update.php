<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */

$this->title='Modifier cet utilisateur de: '. $model->NOM_UTILISATEUR;
$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	'Modifier Utilisateurs',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',  compact('userslist_query','model','relid','namestr')); ?></div>