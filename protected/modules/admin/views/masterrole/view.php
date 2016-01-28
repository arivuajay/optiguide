<?php
/* @var $this MasterroleController */
/* @var $model MasterRole */

$this->title = 'View Master Role: ' . $model->Description;
$this->breadcrumbs = array(
    'Master Roles' => array('index'),
    'View ' . 'MasterRole',
);
?>

<div class="user-view">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
//            'Master_Role_ID',
            'Role_Code',
//            'Rank',
            'Description',         
            array(
                'label' => MasterRole::model()->getAttributeLabel('Active'),
                'type' => 'raw',
                'value' => ($model->Active == 1) ? '<i class="fa fa-circle text-green" title="Active"></i>' : '<i title="In-Active" class="fa fa-circle text-red"></i>'
            ),
        ),
    ));
    ?>
</div>



