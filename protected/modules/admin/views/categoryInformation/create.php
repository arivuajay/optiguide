<?php
/* @var $this CategoryInformationController */
/* @var $model CategoryInformation */

$this->title= Myclass::t('APP504')." ".Myclass::t('APP57');
$this->breadcrumbs=array(
        Myclass::t('APP58') => array('index'),
        $this->title,
);
$data1['country'] = $country;
$data1['regions'] = $regions;
$data1['cities']  = $cities;
$data1['model']   = $model;
?>
<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?>
</div>