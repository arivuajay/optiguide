<?php
/* @var $this EmployeeProfilesController */
/* @var $model EmployeeProfiles */

$this->title='Modifier le profil de l\'employé';
$this->breadcrumbs=array(
	'Profils d\'employés'=>array('index'),
	'Modifier le profil de l\'employé',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>