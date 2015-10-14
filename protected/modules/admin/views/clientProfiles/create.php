<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->title='Créer profil cliente';
$this->breadcrumbs=array(
	'Les profils des clients'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php 
    $csearchmodel = '';
    $this->renderPartial('_form', array('model'=>$model,'cmodel'=>$cmodel ,'csearchmodel' => $csearchmodel)); ?>
</div>
