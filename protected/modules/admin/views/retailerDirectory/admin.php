<?php
/* @var $this RetailerDirectoryController */
/* @var $model RetailerDirectory */

$this->breadcrumbs=array(
	'Retailer Directories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RetailerDirectory', 'url'=>array('index')),
	array('label'=>'Create RetailerDirectory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#retailer-directory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Retailer Directories</h1>

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
	'id'=>'retailer-directory-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID_RETAILER',
		'ID_CLIENT',
		'COMPAGNIE',
		'ID_VILLE',
		'ADRESSE',
		'ADRESSE2',
		/*
		'CODE_POSTAL',
		'TELEPHONE',
		'TELEPHONE2',
		'TELECOPIEUR',
		'TELECOPIEUR2',
		'URL',
		'COURRIEL',
		'TEL_1800',
		'DATE_MODIFICATION',
		'ID_RETAILER_TYPE',
		'ID_GROUPE',
		'GROUPE',
		'HEAD_OFFICE_NAME',
		'CATEGORY_1',
		'CATEGORY_2',
		'CATEGORY_3',
		'CATEGORY_4',
		'CATEGORY_5',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
