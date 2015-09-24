<?php
/* @var $this EmployeeProfilesController */
/* @var $model EmployeeProfiles */

$this->title='Update Employee Profiles: '. $model->employee_id;
$this->breadcrumbs=array(
	'Employee Profiles'=>array('index'),
	'Update Employee Profiles',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>