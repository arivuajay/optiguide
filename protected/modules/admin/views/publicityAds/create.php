<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */

$this->title=' Ajouter une publicité';
$this->breadcrumbs=array(
	'Gestion des publicités'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
