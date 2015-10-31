<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->title='Vue détaillée de la transaction';
$this->breadcrumbs=array(
	'Fournisseurs transactions de paiement'=>array('index'),
	'Voir transaction',
);


$attrbs = array();
if($model->pay_type==1)   
{ 
// PAYPAL    
    $attrbs =    array(				
                        'item_name',
                        'invoice_number',
                        'subscription_price',
                        'tax',
                        'total_price',
                        'txn_id',
                        'payment_status',
                        'payer_email',
                        'verify_sign',		
                        'payment_type',
                        'receiver_email',
                        'txn_type',
                        'created_at',
                );
}elseif($model->pay_type==2)
{
// PAYPAL  Advance
    $attrbs =    array(				
                        'item_name',                       		
                        'invoice_number',
                        'subscription_price',
                        'tax',
                        'total_price',
                        'txn_id',
                        'payment_status',
                        'payment_type',
                        'created_at',
		);
    
}elseif($model->pay_type==3 || $model->pay_type==4)
{
    // CHEQUE and FREE 
    $attrbs =    array(				
                        'item_name',
                        'invoice_number',
                        'subscription_price',  
                        'tax',
                        'total_price',
                        'created_at',
		);
    
}
?>
<div class="user-view">
       
    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
	'attributes'=>$attrbs,
)); 
    
    if($model->pay_type==3)
    {
        ?>
     <div class="box-header">
        <h3 class="box-title">Cheque Informations</h3>
    </div>
    <?php
        $pcmodel = PaymentCheques::model()->find("payment_transaction_id='$model->id'");    
         $this->widget('zii.widgets.CDetailView', array(
	'data'=>$pcmodel,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
	'attributes' => array(
            'cheque_num',
            'cheque_account_name',
            'cheque_bank',
            'cheque_account_type',
            'cheque_date',
            'cheque_price',
            'notes',
            )
        )); 
    }   
    ?> 
</div>





