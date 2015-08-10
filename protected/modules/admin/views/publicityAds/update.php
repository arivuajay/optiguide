<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */

$this->title='Modifier cette publicité';
$this->breadcrumbs=array(
	'Gestion des publicités'=>array('index'),
	'Modifier cette publicité',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',  compact('model','selected_regions','selected_modules','selected_sections')); ?></div>