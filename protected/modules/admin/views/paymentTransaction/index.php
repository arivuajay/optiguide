<?php
/* @var $this PaymentTransactionController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Fournisseurs transactions de paiement';
$this->breadcrumbs=array(
	'Fournisseurs transactions de paiement',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
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
                    'name' => 'suppliersDirectory.COMPAGNIE',
                    'value' => $data->suppliersDirectory->COMPAGNIE,    
                    'filter' => CHtml::activeTextField($model, 'COMPAGNIE' , array('class'=>'form-control')),                    
                 ), 
                array(
                    'name' => 'subscription_price',
                    'value' => $data->subscription_price,    
                    'filter' =>false,                    
                 ),
		array(
                    'header'  => 'Type de rémunération',    
                    'name'    => 'pay_type',
                    'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),             
                    'type' => 'raw',
                    'value' => function($data) {
                         echo ($data->pay_type == 1) ? "Paypal" : "Strype";
                     }, 
                     'filter' => false,   
                ), 
                array(
                    'header'  => 'Type d\'abonnement',    
                    'name'    => 'subscription_type',
                    'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),             
                    'type' => 'raw',
                    'value' => function($data) {
                         echo ($data->subscription_type == 1) ? "Profile only" : "Profile & Logo";
                     },
                     'filter' => false,   
                ),
                array('name' => 'payment_status',
                    'type' => 'raw',
                    'value' => function($data){
                        echo ($data->payment_status == "Pending") ? '<span class="label label-warning">Pending</span>' : '<span class="label label-success">Completed</span>';
                    },
                    'filter' => false,
                ),
                array(
                    'name' => 'created_at',
                    'filter' => false,    
                 ),    
		/*
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
        'header' => 'Actes',
        'class' => 'booster.widgets.TbButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}',
         'buttons'=> array(
                    'update'=>array(                                    
                              'visible'=>'$data->payment_status=="Pending"',
                                ),                                  
                     ),
                ),
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Fournisseurs transactions de paiement</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>