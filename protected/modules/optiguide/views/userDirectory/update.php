<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */

$this->title='Modifier cet utilisateur de: '. $model->NOM_UTILISATEUR;
$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	'Modifier Utilisateurs',
);
  
$this->renderPartial('_form', compact('model'));  
    ?>