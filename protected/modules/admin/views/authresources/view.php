<?php
/* @var $this AuthresourcesController */
/* @var $model AuthResources */

$this->title = 'View #' . $model->Master_Resource_ID;
$this->breadcrumbs = array(
    'Auth Resources' => array('index'),
    'View ' . 'AuthResources',
);
?>

<div class="user-view">
    <p>
        <?php
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' => $model->Master_Resource_ID),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' => $model->Master_Resource_ID),
                    'buttonType' => 'link',
                    'context' => 'danger',
                    'htmlOptions' => array('confirm' => 'Are you sure you want to delete this item?'),
                    
                )
        );
        ?>
    </p>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
            'Master_Resource_ID',
            'Master_User_ID',
            'Master_Role_ID',
            'Master_Module_ID',
            'Master_Screen_ID',
            'Master_Task_ADD',
            'Master_Task_SEE',
            'Master_Task_UPT',
            'Master_Task_DEL',
            'Active',
        ),
    ));
    ?>
</div>



