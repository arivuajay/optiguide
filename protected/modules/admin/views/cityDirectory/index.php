<?php
/* @var $this CityDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des villes';
$this->breadcrumbs=array(
	'Gestion des villes',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter une ville', array('/admin/cityDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>


<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $regions = Myclass::getallregions();  
        $gridColumns = array(
        	'NOM_VILLE',
             array(              
                'name'    => 'regionDirectory.NOM_REGION_FR',             
                'filter'  => CHtml::activeDropDownList($model, 'ID_REGION', $regions , array('class'=>'form-control','prompt'=>'Tous'))
                ), 
             array(
            'header' => Myclass::t('APP46'),
            'class' => 'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
            'template' => '{update}'
             )    
            );
        
           
        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'ajaxUrl' => $this->createUrl('cityDirectory/index'),
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Villes'.'</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
            )
        );
        ?>
    </div>
</div>