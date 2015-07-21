<?php
/* @var $this ProductDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Gestion des produits & services';
$this->breadcrumbs=array(
	'Gestion des produits & services',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un produit ou service', array('/admin/productDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(        	
        array(
           'header'  =>  'Section',    
           'name'    => 'sectionDirectory.NOM_SECTION_FR',          
           'filter'  => CHtml::activeDropDownList($model, 'ID_SECTION', CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_FR")), 'ID_SECTION', 'NOM_SECTION_FR'), array('class'=>'form-control','prompt'=>'All')),
           ),
        'NOM_PRODUIT_FR',
        'NOM_PRODUIT_EN',
        array(
        'header' => 'Actions',
        'class' => 'booster.widgets.TbButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{update}{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'ajaxUrl' => $this->createUrl('productDirectory/index'),
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des produits & services</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>

