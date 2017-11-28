<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->title = 'Vue détaillée de la transaction';
$this->breadcrumbs = array(
    'Transactions de paiement' => array('update', "id" => $pmodel->user_id),
    'Voir transaction',
);

$attrbs = array();
if ($pmodel->pay_type == 1) {
// PAYPAL    
    $attrbs = array(
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
} elseif ($pmodel->pay_type == 2) {
// PAYPAL  Advance
    $attrbs = array(
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
} elseif ($pmodel->pay_type == 3) {


    // CHEQUE and FREE 
    $attrbs = array(
        'item_name',
        'invoice_number',
        'subscription_price',
        array(
            'name' => 'Number of months',
            'value' => function ($data) {
//                print_r($data->repCredentials);exit;
                foreach ($data->repCredentials->repSingleSubscriptions as $value):
                    return $value ['rep_single_no_of_months'];
                endforeach;
            },
            'type' => 'raw'
        ),
        'tax',
        array(
            'name' => 'Prix De L’abonnement',
            'value' => function ($data) {
                foreach ($data->repCredentials->repSingleSubscriptions as $value):
                    return $value ['rep_single_grand_total'];
                endforeach;
            },
            'type' => 'raw'
        ),
        'created_at',
    );
}elseif ($pmodel->pay_type == 4) {
    $attrbs = array(
        'item_name',
        'invoice_number',
        'subscription_price',
        'total_price',
        'created_at',
    );
}
?>
<div class="user-view">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $pmodel,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => $attrbs
    ));

    if ($pmodel->pay_type == 3) {
        ?>
        <div class="box-header">
            <h3 class="box-title">Cheque Informations</h3>
        </div>
        <?php
        $pcmodel = PaymentCheques::model()->find("payment_transaction_id='$pmodel->id'");
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $pcmodel,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
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



