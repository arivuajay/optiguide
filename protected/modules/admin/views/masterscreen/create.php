<?php
/* @var $this MasterscreenController */
/* @var $model MasterScreen */

$this->breadcrumbs = array(
    'Master Screens' => array('index'),
    'Save',
);

$this->menu = array(
    array('label' => 'List MasterScreen', 'url' => array('index')),
    array('label' => 'Manage MasterScreen', 'url' => array('admin')),
);
?>

<h1>Create MasterScreen</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>