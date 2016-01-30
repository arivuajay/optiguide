<?php
/* @var $this ClientProfilesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Les profils des clients';
$this->breadcrumbs = array(
    'Les profils des clients',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Créer un profil de client', array('/admin/clientProfiles/create'), array('class' => 'btn btn-success pull-right')); ?>
        <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => 'Créer un profil de client',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/clientProfiles/create'),
            'buttonType' => 'link',
            'context' => 'success',
            'htmlOptions' => array('class' => 'pull-right'),
                )
        );
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'name',
            'company',
            'job_title',
              array(
                'name' => 'clientMessages2.employee_id',              
                'type' => 'raw',
                'filter' => false,
                //call the method 'gridDataColumn' from the controller
                'value' => 'EmployeeProfiles::model()->findByPk($data->clientMessages2->employee_id)->employee_name',
                 
            ),
              array(
                   'header' => "Alert Date",
                   'type' => 'raw',
                   'value' => function($data) {
                        return Myclass::dateFormat($data->clientMessages2->date_remember);
                   },           
                ),
            array(
              'name' => 'ID_CLIENT',
              'sortable' => false,
            ),
            /*
              'local_number',
              'country',
              'region',
              'ville',
              'phonenumber1',
              'phonenumber2',
              'mobile_number',
              'tollfree_number',
              'fax',
              'email',
              'site_address',
              'subscription',
              'created_date',
              'modified_date',
             */
            array(
                'header' => 'Actes',
                'class' => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}',
            )
        );
                   
        //$export_btn = $this->renderExportGridButton('client-base-grid', '<i class="fa fa-file-excel-o"></i> Export', array('class' => 'btn btn-xs btn-danger  pull-right'));

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'id' => 'client-base-grid',
            'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
           // 'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}&nbsp;' . $export_btn . '</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Les profils des clients</h3></div><div class="panel-body">{items}{pager}</div></div>',
             'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary} </div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Les profils des clients</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>