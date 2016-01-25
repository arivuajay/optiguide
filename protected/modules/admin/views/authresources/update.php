<?php
/* @var $this AuthresourcesController */
/* @var $model AuthResources */

$this->title = 'Update Auth Resources: ' . $model->Master_Resource_ID;
$this->breadcrumbs = array(
    'Auth Resources' => array('index'),
    'Update Auth Resources',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?></div>