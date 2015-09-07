<div class="cate-bg user-right">
    <h2> Manage Rep Accounts </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-lg-offset-9">
            <table class="table table-responsive table-bordered">
                <tr>
                    <td>Total no.of accounts</td>
                    <td><?php echo RepAdminSubscriptions::model()->getTotalNoOfAccountsPurchased();?></td>
                </tr>
                <tr>
                    <td>Used accounts</td>
                    <td><?php echo RepAdminSubscriptions::model()->getTotalNoOfAccountsUsed();?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php echo CHtml::link('Create New Rep Account', array('/optirep/repAccounts/create'), array('class' => 'pull-right')) ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php $repAdminSubscribers = RepCredentials::model()->rep_admin_subscribers()->findAll(); ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="9%">S. No</th>
                        <th width="26%"> Username</th>
                        <th width="28%"> Password </th>
                        <th width="23%"> Expiry Date </th>
                        <th width="14%">Actions</th>
                    </tr>
                    <?php if (!empty($repAdminSubscribers)) { ?>
                        <?php $i = 1;
                        foreach ($repAdminSubscribers as $repAdminSubscriber) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $repAdminSubscriber['rep_username'] ?></td>
                                <td><?php echo $repAdminSubscriber['rep_password'] ?></td>
                                <td><?php echo $repAdminSubscriber['rep_expiry_date'] ?></td>
                                <td>
                                    <input type="checkbox" name="my-checkbox" data-on-text="ACTIVE" data-off-text="BLOCK">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>

<?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>