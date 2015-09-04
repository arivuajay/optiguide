<?php
/* @var $this SectionInformationController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des sections' ;
$this->breadcrumbs=array(
	'Gestion des sections' ,
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
$buttontitle = 'Ajouter une section';
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;'.$buttontitle, array('/admin/sectionInformation/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
        	//'ID_CATEGORIE',
		'SECTION_FR',
		//'SECTION_EN',
        array(
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}',
                'buttons' => array(
                    'view' => array(
                        // 'imageUrl'=>Yii::app()->request->baseUrl.'/css/gridViewStyle/images/gr-plus.png',
                        'url' => 'Yii::app()->createUrl("admin/groupInformation/index", array("id"=>$data->ID_SECTION))',
                    // 'options' => array('class' => 'editevent'),
                    ),
                )
            )
            ,    
        array(
        'header' => 'Actes' ,
        'class' => 'booster.widgets.TbButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Sections  - '.$model->getcategoryname().'</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>