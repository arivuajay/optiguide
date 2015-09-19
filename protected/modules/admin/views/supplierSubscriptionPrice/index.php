<?php
/* @var $this SupplierSubscriptionPriceController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Fournisseur Prix de l\'abonnement';
$this->breadcrumbs=array(
	'Fournisseur Prix de l\'abonnement',
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
        'profile_price',
        'profile_logo_price',
        array(
            'header' => 'Actes',
            'class' => 'booster.widgets.TbButtonColumn',
            'updateButtonUrl'=>'Yii::app()->createUrl("/admin/supplierSubscriptionPrice/update/", array("id"=>$data->id,"type"=>"supplier"))',
            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
            'template' => '{update}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(       
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Prix de l\'abonnement</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>