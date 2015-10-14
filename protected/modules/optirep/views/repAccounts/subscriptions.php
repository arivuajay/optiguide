<div class="cate-bg user-right">
    <h2> Subscription Details </h2>

    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
            <div class="table-responsive">
                <?php
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
                    'rep_admin_no_of_months',
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
                    array(
                        'name' => 'rep_admin_subscription_start',
                        'value' => 'Myclass::dateFormat($data->rep_admin_subscription_start)'
                    ),
                    array(
                        'name' => 'rep_admin_subscription_end',
                        'value' => 'Myclass::dateFormat($data->rep_admin_subscription_end)'
                    ),
                    'created_at',
                );
                $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider' => $model,
                    'itemsCssClass' => 'table table-bordered',
                    'columns' => $gridColumns,
                ));
                ?>
            </div>
        </div>
    </div>
</div>