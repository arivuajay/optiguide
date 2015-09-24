<?php
/* @var $this EmployeeProfilesController */
/* @var $model EmployeeProfiles */

$this->title='Create Employee Profiles';
$this->breadcrumbs=array(
	'Employee Profiles'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
