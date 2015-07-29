<?php
/* @var $this ArchiveFichierController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Archive Fichiers';
$this->breadcrumbs=array(
	'Archive Fichiers',
);
$themeUrl = $this->themeUrl;

$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un nouveau fichier', array('/admin/archiveFichier/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(        		
		'TITRE_FICHIER_FR',
                'FICHIER',				
		'EXTENSION',		
                array(
                    'header' => 'Actions',
                    'class' => 'booster.widgets.TbButtonColumn',
                    'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                    'template' => '{view}{update}{delete}',
                    'buttons' => array(                           
                           'view' => array(
                               'url' => 'Yii::app()->createAbsoluteUrl("/uploads/archivage/".$data->ID_CATEGORIE."/".$data->FICHIER)',
                               'options' => array('class' => 'newWindow' ),
                           ),
                        ),
                    ),
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
      //  'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Archive Fichiers - '.$model->getcategoryname().'</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>
<?php
$js = <<< EOD
$(document).ready(function(){
    $(".newWindow").click(function(e)
    {
        e.preventDefault();
        var url=$(this).attr('href');
        window.open(url, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=100, left=100, width=1020, height=500");
    });
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>        