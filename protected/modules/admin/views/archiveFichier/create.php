<?php
/* @var $this ArchiveFichierController */
/* @var $model ArchiveFichier */

$this->title='Ajouter un nouveau fichier';
$this->breadcrumbs=array(
	'Archive Fichiers'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',compact('model','getallcat')); ?>
</div>
