<?php
/* @var $this ManagementAdviceController */
/* @var $model ManagementAdvice */

$this->breadcrumbs=array(
	'Management Advices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ManagementAdvice', 'url'=>array('index')),
	array('label'=>'Create ManagementAdvice', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#management-advice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Management Advices</h1>

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
	'id'=>'management-advice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID_CONSEIL',
		'LANGUE',
		'TITRE',
		'SYNOPSYS',
		'TEXTE',
		'LIEN_URL',
		/*
		'LIEN_TITRE',
		'AFFICHER_SITE',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
