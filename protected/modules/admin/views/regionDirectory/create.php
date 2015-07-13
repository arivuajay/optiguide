<?php
/* @var $this RegionDirectoryController */
/* @var $model RegionDirectory */

$this->title = Myclass::t('APP504').' '.Myclass::t('APP106');
$this->breadcrumbs = array(
    Myclass::t('APP107') => array('index'),
    $this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
