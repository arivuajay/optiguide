<?php
/* @var $this EmployeeProfilesController */
/* @var $model EmployeeProfiles */

$this->title='Créer un profil des employés';
$this->breadcrumbs=array(
	'Profils d\'employés'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
