<?php
/* @var $this PubliciteAdsenseController */
/* @var $model PubliciteAdsense */

$this->title='Create Publicite Adsenses';
$this->breadcrumbs=array(
	'Publicite Adsenses'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
