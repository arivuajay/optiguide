<?php
/* @var $this ClassifiedsController */
/* @var $model Classifieds */

$this->title = Myclass::t('OGO209', '', 'og');
$this->breadcrumbs = array(
    Myclass::t('OGO206', '', 'og') => array('index'),
    $this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>