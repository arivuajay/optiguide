<?php
/* @var $this MasterscreenController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Master Screens',
);

$this->menu = array(
    array('label' => 'Create MasterScreen', 'url' => array('create')),
    array('label' => 'Manage MasterScreen', 'url' => array('admin')),
);
?>

<h1>Master Screens</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
