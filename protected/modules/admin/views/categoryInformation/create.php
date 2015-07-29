<?php
/* @var $this CategoryInformationController */
/* @var $model CategoryInformation */

$this->title= 'Ajouter une catégorie d\'association';
$this->breadcrumbs=array(
       'Gestion des catégories d\'associations' => array('index'),
        $this->title,
);
?>
<div class="user-create">
    <?php $this->renderPartial('_form', compact('model')); ?>
</div>