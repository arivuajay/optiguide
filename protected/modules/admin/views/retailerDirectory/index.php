<?php
/* @var $this RetailerDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des détaillants';
$this->breadcrumbs = array(
    'Gestion des détaillants',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un détaillant', array('/admin/retailerDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        //$createurl = Yii::app()->createUrl('/admin/userDirectory/create',$params);
        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            'COMPAGNIE',
            //  'ID_CLIENT',
            //  'ADRESSE',
            //   'CODE_POSTAL',           
            array(
                'header' => 'Type de retailer',
                'name' => 'retailerType.NOM_TYPE_FR',
                'value' => $data->retailerType->NOM_TYPE_FR,
                'filter' => CHtml::activeDropDownList($model, 'ID_RETAILER_TYPE', CHtml::listData(RetailerType::model()->findAll(), 'ID_RETAILER_TYPE', 'NOM_TYPE_FR'), array('class' => 'form-control', 'prompt' => 'Tous')),
            ),
            array(
                'name' => 'DATE_MODIFICATION',
                'filter' => false
            ),
            array(
                'name' => 'CREATED_DATE',
                'filter' => false
            ),
            array(
                'header' => "Alert Date",
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::link(Myclass::dateFormat($data->retailerMessages2->date_remember), array("/admin/retailerDirectory/update/", "id" => $data->ID_RETAILER, "alerthistory" => 1));
                },
                    ),
//                    array(
//                        'header' => "Accès",
//                        'type' => 'raw',
//                        'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle'),
//                        'value' => function($data) {
//                    // return "{$data->cntUsr} X " . CHtml::link("<i class='fa fa-lock'></i>", array("/admin/userDirectory/create/", "relid" => $data->ID_RETAILER,"nomtable"=>"Detaillants"));
//                    return CHtml::link("<i class='fa fa-lock'></i>", array("/admin/userDirectory/create/", "relid" => $data->ID_RETAILER, "nomtable" => "Detaillants"));
//                },
//                    ),
//            array(
//                'header'  => 'User status',    
//                'name'    => 'uaccess_search',
//                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),             
//                'type' => 'raw',              
//                'value' => function($data) {
//                     echo ($data->userDirectory->MUST_VALIDATE == "1") ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
//                },
//             //   'filter'  => CHtml::activeDropDownList($umodel, 'MUST_VALIDATE',  array("1"=>"Activés" ,"0"=>"Désactivés" ) , array('class'=>'form-control','prompt'=>'Tous')),
//               'filter' => ''
//            ), 
                    array(
                        'header' => 'Actes',
                        'class' => 'booster.widgets.TbButtonColumn',
                        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                        'template' => '{access}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                        'buttons' => array(
                            'access' => array(
                                'label' => "<i class='fa fa-lock'></i>",
                                'url' => 'Yii::app()->createUrl("/admin/userDirectory/create", array("relid"=>$data->ID_RETAILER, "nomtable"=>"Detaillants"))',
                                'options' => array("title" => "Accès")
                            )
                        ),
                    )
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
                    'filter' => $model,
                    'ajaxUrl' => $this->createUrl('retailerDirectory/index'),
                    'type' => 'striped bordered datatable',
                    'dataProvider' => $model->search(),
                    'responsiveTable' => true,
                    'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Détaillant</h3></div><div class="panel-body">{items}{pager}<div class="pull-right">{summary}</div></div></div>',
                    'columns' => $gridColumns
                        )
                );
                ?>
    </div>
</div>