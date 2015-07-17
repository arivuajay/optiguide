<?php
/* @var $this UserDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Utilisateurs';
$this->breadcrumbs=array(
	'Utilisateurs',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un utilisateur', array('/admin/userdirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $getnoms =  UserDirectory::model()->findAll(array(
            'select'=>'t.NOM_TABLE',
            'group'=>'t.NOM_TABLE',
            'distinct'=>true,
           ));
        
        $gridColumns = array(
        	//'LANGUE',
		//'PREFIXE',
		'NOM_UTILISATEUR',
		'USR',             
               array(
                    'name'=>'NOM_TABLE',          
                    'value' => '$data->NOM_TABLE',
                    'filter'  => CHtml::activeDropDownList($model, 'NOM_TABLE', CHtml::listData($getnoms , 'NOM_TABLE', 'NOM_TABLE'), array('class'=>'form-control','prompt'=>'All')),                    
                ),
		/*'PWD',
		'COURRIEL',		
		'ABONNE_MAILING',
		'ABONNE_PROMOTION',
		'ABONNE_TRANSITION',
		'IS_FIRST_LOG',
		'NOM_TABLE',
		'ID_RELATION',
		'MUST_VALIDATE',
		'sGuid',
		'bSubscription_envision',
		'bSubscription_envue',
		*/
        array(
        'header' => 'Actions',
        'class' => 'booster.widgets.TbButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{update}{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'ajaxUrl' => $this->createUrl('userdirectory/index'),
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Utilisateurs</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>
