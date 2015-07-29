<?php
/* @var $this RegionDirectoryController */
/* @var $model RegionDirectory */

$this->title = 'Ajouter une région';
$this->breadcrumbs = array(
    'Gestion des régions',
    $this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
