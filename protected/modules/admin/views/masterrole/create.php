<?php
/* @var $this MasterroleController */
/* @var $model MasterRole */

$this->title = 'Create Master Roles';
$this->breadcrumbs = array(
    'Master Roles' => array('index'),
    $this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
