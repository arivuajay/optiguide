<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->title='Vue détaillée de la transaction #'.$model->id;
$this->breadcrumbs=array(
	'Fournisseurs transactions de paiement'=>array('index'),
	'Voir transaction',
);
?>
<div class="user-view">
       
    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
	'attributes'=>array(		
		'suppliersDirectory.COMPAGNIE',
                'item_name',
                'NOMTABLE',		
		'invoice_number',
		'subscription_price',
                'txn_id',
		'payment_status',
		'payer_email',
		'verify_sign',		
		'payment_type',
		'receiver_email',
		'txn_type',
		'created_at',
		
	),
)); ?>
</div>



