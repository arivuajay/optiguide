<?php
/* @var $this MasterscreenController */
/* @var $model MasterScreen */

$this->breadcrumbs = array(
    'Master Screens' => array('index'),
    $model->Master_Screen_ID => array('view', 'id' => $model->Master_Screen_ID),
    'Update',
);

$this->menu = array(
    array('label' => 'List MasterScreen', 'url' => array('index')),
    array('label' => 'Create MasterScreen', 'url' => array('create')),
    array('label' => 'View MasterScreen', 'url' => array('view', 'id' => $model->Master_Screen_ID)),
    array('label' => 'Manage MasterScreen', 'url' => array('admin')),
);
?>

<h1>Update MasterScreen <?php echo $model->Master_Screen_ID; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>