<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->title = 'Vue détaillée de la transaction #' . $model->id;
$this->breadcrumbs = array(
    'Transactions de paiement Optirep' => array('/admin/paymentTransaction/reptransaction'),
    'Voir transaction',
);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Payment Details</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
                <?php
                $this->widget('zii.widgets.CDetailView', array(
                    'data' => $model,
                    'htmlOptions' => array('class' => 'table table-striped table-bordered'),
                    'attributes' => array(
                        'item_name',
                        'invoice_number',
                        'total_price',
                        'subscription_price',
                        'tax',
                        'txn_id',
                        array('name' => 'payment_status',
                            'type' => 'raw',
                            'value' => (($model->payment_status==="Pending")?'<span class="label label-warning">Pending</span>':'<span class="label label-success">Completed</span>'),
                        ),
                        'payer_email',
                        'verify_sign',
                        'payment_type',
                        'receiver_email',
                        'txn_type',
                        'created_at',
                    ),
                ));
                ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>




