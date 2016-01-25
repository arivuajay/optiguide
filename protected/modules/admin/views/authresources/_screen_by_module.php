<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => array('/admin/authresources/getscreensbymodule'),
    'htmlOptions' => array('role' => 'form')
        ));
?>

<div class="row">
    <div class="col-lg-12 col-md-12" id="resources-block">
        <table class="table table-striped table-bordered">
            <thead class="bg-green">
            <td align="center" width="40%"><strong>Screen Name</strong></td>
            <td align="center" width="15%"><strong>Add</strong><br /><?php echo CHtml::checkBox('check_all_add', false, array('class' => 'form-control all_check chkbox', 'data-check' => 'check_add')); ?></td>
            <td align="center" width="15%"><strong>View</strong><br /><?php echo CHtml::checkBox('check_all_view', false, array('class' => 'form-control all_check chkbox', 'data-check' => 'check_view')); ?></td>
            <td align="center" width="15%"><strong>Update</strong><br /><?php echo CHtml::checkBox('check_all_update', false, array('class' => 'form-control all_check chkbox', 'data-check' => 'check_update')); ?></td>
            <td align="center" width="15%"><strong>Delete</strong><br /><?php echo CHtml::checkBox('check_all_delete', false, array('class' => 'form-control all_check chkbox', 'data-check' => 'check_delete')); ?></td>
            </thead>
            <tbody>
                <?php
                echo CHtml::activeHiddenField($model, 'type', array('value' => $type));
                if (empty($exist_resources)) {
                    foreach ($masters as $master) {
                        echo CHtml::activeHiddenField($model, 'Master_Module_ID', array('value' => $master->Module_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Module_ID]'));
                        echo CHtml::activeHiddenField($model, "Master_{$u_type}_ID", array('value' => $id, 'name' => "AuthResources[{$master->Master_Screen_ID}][Master_{$u_type}_ID]"));
                        echo CHtml::activeHiddenField($model, 'Master_Screen_ID', array('value' => $master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Screen_ID]'));
                        echo '<tr class="text-center">';
                        echo '<td>' . $master->Description . '</td>';

                        echo '<td>' . $form->checkBox($model, 'Master_Task_ADD', array('class' => 'form-control check_add chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_ADD]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '<td>' . $form->checkBox($model, 'Master_Task_SEE', array('class' => 'form-control check_view chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_SEE]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '<td>' . $form->checkBox($model, 'Master_Task_UPT', array('class' => 'form-control check_update chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_UPT]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '<td>' . $form->checkBox($model, 'Master_Task_DEL', array('class' => 'form-control check_delete chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_DEL]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    $resource_exist_screen_ids = array();
                    $screen_ids = array();
                    foreach ($exist_resources as $key => $exist_resource) {
                        $resource_exist_screen_ids[$exist_resource->Master_Screen_ID] = $exist_resource->Master_Screen_ID;
                    }
                    foreach ($masters as $key => $master) {
                        $screen_ids[$master->Master_Screen_ID] = $master->Master_Screen_ID;
                    }
                    $diff_ids = array_diff($screen_ids, $resource_exist_screen_ids);
                    foreach ($exist_resources as $master) {
                        echo CHtml::activeHiddenField($master, 'Master_Resource_ID', array('value' => $master->Master_Resource_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Resource_ID]'));
                        echo '<tr class="text-center">';
                        echo '<td>' . $master->masterScreen->Description . '</td>';
                        echo '<td>' . $form->checkBox($master, 'Master_Task_ADD', array('class' => 'form-control check_add chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_ADD]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '<td>' . $form->checkBox($master, 'Master_Task_SEE', array('class' => 'form-control check_view chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_SEE]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '<td>' . $form->checkBox($master, 'Master_Task_UPT', array('class' => 'form-control check_update chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_UPT]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '<td>' . $form->checkBox($master, 'Master_Task_DEL', array('class' => 'form-control check_delete chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_DEL]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                        echo '</tr>';
                    }
                    foreach ($diff_ids as $diff_id) {
                        foreach ($masters as $master) {
                            if ($master->Master_Screen_ID != $diff_id)
                                continue;
                            echo CHtml::activeHiddenField($model, 'Master_Module_ID', array('value' => $master->Module_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Module_ID]'));
                            if ($type == 'role') {
                                echo CHtml::activeHiddenField($model, 'Master_Role_ID', array('value' => $id, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Role_ID]'));
                            } else if ($type == 'user') {
                                echo CHtml::activeHiddenField($model, 'Master_User_ID', array('value' => $id, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_User_ID]'));
                            }
                            echo CHtml::activeHiddenField($model, 'Master_Screen_ID', array('value' => $master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Screen_ID]'));
                            echo '<tr class="text-center">';
                            echo "<td>{$master->Description} (Newly added)</td>";

                            echo '<td>' . $form->checkBox($model, 'Master_Task_ADD', array('class' => 'form-control check_add chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_ADD]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                            echo '<td>' . $form->checkBox($model, 'Master_Task_SEE', array('class' => 'form-control check_view chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_SEE]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                            echo '<td>' . $form->checkBox($model, 'Master_Task_UPT', array('class' => 'form-control check_update chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_UPT]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                            echo '<td>' . $form->checkBox($model, 'Master_Task_DEL', array('class' => 'form-control check_delete chkbox chbx'.$master->Master_Screen_ID, 'name' => 'AuthResources[' . $master->Master_Screen_ID . '][Master_Task_DEL]', 'data-chbx' => "chbx{$master->Master_Screen_ID}")) . '</td>';
                            echo '</tr>';
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="form-group">
    <?php echo CHtml::submitButton(empty($exist_resources) ? 'Save' : 'Update', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
</div>
<?php $this->endWidget(); ?>
