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
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp; Ajouter un fournisseur ', array('/admin/suppliersDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
        <?php
        $this->widget(
                'application.components.MyTbButton', array(
            'label' => 'Ajouter un fournisseur',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/suppliersDirectory/create'),
            'buttonType' => 'link',
            'context' => 'success',
            'htmlOptions' => array('class' => 'pull-right'),
                )
        );
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search', array('model' => $model)); ?>

<div class="col-lg-12 col-md-12">
    <p>
        <i class='fa fa-circle text-green'></i>  Visible in the website because admin gave an access (Non Expiry).<br>
        <i class='fa fa-circle text-blue'></i>  Visible in the website because admin gave an access (Expired User).<br>
        <i class='fa fa-circle text-yellow'></i> Not Visible in the website because admin deactive their access.<br>
        <i class='fa fa-circle text-purple'></i> Not Visible in the website because admin deactive their visibility.<br>
        <i class='fa fa-circle text-red'></i>    Not Visible in the website and because deactive their visibility and access.
    </p>
    <div class="row">
        <?php
        $gettypes = CHtml::listData(SupplierType::model()->findAll(), 'ID_TYPE_FOURNISSEUR', 'TYPE_FOURNISSEUR_FR');

        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'name' => 'COMPAGNIE',
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
                if ($data->bAfficher_site == 1 && $data->userDirectory2->status == 1){
                    $today = date("Y-m-d");
                    $profile_expirydate = date("Y-m-d", strtotime($data->profile_expirydate));
                    
                    $diff = date_diff(date_create($today),date_create($profile_expirydate));
                    if ($diff->format("%R%a") >=0 ){
                        echo "<i class='fa fa-circle text-green'></i>";
                    }else{
                        echo "<i class='fa fa-circle text-blue'></i>";
                    }
                }else if ($data->bAfficher_site == 1 && $data->userDirectory2->status == 0){
                    echo "<i class='fa fa-circle text-yellow'></i>";
                }else if ($data->bAfficher_site == 0 && $data->userDirectory2->status == 1){
                    echo "<i class='fa fa-circle text-purple'></i>";
                }else if ($data->bAfficher_site == 0 && $data->userDirectory2->status == 0){
                    echo "<i class='fa fa-circle text-red'></i>";
                }
        },
                'filter' => CHtml::activeDropDownList($model, 'bAfficher_site', array("1" => "Activés","3" => "Activés (Expired User)", "0" => "Désactivés" , "2"=> "Désactivés (Access Deactive)"), array('class' => 'form-control', 'prompt' => 'Tous')),
            ),
            array(
                'header' => 'Profile Expiry Date',
                'name' => 'profile_expirydate',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'sortable' => false,
                'value' => function($data) {
            echo ($data->profile_expirydate != "0000-00-00 00:00:00") ? date("d-m-Y", strtotime($data->profile_expirydate)) : "-";
        },
                'filter' => CHtml::activeDropDownList($model, 'profile_expirydate_filter', array("1" => "Expired", "0" => "Non Expired"), array('class' => 'form-control', 'prompt' => 'Tous')),
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
                'class' => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{access}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'access' => array(
                        'label' => "<i class='fa fa-lock'></i>",
                        'url' => 'Yii::app()->createUrl("/admin/userDirectory/create", array("relid"=>$data->ID_FOURNISSEUR, "nomtable"=>"Fournisseurs"))',
                        'options' => array("title" => "Accès"),
                        'visible' => 'AdminIdentity::checkAccess(NULL, "suppliersDirectory", "update")'
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