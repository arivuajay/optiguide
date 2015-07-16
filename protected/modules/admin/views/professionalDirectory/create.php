<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->title='Ajouter un professionnel';
$this->breadcrumbs=array(
	'Gestion des professionnels'=>array('index'),
	$this->title,
);

$data1['proftypes'] = $proftypes;
        
$data1['country']   = $country;               
$data1['regions']   = $regions;
$data1['cities']    = $cities;

//$data1['all_USR']   = $all_USR;

$data1['model'] = $model;
?>

<div class="user-create">
    <?php $this->renderPartial('_form', $data1); ?>
</div>
