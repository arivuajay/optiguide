<?php
/* @var $this AuthresourcesController */
/* @var $model AuthResources */

$this->breadcrumbs = array(
    'Auth Resources' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List AuthResources', 'url' => array('index')),
    array('label' => 'Create AuthResources', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#auth-resources-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Auth Resources</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'auth-resources-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'Master_Resource_ID',
        'Master_User_ID',
        'Master_Role_ID',
        'Master_Module_ID',
        'Master_Screen_ID',
        'Master_Task_ADD',
        /*
          'Master_Task_SEE',
          'Master_Task_UPT',
          'Master_Task_DEL',
          'Active',
          'Created_Date',
          'Rowversion',
         */
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
