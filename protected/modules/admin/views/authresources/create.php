<?php
/* @var $this AuthresourcesController */
/* @var $model AuthResources */

$this->title = 'Create Auth Resources';
$this->breadcrumbs = array(
    'Auth Resources' => array('index'),
    $this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
