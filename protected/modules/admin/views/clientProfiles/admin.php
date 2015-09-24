<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->breadcrumbs=array(
	'Client Profiles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ClientProfiles', 'url'=>array('index')),
	array('label'=>'Create ClientProfiles', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#client-profiles-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Client Profiles</h1>

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
	'id'=>'client-profiles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'client_id',
		'name',
		'company',
		'job_title',
		'member_type',
		'category',
		/*
		'address',
		'local_number',
		'country',
		'region',
		'ville',
		'phonenumber1',
		'phonenumber2',
		'mobile_number',
		'tollfree_number',
		'fax',
		'email',
		'site_address',
		'subscription',
		'created_date',
		'modified_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
