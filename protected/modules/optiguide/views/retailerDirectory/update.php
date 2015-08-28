<?php

/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->title = 'Create Retailer Directories';
$this->breadcrumbs = array(
    'Retailer Directories' => array('index'),
    $this->title,
);
?>

<?php $this->renderPartial('_form', compact('umodel','model')); ?>
