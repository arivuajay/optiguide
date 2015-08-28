<?php

/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->title = 'Create Professional Directories';
$this->breadcrumbs = array(
    'Professional Directories' => array('index'),
    $this->title,
);
?>

<?php $this->renderPartial('_form', compact('umodel','model')); ?>
