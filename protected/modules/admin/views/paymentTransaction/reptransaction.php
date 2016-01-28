<?php
/* @var $this PaymentTransactionController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Transactions de paiement Optirep';
$this->breadcrumbs = array(
    'Transactions de paiement Optirep',
);
?>


<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'name' => 'repCredentials.rep_username',
                'value' => '$data->getTransactionUserName($data->id)',
                'filter' => false,
            ),
            array(
                'name' => 'total_price',
                'filter' => false,
            ),
            array(
                'header' => 'Type de rémunération',
                'name' => 'pay_type',
                'type' => 'raw',
                'value' => function($data) {
                         if($data->pay_type == 1) 
                             echo "Paypal";
                         elseif($data->pay_type == 2) 
                             echo "Credit Card";
                         elseif($data->pay_type == 3) 
                             echo "Cheque";
                         elseif($data->pay_type == 4) 
                             echo "Free";
                     }, 
                'filter' => false,
            ),
            array(
                'header' => 'Nom de l\'abonnement',
                'name' => 'item_name',
                'type' => 'raw',
                'filter' => false,
            ),
            array('name' => 'payment_status',
                'type' => 'raw',
                'value' => function($data) {
                    echo ($data->payment_status == "Pending") ? '<span class="label label-warning">Pending</span>' : '<span class="label label-success">Completed</span>';
                },
                'filter' => false,
            ),
            array(
                'name' => 'created_at',
                'filter' => false,
            ),
            array(
                'header' => 'Actes',
                'class' => 'booster.widgets.TbButtonColumn',                
                'viewButtonUrl' => 'Yii::app()->createUrl("/admin/paymentTransaction/repview/", array("id"=>$data->id))',
                'updateButtonUrl' => 'Yii::app()->createUrl("/admin/paymentTransaction/repUpdateStatus/", array("id"=>$data->id))',
                'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}',
                'buttons' => array(
                    'update' => array(
                        'visible' => '$data->payment_status=="Pending" && AdminIdentity::checkAccess_others(NULL, NULL,NULL, "update")',
                    ),
                ),
            ),
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->searchrep(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Transactions de paiement Optirep</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns,
            'enableSorting' => false
                )
        );
        ?>
    </div>
</div>