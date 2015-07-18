<?php
/* @var $this RegionDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = Myclass::t('APP107');
$this->breadcrumbs = array(
    $this->title,
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);

$countries = Myclass::getallcountries();
?> 
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;' . Myclass::t('APP504') . ' ' . Myclass::t('APP106'), array('/admin/regiondirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'NOM_REGION_FR',
            array(
                'name' => 'countryDirectory.NOM_PAYS_FR',
                'filter' => CHtml::activeDropDownList($model, 'ID_REGION', $countries, array('class' => 'form-control', 'prompt' => 'All'))
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
            'ajaxUrl' => $this->createUrl('regiondirectory/index'),
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  ' . Myclass::t('APP106') . '</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>