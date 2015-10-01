<?php
$this->title = 'View Sales Rep';
$this->breadcrumbs = array(
    'Sales Rep' => array('index'),
    'View Sales Rep',
);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a id="a_tab_1" href="#tab_1" data-toggle="tab">Rep Credentials</a></li>
                <li><a id="a_tab_2" href="#tab_2" data-toggle="tab">Rep Profile</a></li>
                <?php if ($model->rep_parent_id == 0) { ?>
                    <li><a id="a_tab_3" href="#tab_3" data-toggle="tab">Subscription Details</a></li>
                <?php } ?>
            </ul>

            <div class="tab-content">                
                <div class="tab-pane active" id="tab_1">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
                        'attributes' => array(
                            'rep_username',
                            'rep_password',
                            'rep_role',
                            array(
                                'name' => 'rep_status',
                                'type' => 'raw',
                                'value' => ($model->rep_status == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>'
                            ),
                            array(
                                'label' => 'Parent',
                                'value' => ($model->rep_parent_id == 0) ? " - " : $model->parentRep->rep_username
                            ),
                            'rep_expiry_date',
                            'created_at',
                        ),
                    ));
                    ?>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $profile,
                        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
                        'attributes' => array(
                            'rep_profile_firstname',
                            'rep_profile_lastname',
                            'rep_profile_email',
                            'rep_profile_phone',
                        ),
                    ));
                    ?>
                </div>
                <?php if ($model->rep_parent_id == 0) { ?>
                    <div class="tab-pane" id="tab_3">
                        <?php
                        if ($model->rep_role == RepCredentials::ROLE_SINGLE) {
                            $singleSubscriptionDetails = RepSingleSubscriptions::model()->repSingleSubscriptionDetails($model->rep_credential_id);
                            $gridColumns = array(
                                array(
                                    'header' => 'S.No',
                                    'value' => '++$row',
                                ),
                                'purchase_type',
                                array(
                                    'name' => 'rep_single_price',
                                    'value' => 'Myclass::currencyFormat($data->rep_single_price)'
                                ),
                                array(
                                    'name' => 'rep_single_tax',
                                    'value' => 'Myclass::currencyFormat($data->rep_single_tax)'
                                ),
                                array(
                                    'name' => 'rep_single_total',
                                    'value' => 'Myclass::currencyFormat($data->rep_single_total)'
                                ),
                                'rep_single_subscription_start',
                                'rep_single_subscription_end',
                                'created_at',
                                array(
                                    'header' => 'Action',
                                    'type' => 'raw',
                                    'filter' => false,
                                    //call the method 'repSinglePaymentTransactionLink' from the controller
                                    'value' => '$data->repSinglePaymentTransactionLink($data->rep_credential_id, $data->rep_single_subscription_id)',
                                ),
                            );

                            $this->widget('booster.widgets.TbExtendedGridView', array(
                                'type' => 'striped bordered',
                                'dataProvider' => $singleSubscriptionDetails,
                                'template' => "{items}\n{pager}",
                                'columns' => $gridColumns
                            ));
                        } elseif ($model->rep_role == RepCredentials::ROLE_ADMIN) {
                            $adminSubscriptionDetails = RepAdminSubscriptions::model()->repAdminSubscriptionDetails($model->rep_credential_id);
                            $gridColumns = array(
                                array(
                                    'header' => 'S.No',
                                    'value' => '++$row',
                                ),
                                'purchase_type',
                                'no_of_accounts_purchased',
                                'rep_admin_old_active_accounts',
                                'no_of_accounts_used',
                                'no_of_accounts_remaining',
                                array(
                                    'name' => 'rep_admin_per_account_price',
                                    'value' => 'Myclass::currencyFormat($data->rep_admin_per_account_price)'
                                ),
                                array(
                                    'name' => 'rep_admin_total_price',
                                    'value' => 'Myclass::currencyFormat($data->rep_admin_total_price)'
                                ),
                                array(
                                    'name' => 'rep_admin_tax',
                                    'value' => 'Myclass::currencyFormat($data->rep_admin_tax)'
                                ),
                                array(
                                    'name' => 'rep_admin_grand_total',
                                    'value' => 'Myclass::currencyFormat($data->rep_admin_grand_total)'
                                ),
                                'rep_admin_subscription_start',
                                'rep_admin_subscription_end',
                                'created_at',
                                array(
                                    'header' => 'Action',
                                    'type' => 'raw',
                                    'filter' => false,
                                    //call the method 'repAdminPaymentTransactionLink' from the controller
                                    'value' => '$data->repAdminPaymentTransactionLink($data->rep_credential_id, $data->rep_admin_subscription_id)',
                                ),
                            );

                            $this->widget('booster.widgets.TbExtendedGridView', array(
                                'type' => 'striped bordered',
                                'dataProvider' => $adminSubscriptionDetails,
                                'template' => "{items}\n{pager}",
                                'columns' => $gridColumns
                            ));
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rep-payment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-money"></i> Payment Details :</h4>
                <div id="payment_contents"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php
$ajax_get_rep_admin_payment_transaction = Yii::app()->createUrl('/admin/paymentTransaction/getRepAdminPaymentDetails');
$ajax_get_rep_single_payment_transaction = Yii::app()->createUrl('/admin/paymentTransaction/getRepSinglePaymentDetails');

$js = <<< EOD
$(document).ready(function()
{   
    $('.payment_popup').live('click',function(event){
        event.preventDefault();
        var rep_cred_id = $(this).attr("id");      
        var rep_admin_subs_id = $(this).data("admin-subs-id"); 
        var rep_single_subs_id = $(this).data("single-subs-id");  
            
        if (rep_admin_subs_id > 0){
            var dataString = 'user_id='+rep_cred_id+'&rep_admin_subscription_id='+rep_admin_subs_id;
            $.ajax({
                type: "POST",
                url: '{$ajax_get_rep_admin_payment_transaction}',
                data: dataString,
                cache: false,
                success: function(html){             
                    $("#payment_contents").html(html);               
                }
             });
        }
        
        if(rep_single_subs_id > 0){
            var dataString = 'user_id='+rep_cred_id+'&rep_single_subscription_id='+rep_single_subs_id;
            $.ajax({
                type: "POST",
                url: '{$ajax_get_rep_single_payment_transaction}',
                data: dataString,
                cache: false,
                success: function(html){             
                    $("#payment_contents").html(html);               
                }
             });
        }
    });
});     
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>