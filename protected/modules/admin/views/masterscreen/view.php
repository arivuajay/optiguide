<?php
/* @var $this MasterscreenController */
/* @var $model MasterScreen */

$this->breadcrumbs = array(
    'Master Screens' => array('index'),
    $model->Master_Screen_ID,
);

$this->menu = array(
    array('label' => 'List MasterScreen', 'url' => array('index')),
    array('label' => 'Create MasterScreen', 'url' => array('create')),
    array('label' => 'Update MasterScreen', 'url' => array('update', 'id' => $model->Master_Screen_ID)),
    array('label' => 'Delete MasterScreen', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->Master_Screen_ID), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage MasterScreen', 'url' => array('admin')),
);
?>

<h1>View MasterScreen #<?php echo $model->Master_Screen_ID; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'Master_Screen_ID',
        'Module_ID',
        'Screen_code',
        'Description',
        array(
            'label' => MasterScreen::model()->getAttributeLabel('Active'),
            'type' => 'raw',
            'value' => ($model->Active == 1) ? '<i class="fa fa-circle text-green" title="Active"></i>' : '<i title="In-Active" class="fa fa-circle text-red"></i>'
        ),
    ),
));
?>
