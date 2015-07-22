<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */

$this->breadcrumbs=array(
	'Suppliers Directories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SuppliersDirectory', 'url'=>array('index')),
	array('label'=>'Create SuppliersDirectory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#suppliers-directory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Suppliers Directories</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'suppliers-directory-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID_FOURNISSEUR',
		'COMPAGNIE',
		'ID_CLIENT',
		'ID_TYPE_FOURNISSEUR',
		'ADRESSE',
		'ADRESSE2',
		/*
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELECOPIEUR',
		'TITRE_TEL_SANS_FRAIS',
		'TITRE_TEL_SANS_FRAIS_EN',
		'TEL_SANS_FRAIS',
		'TITRE_TEL_SECONDAIRE',
		'TITRE_TEL_SECONDAIRE_EN',
		'TEL_SECONDAIRE',
		'COURRIEL',
		'SITE_WEB',
		'SUCCURSALES',
		'ETABLI_DEPUIS',
		'NB_EMPLOYES',
		'PERSONNEL_NOM1',
		'PERSONNEL_TITRE1',
		'PERSONNEL_TITRE1_EN',
		'PERSONNEL_NOM2',
		'PERSONNEL_TITRE2',
		'PERSONNEL_TITRE2_EN',
		'PERSONNEL_NOM3',
		'PERSONNEL_TITRE3',
		'PERSONNEL_TITRE3_EN',
		'DATE_MODIFICATION',
		'REGIONS_FR',
		'REGIONS_EN',
		'bAfficher_site',
		'iId_fichier',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
