<?php
/* @var $this RegionDirectoryController */
/* @var $model RegionDirectory */

$this->breadcrumbs=array(
	'Region Directories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RegionDirectory', 'url'=>array('index')),
	array('label'=>'Create RegionDirectory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#region-directory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Region Directories</h1>

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
	'id'=>'region-directory-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID_REGION',
		'ID_PAYS',
		'NOM_REGION_FR',
		'NOM_REGION_EN',
		'ABREVIATION_FR',
		'ABREVIATION_EN',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
