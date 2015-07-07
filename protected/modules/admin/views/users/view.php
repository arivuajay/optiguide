<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->user_id,
);

//$this->menu = array(
//    array('label' => 'List User', 'url' => array('index')),
//    array('label' => 'Create User', 'url' => array('create')),
//    array('label' => 'Update User', 'url' => array('update', 'id' => $model->user_id)),
//    array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->user_id), 'confirm' => 'Are you sure you want to delete this item?')),
//    array('label' => 'Manage User', 'url' => array('admin')),
//);
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3>View User #<?php echo $model->user_id; ?></h3>
            </header>
            <div class="panel-body">
                <?php
                $this->widget('zii.widgets.CDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'user_id',
                        'user_name',
                        'user_email',
                        array(
                            'label' => 'Status',
                            'value' => $model->user_status == '0' ? 'In-active' : 'Active'
                        ),
                        'user_last_login',
                        'user_login_ip',
                        'created',
                        'modified'
                    ),
                ));
                ?>

                <?php echo CHtml::link('Back', array('/admin/users/index'), array('class' => 'btn btn-sm btn-default')); ?>    
            </div>    
        </section>
    </div>
</div>

