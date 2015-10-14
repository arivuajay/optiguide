<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->title='Mise à jour de profil du client';
$this->breadcrumbs=array(
	'Les profils des clients'=>array('index'),
	'Mise à jour de profil du client',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model,'cmodel'=>$cmodel, 'csearchmodel' => $csearchmodel)); ?></div>