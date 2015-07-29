<?php
/* @var $this GroupInformationController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des associations';
$this->breadcrumbs=array(
	'Gestion des associations',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);

$btntitle = 'Ajouter une association';
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;'.$btntitle, array('/admin/groupInformation/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
        	//'ID_SECTION',
		'NOM_GROUPE',
		'ADRESSE',				
		'CODE_POSTAL',
		/*
		'TELEPHONE',
		'TELECOPIEUR',
		'COURRIEL',
		'SITE_WEB',
		'PREFIXE_REPRESENTANT_FR',
		'PREFIXE_REPRESENTANT_EN',
		'NOM_REPRESENTANT',
		'TITRE_REPRESENTANT_FR',
		'TITRE_REPRESENTANT_EN',
		*/
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
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Associations - '.$model->getsectionname().'</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>