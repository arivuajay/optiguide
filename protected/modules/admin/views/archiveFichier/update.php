<?php
/* @var $this ArchiveFichierController */
/* @var $model ArchiveFichier */

$this->title='MODIFIER UNE ARCHIVE';
$this->breadcrumbs=array(
	'Archive Fichiers'=>array('index'),
	'MODIFIER UNE ARCHIVE',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',  compact('model', 'getallcat')); ?></div>