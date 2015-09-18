<?php
/* @var $this PaymentTransactionController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Transactions de paiement Optirep';
$this->breadcrumbs=array(
	'Transactions de paiement Optirep',
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
                         echo ($data->subscription_type == 3) ? "Statistics Subscription" : "Renew Statistics Subscription";
                     },
                     'filter' => false,   
                ),
                 array(
                    'name' => 'payment_status',
                    'filter' => false,    
                 ),
                array(
                    'name' => 'created_at',
                    'filter' => false,    
                 ),    		
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
        'dataProvider' => $model->searchrep(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Transactions de paiement Optirep</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>