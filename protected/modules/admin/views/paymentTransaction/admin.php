<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->breadcrumbs=array(
	'Payment Transactions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PaymentTransaction', 'url'=>array('index')),
	array('label'=>'Create PaymentTransaction', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#payment-transaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Payment Transactions</h1>

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
	'id'=>'payment-transaction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_id',
		'subscription_price',
		'payment_status',
		'payer_email',
		'verify_sign',
		/*
		'txn_id',
		'payment_type',
		'receiver_email',
		'txn_type',
		'item_name',
		'created_at',
		'updated_at',
		'NOMTABLE',
		'expirydate',
		'invoice_number',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
