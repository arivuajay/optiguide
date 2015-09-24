<?php
/* @var $this ClientMessagesController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Rappelez-vous des alertes';
$this->breadcrumbs=array(
	'Rappelez-vous des alertes',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Créer l\'alerte de message', array('/admin/clientMessages/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
                array(
                'name'    => 'clientProfiles.name',
                'value'   => $data->clientProfiles->name,
                ),            
		 array(
                'name'    => 'employeeProfiles.employee_name',
                'value'   => $data->employeeProfiles->employee_name,
                ), 		
                array('name' => 'date_remember',
                   'type' => 'raw',
                   'value' => function($data){
                       echo date("d-m-Y",strtotime($data->date_remember));
                   },
                   'filter' => false,
               ),
                array('name' => 'status',
                   'type' => 'raw',
                   'value' => function($data){
                       echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                   },
                   'filter' => false,
               ),
		/*
		'status',
		'created_date',
		*/
        array(
        'header' => 'Actes',
        'class' => 'booster.widgets.TbButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{view}{update}{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        //'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Rappelez-vous des alertes</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>