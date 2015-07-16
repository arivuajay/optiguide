<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->breadcrumbs=array(
	'Professional Directories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProfessionalDirectory', 'url'=>array('index')),
	array('label'=>'Create ProfessionalDirectory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#professional-directory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Professional Directories</h1>

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
	'id'=>'professional-directory-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID_SPECIALISTE',
		'ID_CLIENT',
		'PREFIXE_FR',
		'PREFIXE_EN',
		'PRENOM',
		'NOM',
		/*
		'ID_TYPE_SPECIALISTE',
		'TYPE_AUTRE',
		'BUREAU',
		'ADRESSE',
		'ADRESSE2',
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELEPHONE2',
		'TELECOPIEUR',
		'TELECOPIEUR2',
		'SITE_WEB',
		'COURRIEL',
		'DATE_MODIFICATION',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
