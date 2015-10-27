<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */

$this->title = 'View Profile';
$this->breadcrumbs = array(
    'Client Profile' => array('index'),
    'View profile',
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>
<div class="user-view">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
            'name',
            'company',
            'job_title',
            array(
                'name' => 'member_type',
                'type' => 'HTML',
                'value' => ($model->member_type == "free_member") ? 'Free Member' : 'Advertiser'
            ),
            array(
                'name' => 'clientCategoryTypes.cat_type',
                'type' => 'HTML',
                'value' => $model->clientCategoryTypes->cat_type
            ),
            array(
                'name' => 'clientCategory.cat_name',
                'type' => 'HTML',
                'value' => $model->clientCategory->cat_name
            ),
            'address',
            'local_number',
            'country',
            'region',
            'ville',
            'phonenumber1',
            'phonenumber2',
            'mobile_number',
            'tollfree_number',
            'fax',
            'email',
            'site_address',
            'created_date',
            'modified_date'
        ),
    ));
    ?>
    <h4>Subscription</h4>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
            array(
                'label' => 'Optipromo',
                'name' => 'Optipromo',
                'type' => 'HTML',
                'htmlOptions' => array('width' => '40'),
                'value' => ($model->Optipromo == '1') ? "Yes" : "No"
            ),
            array(
                'label' => 'Optinews',
                'name' => 'Optinews',
                'type' => 'HTML',
                'htmlOptions' => array('width' => '40'),
                'value' => ($model->Optinews == '1') ? "Yes" : "No"
            ),
            array(
                'label' => 'Envision print',
                'name' => 'Envision_print',
                'type' => 'HTML',
                'htmlOptions' => array('width' => '40'),
                'value' => ($model->Envision_print == '1') ? "Yes" : "No"
            ),
            array(
                'label' => 'Envision digital',
                'name' => 'Envision_digital',
                'type' => 'HTML',
                'htmlOptions' => array('width' => '40'),
                'value' => ($model->Envision_digital == '1') ? "Yes" : "No"
            ),
            array(
                'label' => 'Envue print',
                'name' => 'Envue_print',
                'type' => 'HTML',
                'htmlOptions' => array('width' => '40'),
                'value' => ($model->Envue_print == '1') ? "Yes" : "No"
            ),
            array(
                'label' => 'Envue digital',
                'name' => 'Envue_digital',
                'type' => 'HTML',
                'htmlOptions' => array('width' => '40'),
                'value' => ($model->Envue_digital == '1') ? "Yes" : "No"
            ),
        ),
    ));
    ?>
</div>
<?php
// Get the alert history for the client
        $cmodel = new ClientMessages('search_client');
        $cexpiremodel  = $cmodel->search_expirealerts($model->client_id);
        $ccurrentmodel = $cmodel->search_currentalerts($model->client_id);
?>

<div class="box-header">
    <h3 class="box-title">L'historique des alertes</h3>
