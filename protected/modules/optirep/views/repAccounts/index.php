<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t("OR524", "", "or") ?> </h2>
    <div class="row"> 

        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo RepAdminSubscriptions::model()->getTotalNoOfAccountsPurchased(); ?>
                    </h3>
                    <p> <?php echo Myclass::t("OR525", "", "or") ?> </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>

            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo RepAdminSubscriptions::model()->getTotalNoOfAccountsUsed(); ?>
                    </h3>
                    <p> <?php echo Myclass::t("OR526", "", "or") ?> </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>

            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <p>
                        <?php
                        $can_buy = RepAdminSubscriptions::model()->canBuyMoreAccounts();
                        $current_plan = RepAdminSubscriptions::model()->getCurrentPlan();
                        if (!empty($current_plan)) {
                            echo CHtml::link(Myclass::t("OR527", "", "or"), array('/optirep/repAccounts/create'));
                        } elseif ($can_buy) {
                            echo CHtml::link(Myclass::t("OR528", "", "or"), array('/optirep/repAccounts/buyMoreAccounts'));
                        }
                        ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-briefcase"></i>
                </div>

            </div>
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
                        <th width="6%">#</th>
                        <th width="20%"> <?php echo Myclass::t("OR502", "", "or"); ?> </th>
                        <th width="18%"> <?php echo Myclass::t("OR503", "", "or"); ?> </th>
                        <th width="23%"> <?php echo Myclass::t("OR529", "", "or"); ?> </th>
                        <th width="14%"> <?php echo Myclass::t("OR530", "", "or"); ?> </th>
                        <th width="16%"> <?php echo Myclass::t("OR531", "", "or"); ?> </th>
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
                                <td><?php echo Myclass::dateFormat($repAdminSubscriber['rep_expiry_date']); ?></td>
                                <td>
                                    <input type="checkbox" name="rep_status" <?php echo $checked; ?> data-on-text="<?php echo Myclass::t("OR532", "", "or"); ?>" data-off-text="<?php echo Myclass::t("OR533", "", "or"); ?>" data-rep-id ="<?php echo $repAdminSubscriber['rep_credential_id'] ?>" class="status">
                                </td>
                                <td>
                                    <?php
                                    echo CHtml::link('<i class="fa fa-edit"></i>', array('/optirep/repAccounts/edit', 'id' => $repAdminSubscriber['rep_credential_id']));
                                    echo '&nbsp; &nbsp;';
                                    echo CHtml::link('<i class="fa fa-remove"></i>', array('/optirep/repAccounts/delete', 'id' => $repAdminSubscriber['rep_credential_id']), array('confirm' => Myclass::t("OR534", "", "or")));
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6"> <?php echo Myclass::t("OR535", "", "or")?> </td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                if (!empty($repAdminSubscribers)) {
                    echo CHtml::tag('button', array(
                        'name' => 'renewalSubmit',
                        'type' => 'submit',
                        'class' => 'register-btn'
                            ), Myclass::t("OR536", "", "or"));
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