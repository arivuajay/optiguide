<?php
/* @var $this RegionDirectoryController */
/* @var $model RegionDirectory */

$this->title = Myclass::t('APP109');
$this->breadcrumbs = array(
    Myclass::t('APP108') => array('index'),
    $this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
