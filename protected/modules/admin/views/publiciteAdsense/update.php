<?php
/* @var $this PubliciteAdsenseController */
/* @var $model PubliciteAdsense */

$this->title='Update Publicite Adsenses: '. $model->id_adsense;
$this->breadcrumbs=array(
	'Publicite Adsenses'=>array('index'),
	'Update Publicite Adsenses',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>