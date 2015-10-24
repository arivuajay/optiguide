<?php
/* @var $this NewsManagementController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des nouvelles';
$this->breadcrumbs = array(
    'Gestion des nouvelles',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter une nouvelle', array('/admin/newsManagement/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php  $this->renderPartial('_search', array('model' => $model));  ?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'TITRE',
            'LANGUE',
            'DATE_AJOUT1',
	    'DATE_AJOUT2',	
            array(
                'header' => 'Actes',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
            ),
            array(
                'name' => 'datedisplay',
                'value' => 'substr($data->DATE_AJOUT1,0,7)',
                'headerHtmlOptions' => array('style' => 'display:none'),
                'htmlOptions' => array('style' => 'display:none')
            )
        );

        $this->widget('booster.widgets.TbGroupGridView', array(
           // 'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des nouvelles</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'extraRowColumns' => array('datedisplay'),
            'extraRowExpression' => '"<b style=\"font-size: 20px; color: #333;\">".date("F",strtotime($data->DATE_AJOUT1))." ".date("Y",strtotime($data->DATE_AJOUT1))."</b>"',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){    
        $.fn.dataTableExt.sErrMode = 'throw';     
    });
</script>