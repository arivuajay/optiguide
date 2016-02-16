<?php
$this->title = 'Gestion des regroupement de détaillants';
$this->breadcrumbs = array(
    $this->title
);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp; Ajouter un sales rep ', array('/admin/repCredential/create'), array('class' => 'btn btn-success pull-right')); ?>
         <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => 'Ajouter un retailer group',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/retailerGroup/create'),
            'buttonType' => 'link',
            'context' => 'success',
            'htmlOptions' => array('class' => 'pull-right'),
                )
        );
        ?>
    </div>
</div>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gettypes = CHtml::listData(RetailerType::model()->findAll(), 'ID_RETAILER_TYPE', 'NOM_TYPE_FR');
        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'header' => 'Retailer Type',
                'name' => 'retailerType.NOM_TYPE_FR',
                'value' => $data->retailerType->NOM_TYPE_FR,
                'filter' => CHtml::activeDropDownList($model, 'ID_RETAILER_TYPE', $gettypes, array('class' => 'form-control', 'prompt' => 'Tous')),
            ),
            array(
                'name' => 'NOM_GROUPE',
                'sortable' => false
            ),
            
//                array(
//                'name' => 'rep_status',
//                'type' => 'raw',
//                'value' => function($data) {
//                    echo ($data->rep_status == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
//                },
//                'filter' => CHtml::activeDropDownList($model, 'rep_status', array("1" => "Active", "0" => "In-Active"), array('class' => 'form-control', 'prompt' => 'Tous')),
//                'sortable' => false
//            ),
            
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',         
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array(
                        'visible' => 'AdminIdentity::checkAccess(NULL, "retailerGroup", "update")',
                    ),
                    'delete' => array(
                        'visible' => 'AdminIdentity::checkAccess(NULL, "retailerGroup", "delete")',
                        'click'=>'function(){return confirm("Etes-vous sûr de vouloir supprimer ce groupe ? il affecte aussi le détaillants");}'
                    ),
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => "<div class='panel panel-primary'><div class='panel-heading'><div class='pull-right'>{summary}</div><h3 class='panel-title'><i class='glyphicon glyphicon-book'></i>  Sales Rep </h3></div>\n<div class='panel-body'>{items}\n{pager}</div></div>",
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>