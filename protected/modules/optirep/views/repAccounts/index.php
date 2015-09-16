<div class="cate-bg user-right">
    <h2> Manage Rep Accounts </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-lg-offset-8">
            <table class="table table-responsive table-bordered">
                <tr>
                    <td>Total no.of accounts</td>
                    <td><?php echo RepAdminSubscriptions::model()->getTotalNoOfAccountsPurchased(); ?></td>
                </tr>
                <tr>
                    <td>Used accounts</td>
                    <td><?php echo RepAdminSubscriptions::model()->getTotalNoOfAccountsUsed(); ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php echo CHtml::link('Create New Rep Account', array('/optirep/repAccounts/create'), array('class' => 'pull-right')) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php echo CHtml::link('Buy More Rep Accounts', array('/optirep/repAccounts/buyMoreAccounts'), array('class' => 'pull-right')) ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php $repAdminSubscribers = RepCredentials::model()->rep_admin_subscribers()->findAll(); ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'renewal-rep-account-form',
                ));
                ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="3%"></th>
                        <th width="6%">S. No</th>
                        <th width="20%"> Username</th>
                        <th width="18%"> Password </th>
                        <th width="23%"> Expiry Date </th>
                        <th width="14%"> Status </th>
                        <th width="16%"> Actions </th>
                    </tr>
                    <?php if (!empty($repAdminSubscribers)) { ?>
                        <?php
                        $i = 1;
                        foreach ($repAdminSubscribers as $repAdminSubscriber) {
                            $checked = '';
                            if ($repAdminSubscriber['rep_status'] == 1)
                                $checked = 'checked';
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="rep_credentials[]" value="<?php echo $repAdminSubscriber['rep_credential_id'] ?>">
                                </td>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $repAdminSubscriber['rep_username'] ?></td>
                                <td><?php echo $repAdminSubscriber['rep_password'] ?></td>
                                <td><?php echo date("Y-m-d", strtotime($repAdminSubscriber['rep_expiry_date'])) ?></td>
                                <td>
                                    <input type="checkbox" name="rep_status" <?php echo $checked; ?> data-on-text="ACTIVE" data-off-text="BLOCK" data-rep-id ="<?php echo $repAdminSubscriber['rep_credential_id'] ?>" class="status">
                                </td>
                                <td>
                                    <?php echo CHtml::link('<i class="fa fa-edit"></i>', array('/optirep/repAccounts/edit', 'id' => $repAdminSubscriber['rep_credential_id'])); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6"> No Records Found </td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                if (!empty($repAdminSubscribers)) {
                    echo CHtml::tag('button', array(
                        'name' => 'renewalSubmit',
                        'type' => 'submit',
                        'class' => 'register-btn'
                            ), 'Renewal');
                }
                ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>



<?php
$ajaxChangeRepStatusURL = Yii::app()->createUrl('/optirep/repCredential/changeStatus');
$js = <<< EOD
    $(document).ready(function () {
        $("input[name='rep_status']").bootstrapSwitch();
        $('input[name="rep_status"]').on('switchChange.bootstrapSwitch', function(event, state) {
            var id = $(this).data("rep-id");
            var dataString = 'id='+ id;
            $.ajax({
                type: "POST",
                url: '{$ajaxChangeRepStatusURL}',
                data: dataString,
                cache: false,
                success: function(html){             
                }
             });
        });
    });
EOD;
Yii::app()->clientScript->registerScript('_rep_accounts_index', $js);
?>