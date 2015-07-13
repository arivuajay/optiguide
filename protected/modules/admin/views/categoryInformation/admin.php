<?php
/* @var $this CategoryInformationController */
/* @var $model CategoryInformation */

$this->breadcrumbs=array(
	'Category Informations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CategoryInformation', 'url'=>array('index')),
	array('label'=>'Create CategoryInformation', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-information-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Category Informations</h1>

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
	'id'=>'category-information-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID_CATEGORIE',
		'CATEGORIE_FR',
		'CATEGORIE_EN',
		'NOM_ASSOCIATION_FR',
		'NOM_ASSOCIATION_EN',
		'ADRESSE',
		/*
		'ADRESSE2',
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELECOPIEUR',
		'TEL_SANS_FRAIS',
		'COURRIEL',
		'SITE_WEB',
		'PREFIXE_REPRESENTANT_FR',
		'PREFIXE_REPRESENTANT_EN',
		'NOM_REPRESENTANT',
		'TITRE_REPRESENTANT_FR',
		'TITRE_REPRESENTANT_EN',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
