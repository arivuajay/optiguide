<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */

$this->title='Update Publicity Ads: '. $model->ID_PUBLICITE;
$this->breadcrumbs=array(
	'Publicity Ads'=>array('index'),
	'Update Publicity Ads',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>