<?php
/* @var $this SuppliersDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des fournisseurs';
$this->breadcrumbs = array(
    'Gestion des fournisseurs',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp; Ajouter un fournisseur ', array('/admin/suppliersDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gettypes = CHtml::listData(SupplierType::model()->findAll(), 'ID_TYPE_FOURNISSEUR', 'TYPE_FOURNISSEUR_FR');

        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
             array(
              'name' =>  'COMPAGNIE',
              'sortable' => false,
            ),
            array(
                'header' => 'Type de fournisseurs',
                'name' => 'supplierType.TYPE_FOURNISSEUR_FR',
                'value' => $data->supplierType->TYPE_FOURNISSEUR_FR,
                'filter' => CHtml::activeDropDownList($model, 'ID_TYPE_FOURNISSEUR', $gettypes, array('class' => 'form-control', 'prompt' => 'Tous')),
            ),
            array(
                'header' => 'État',
                'name' => 'bAfficher_site',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'sortable' => false,
                'value' => function($data) {
            echo ($data->bAfficher_site == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
        },
                'filter' => CHtml::activeDropDownList($model, 'bAfficher_site', array("1" => "Activés", "0" => "Désactivés"), array('class' => 'form-control', 'prompt' => 'Tous')),
            ),
             array(
              'name' => 'ID_CLIENT',
              'sortable' => false,
            ),
//            array(
//                'header' => "Accès",
//                'type' => 'raw',
//                'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle'),
//                'value' => function($data) {
//            return CHtml::link("<i class='fa fa-lock'></i>", array("/admin/userDirectory/create/", "relid" => $data->ID_FOURNISSEUR, "nomtable" => "Fournisseurs"));
//        },
//            ),
            array(
                'header' => 'Actes',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{access}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'access' => array(
                        'label' => "<i class='fa fa-lock'></i>",
                        'url' => 'Yii::app()->createUrl("/admin/userDirectory/create", array("relid"=>$data->ID_FOURNISSEUR, "nomtable"=>"Fournisseurs"))',
                        'options' => array("title" => "Accès")
                    )
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'ajaxUrl' => $this->createUrl('suppliersDirectory/index'),
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des fournisseurs</h3></div><div class="panel-body">{items}{pager}<div class="pull-right">{summary}</div></div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>