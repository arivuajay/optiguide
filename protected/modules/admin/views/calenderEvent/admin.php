<?php
/* @var $this CalendarEventsController */
/* @var $model CalendarEvents */

$this->breadcrumbs=array(
	'Calendar Events'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CalendarEvents', 'url'=>array('index')),
	array('label'=>'Create CalendarEvents', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#calendar-events-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Calendar Events</h1>

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
	'id'=>'calendar-events-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID_EVENEMENT',
		'LANGUE',
		'DATE_AJOUT1',
		'DATE_AJOUT2',
		'TITRE',
		'TEXTE',
		/*
		'LIEN_URL',
		'LIEN_TITRE',
		'AFFICHER_SITE',
		'AFFICHER_ACCUEIL',
		'AFFICHER_ARCHIVE',
		'ID_PAYS',
		'ID_REGION',
		'ID_VILLE',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
