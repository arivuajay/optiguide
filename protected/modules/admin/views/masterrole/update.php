<?php
/* @var $this MasterroleController */
/* @var $model MasterRole */

$this->title = 'Update Master Role: ' . $model->Role_Code;
$this->breadcrumbs = array(
    'Master Roles' => array('index'),
    'Update Master Roles',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?></div>