</div>   

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a id="a_tab_1" href="#tab_1" data-toggle="tab">Active Alerts</a></li>
        <li><a id="a_tab_2" href="#tab_2"  data-toggle="tab">Expire Alerts</a></li>                                                       
    </ul>

    <div class="tab-content">                
        <div class="tab-pane active" id="tab_1">    
            <div class="row">
                <?php
                $gridColumns = array(
                    array('header' => 'SN.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
                    array(
                        'name' => 'employeeProfiles.employee_name',
                        'value' => $data->employeeProfiles->employee_name,
                    ),
                    array('name' => 'date_remember',
                        'type' => 'raw',
                        'value' => function($data) {
                            echo date("d-m-Y", strtotime($data->date_remember));
                        },
                        'filter' => false,
                    ),
                    array('name' => 'status',
                        'type' => 'raw',
                        'value' => function($data) {
                            echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                        },
                        'filter' => false,
                    ),
                    array(
                        'name' => 'user_view_status',
                        'type' => 'HTML',
                        'value' => function($data) {
                            echo ($data->user_view_status == "1") ? '<span class="label label-success">User saw the infos.</span>' : '<span class="label label-warning">User not yet see the alert.</span>';
                        }
                    ),
                    array('header' => 'message',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                        'filter' => false,
                        //call the method 'gridDataColumn' from the controller
                        'value' => array($this, 'gridDataColumn'),
                    ),
                    array(
                        'header' => 'Actes',
                        'class' => 'booster.widgets.TbButtonColumn',
                        'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                        'template' => '{delete}',
                        'buttons' => array
                            (
                            'delete' => array
                                (
                                'label' => 'Delete',
                                'url' => 'Yii::app()->createUrl("admin/clientMessages/delete", array("id"=>$data->message_id))',
                            ),
                        ),
                    )
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
                    'type' => 'striped bordered datatable',
                    'enableSorting' => false,
                    'dataProvider' => $ccurrentmodel,
                    'responsiveTable' => true,
                    'template' => '  <div id="histrydisp" tabindex="-1" class="col-md-7"><div class="box"> <div class="box-body">{items}</div> <div class="box-footer clearfix">{pager}</div> </div></div>',
                    'columns' => $gridColumns
                        )
                );
                ?>
            </div>
        </div> 
        <div class="tab-pane" id="tab_2">
            <div class="row">
                <?php
                $gridColumns = array(
                    array('header' => 'SN.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
                    array(
                        'name' => 'employeeProfiles.employee_name',
                        'value' => $data->employeeProfiles->employee_name,
                    ),
                    array('name' => 'date_remember',
                        'type' => 'raw',
                        'value' => function($data) {
                            echo date("d-m-Y", strtotime($data->date_remember));
                        },
                        'filter' => false,
                    ),
                    array('name' => 'status',
                        'type' => 'raw',
                        'value' => function($data) {
                            echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                        },
                        'filter' => false,
                    ),
                    array(
                        'name' => 'user_view_status',
                        'type' => 'HTML',
                        'value' => function($data) {
                            echo ($data->user_view_status == "1") ? '<span class="label label-success">User saw the infos.</span>' : '<span class="label label-warning">User not yet see the alert.</span>';
                        }
                    ),
                    array('header' => 'message',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                        'filter' => false,
                        //call the method 'gridDataColumn' from the controller
                        'value' => array($this, 'gridDataColumn'),
                    ),
                    array(
                        'header' => 'Actes',
                        'class' => 'booster.widgets.TbButtonColumn',
                        'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                        'template' => '{delete}',
                        'buttons' => array
                            (
                            'delete' => array
                                (
                                'label' => 'Delete',
                                'url' => 'Yii::app()->createUrl("admin/clientMessages/delete", array("id"=>$data->message_id))',
                            ),
                        ),
                    )
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
                    'type' => 'striped bordered datatable',
                    'enableSorting' => false,
                    'dataProvider' => $cexpiremodel,
                    'responsiveTable' => true,
                    'template' => '  <div id="histrydisp" tabindex="-1" class="col-md-7"><div class="box"> <div class="box-body">{items}</div> <div class="box-footer clearfix">{pager}</div> </div></div>',
                    'columns' => $gridColumns
                        )
                );
                ?>
            </div>
        </div>    
    </div>  
</div>


<div class="modal fade" id="products-disp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i> Message</h4>
                <div id="product_contents"></div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
$ajax_getmessage = Yii::app()->createUrl('/admin/clientProfiles/getmessage');
$js = <<< EOD

   $(document).ready(function(){
        
            
   $('.popupmessage').live('click',function(event){
        event.preventDefault();
        var message_id = $(this).attr("id");      
        var dataString = 'id='+message_id;
            
        $.ajax({
            type: "POST",
            url: '{$ajax_getmessage}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#product_contents").html(html);               
            }
         });
       
    });
  
});
EOD;
Yii::app()->clientScript->registerScript('_form_prof', $js);
?>



