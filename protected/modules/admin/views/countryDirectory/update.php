<?php
/* @var $this CountryDirectoryController */
/* @var $model CountryDirectory */

$this->title=Myclass::t('App47').' : '. $model->ID_PAYS;
$this->breadcrumbs=array(
	Myclass::t('App45') =>array('index'),
	Myclass::t('App47'),
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>