<?php
/* @var $this PublicityAdsController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Gestion des publicités';
$this->breadcrumbs=array(
	'Gestion des publicités',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>
<div class="col-lg-12 col-md-12">
    <div class="row"> <i title="Active" class="fa fa-circle hint-ads_active"></i>&nbsp;<span>Active publicités </span>&nbsp; </div>
</div>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter une publicité', array('/admin/publicityAds/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    
    <div class="row">        
        <?php
        $dresults = $model->search(); 
        $gridColumns = array(
         array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ), 
        'TITRE',    
        'DATE_DEBUT',
        'DATE_FIN',
        'NB_IMPRESSIONS_FAITES',
        'CLICK_RATE',    
        array(
            'header' => 'Actions',
            'class' => 'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
            'template' => '{update}{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'bordered datatable',
        'dataProvider' => $model->search(),
        'enableSorting' => false,
        'rowCssClassExpression'=>'(strtotime($data->DATE_FIN) > time())?"ads_active":"ads_expired"',
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des publicités</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>