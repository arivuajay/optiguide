<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */

$this->title='Ajouter un utilisateur à '.$namestr;
$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('userslist_query','model','relid','namestr','nomtable')); ?>
</div>
