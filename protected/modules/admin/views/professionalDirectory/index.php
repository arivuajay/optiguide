<?php
/* @var $this ProfessionalDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Gestion des professionnels';
$this->breadcrumbs=array(
	'Gestion des professionnels',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);


?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un professionnel', array('/admin/professionalDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
         $gettypes =  ProfessionalType::model()->findAll(array('group'=>'t.TYPE_SPECIALISTE_FR'));
         
        $gridColumns = array(               	
		'PRENOM',
		'NOM',
                 array(
                'header'  => 'Type de professionnel',    
                'name'    => 'professionalType.TYPE_SPECIALISTE_FR',
                'value'   => $data->professionalType->TYPE_SPECIALISTE_FR,
                'filter'  => CHtml::activeDropDownList($model, 'ID_TYPE_SPECIALISTE', CHtml::listData($gettypes , 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_FR'), array('class'=>'form-control','prompt'=>'Tous')),
                ),            
                'ID_CLIENT',			
                array(
                'header' => 'actes',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}{delete}',
                )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'ajaxUrl' => $this->createUrl('professionalDirectory/index'),
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des professionnels</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>