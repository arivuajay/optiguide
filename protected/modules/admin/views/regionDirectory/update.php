<?php
/* @var $this RegionDirectoryController */
/* @var $model RegionDirectory */

$this->title = 'Modifier cette région';
$this->breadcrumbs = array(
    'Gestion des régions',
    $this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>