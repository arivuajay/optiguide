<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */

$this->title='Create Publicity Ads';
$this->breadcrumbs=array(
	'Publicity Ads'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
