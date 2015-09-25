<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */

$this->title = 'View Message';
$this->breadcrumbs = array(
    'Client Messages' => array('index'),
    'View message',
);
?>
<div class="user-view">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
            'clientProfiles.name',
            'employeeProfiles.employee_name',
            'message',
            'date_remember',
            array(
                'name' => 'user_view_status',
                'type' => 'HTML',
                'value' => ($model->user_view_status == "1") ? '<span class="label label-success">User saw the infos.</span>' : '<span class="label label-warning">User not yet see the alert.</span>'
            ),
            array(
                'name' => 'status',
                'type' => 'HTML',
                'value' => ($model->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>'
            ),
            'created_date',
        ),
    ));
    ?>
</div>



