<?php
/* @var $this AdminController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Admin users';
$this->breadcrumbs=array(
	'Admin users',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create User', array('/admin/admin/create'), array('class' => 'btn btn-success pull-right')); ?>
         <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => 'Create User',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/admin/create'),
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
        	'admin_name',
		'admin_username',				
		'admin_email',
                 array(
                'header'  =>  'Role', 
                'name'    => 'roleMdl.Description',          
                'filter'  => CHtml::activeDropDownList($model, 'role', CHtml::listData(MasterRole::model()->findAll(array('condition'=>"Master_Role_ID!=1",'order' => 'Role_Code')), 'Master_Role_ID', 'Description'), array('id' => '', 'class'=>'form-control','prompt'=>'All'))                     
                ),  
                array(
                        'header' => 'status',
                        'name' => 'admin_status',
                        'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                        'type' => 'raw',
                        'sortable' => false,
                        'value' => function($data) {
                    echo ($data->admin_status == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
                }),
		'created_date',
		/*
		'admin_last_login',
		'admin_login_ip',
		'role',
		*/
            array(
            'header' => 'Actions',
            //'class' => 'booster.widgets.TbButtonColumn',
            'class' => 'application.components.MyActionButtonColumn',
            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
            'template' => '&nbsp;{update}&nbsp;&nbsp;{delete}',
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Admin users</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>