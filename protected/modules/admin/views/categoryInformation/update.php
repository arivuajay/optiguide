<?php
/* @var $this CategoryInformationController */
/* @var $model CategoryInformation */

$this->title= Myclass::t('APP505')." ".Myclass::t('APP57');
$this->breadcrumbs=array(
	Myclass::t('APP58') => array('index'),
	$this->title,
);

?>

<div class="user-create">
    <?php $this->renderPartial('_form',compact('model'));  ?>
</div>