<?php
/* @var $this CountryDirectoryController */
/* @var $model CountryDirectory */

$this->title=Myclass::t('APP47').' : '. $model->ID_PAYS;
$this->breadcrumbs=array(
	Myclass::t('APP45') =>array('index'),
	Myclass::t('APP47'),
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>