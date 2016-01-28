<?php
/* @var $this ProfessionalDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des professionnels';
$this->breadcrumbs = array(
    'Gestion des professionnels',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un professionnel', array('/admin/professionalDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
         <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => 'Ajouter un professionnel',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/professionalDirectory/create'),
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
        $gettypes = ProfessionalType::model()->findAll(array('group' => 't.TYPE_SPECIALISTE_FR'));

        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'name' => 'NOM',
                'sortable' => false
            ),
            array(
                'name' => 'PRENOM',
                'sortable' => false
            ),
            array(
                'header' => 'Type de professionnel',
                'name' => 'professionalType.TYPE_SPECIALISTE_FR',                
                'value' => $data->professionalType->TYPE_SPECIALISTE_FR,
                'filter' => CHtml::activeDropDownList($model, 'ID_TYPE_SPECIALISTE', CHtml::listData($gettypes, 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_FR'), array('class' => 'form-control', 'prompt' => 'Tous')),
                
            ),
            array(
              'name' => 'ID_CLIENT',
              'sortable' => false,
            ),
            array(
                'name' => 'DATE_MODIFICATION',
                'filter' => false,
                'sortable' => false
            ),
            array(
                'name' => 'CREATED_DATE',
                'filter' => false,
                'sortable' => false
            ),
            // 'ID_CLIENT',	
            array(
                'header' => "Alert Date",
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::link(Myclass::dateFormat($data->professionalMessages2->date_remember), array("/admin/professionalDirectory/update/", "id" => $data->ID_SPECIALISTE, "alerthistory" => 1));
                },
                    ),
//                array(
//                   'header' => "Accès",
//                   'type' => 'raw',
//                   'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle'),
//                   'value' => function($data) {
//                         return CHtml::link("<i class='fa fa-lock'></i>", array("/admin/userDirectory/create/", "relid" => $data->ID_SPECIALISTE,"nomtable"=>"Professionnels"));
//                   },
//               ),
                    array(
                        'header' => 'Actes',
                        'class' => 'application.components.MyActionButtonColumn',
                        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                        'template' => '{access}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                        'buttons' => array(
                            'access' => array(
                                'label' => "<i class='fa fa-lock'></i>",
                                'url' => 'Yii::app()->createUrl("/admin/userDirectory/create", array("relid"=>$data->ID_SPECIALISTE, "nomtable"=>"Professionnels"))',
                                'options' => array("title" => "Accès"),
                                'visible' => 'AdminIdentity::checkAccess(NULL, "professionalDirectory", "update")'
                            )
                        ),
                    )
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
                    'filter' => $model,
                    'type' => 'striped bordered datatable',
                    'ajaxUrl' => $this->createUrl('professionalDirectory/index'),
                    'dataProvider' => $model->search(),
                    'responsiveTable' => true,
                    'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des professionnels</h3></div><div class="panel-body">{items}{pager}<div class="pull-right">{summary}</div></div></div>',
                    'columns' => $gridColumns
                        )
                );
                ?>
    </div>
</div>