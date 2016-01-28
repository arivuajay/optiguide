<?php
/* @var $this ExportDatasController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Datas exportation de fournisseurs';
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp; Générer les données', array('/admin/exportDatas/generate_suppliers'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            'attachment_file',           
            'created',
            array(
            'header' => 'Actes',
            'class' => 'application.components.MyActionButtonColumn',
            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
            'template' => '{download}&nbsp;&nbsp;&nbsp;{delete}',
            'buttons' => array(                           
                    'download' => array(
                       'label' => "<i class='fa fa-download'></i>",                         
                       'url' => '(file_exists(YiiBase::getPathOfAlias("webroot")."/uploads/export_datas/".$data->attachment_file)) ? Yii::app()->createAbsoluteUrl("/uploads/export_datas/".$data->attachment_file) : ""',                            
                       'options' => array('class' => 'newWindow','title' => "Download file" ),
                    ),
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(       
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search("Supplier"),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Datas de fournisseurs</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>