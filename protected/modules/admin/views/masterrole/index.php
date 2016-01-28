<?php
/* @var $this MasterroleController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Master Roles';
$this->breadcrumbs = array(
    'Master Roles',
);
?>
<div class="col-lg-12 col-md-12">
    <div class="row mb10">
        <?php
        $this->widget(
                'application.components.MyTbButton', array(
            'label' => 'Create Master Role',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/masterrole/create'),
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
        $gridColumns = array(
            array(
                'class' => 'IndexColumn',
                'header' => '',
            ),
            'Role_Code',
            'Description',                        
            array(
                'name' => 'Active',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'value' => function($data) {
                 echo ($data->Active == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
                },
            ),
            array(
                'header' => 'Actions',
                'class' => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{privilages}&nbsp;&nbsp;{view}&nbsp;&nbsp;{role_update}&nbsp;&nbsp;{role_delete}',
                'buttons' => array(
                    'privilages' => array(//the name {reply} must be same
                        'label' => '<i class="fa fa-cogs"></i>',
                        'options' => array(
                            'title' => 'Privilages',
                        ),
                        'url' => 'CHtml::normalizeUrl(array("/admin/authresources/role/rid/".rawurlencode($data->Master_Role_ID)))',
                     //   'visible' => 'UserIdentity::checkPrivilages(rawurlencode($data->Rank))'
                         'visible' => '($data->is_Admin != 1) && AdminIdentity::checkAccess(NULL, "masterrole", "update")'
                       
                    ),
                    'role_update' => array(//the name {reply} must be same
                        'label' => '<i class="glyphicon glyphicon-pencil"></i>',
                        'options' => array(
                            'title' => 'Update',
                        ),
                        'url' => 'CHtml::normalizeUrl(array("/admin/masterrole/update/id/".rawurlencode($data->Master_Role_ID)))',
                      //  'visible' => 'UserIdentity::checkPrivilages(rawurlencode($data->Rank)) && UserIdentity::checkAccess(NULL, "masterrole", "update")'
                        'visible' => '($data->is_Admin != 1) && AdminIdentity::checkAccess(NULL, "masterrole", "update")'
                    ),
                    'role_delete' => array(//the name {reply} must be same
                        'label' => '<i class="glyphicon glyphicon-trash"></i>',
                        'options' => array(
                            'title' => 'Delete',
                            'confirm' => 'Are you sure to delete?',
                        ),
                        'url' => 'CHtml::normalizeUrl(array("/admin/masterrole/delete/id/".rawurlencode($data->Master_Role_ID)))',
                      //  'visible' => 'UserIdentity::checkPrivilages(rawurlencode($data->Rank)) && UserIdentity::checkAccess(NULL, "masterrole", "delete")'
                         'visible' => '($data->is_Admin != 1) && AdminIdentity::checkAccess(NULL, "masterrole", "delete")'
                    ),
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered',
            'dataProvider' => $model->dataProvider(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Master Roles</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>