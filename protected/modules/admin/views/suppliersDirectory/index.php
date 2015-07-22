<?php
/* @var $this SuppliersDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Suppliers Directories';
$this->breadcrumbs=array(
	'Suppliers Directories',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create SuppliersDirectory', array('/admin/suppliersDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
                'COMPAGNIE',
		
		/*
                'ID_CLIENT',
		'ID_TYPE_FOURNISSEUR', 
                'ADRESSE',
		'ADRESSE2',
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELECOPIEUR',
		'TITRE_TEL_SANS_FRAIS',
		'TITRE_TEL_SANS_FRAIS_EN',
		'TEL_SANS_FRAIS',
		'TITRE_TEL_SECONDAIRE',
		'TITRE_TEL_SECONDAIRE_EN',
		'TEL_SECONDAIRE',
		'COURRIEL',
		'SITE_WEB',
		'SUCCURSALES',
		'ETABLI_DEPUIS',
		'NB_EMPLOYES',
		'PERSONNEL_NOM1',
		'PERSONNEL_TITRE1',
		'PERSONNEL_TITRE1_EN',
		'PERSONNEL_NOM2',
		'PERSONNEL_TITRE2',
		'PERSONNEL_TITRE2_EN',
		'PERSONNEL_NOM3',
		'PERSONNEL_TITRE3',
		'PERSONNEL_TITRE3_EN',
		'DATE_MODIFICATION',
		'REGIONS_FR',
		'REGIONS_EN',
		'bAfficher_site',
		'iId_fichier',
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
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Suppliers Directories</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>