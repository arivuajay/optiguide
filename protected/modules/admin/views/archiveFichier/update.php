<?php
/* @var $this ArchiveFichierController */
/* @var $model ArchiveFichier */

$this->title='Update Archive Fichiers: '. $model->ID_FICHIER;
$this->breadcrumbs=array(
	'Archive Fichiers'=>array('index'),
	'Update Archive Fichiers',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',  compact('model', 'getallcat')); ?></div>