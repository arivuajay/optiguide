<?php
/* @var $this EmployeeProfilesController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Profils d\'employés';
$this->breadcrumbs=array(
	'Profils d\'employés',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Créer un profil d\' employé', array('/admin/employeeProfiles/create'), array('class' => 'btn btn-success pull-right')); ?>
         <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => 'Créer un profil d\' employé',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/employeeProfiles/create'),
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
        	'employee_name',
		'employee_email',
        array(
        'header' => 'Actes',
        'class' => 'application.components.MyActionButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Profils d\'employés</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>