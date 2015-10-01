<div class="cate-bg user-right">
    <h2> Payment Transactions </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <?php
                $gridColumns = array(
                    array(
                        'header' => 'S.No',
                        'value' => '++$row',
                    ),
                    'item_name',
                    'payment_status',
                    'payer_email',
                    'txn_id',
                    array(
                        'name' => 'total_price',
                        'value' => 'Myclass::currencyFormat($data->total_price)'
                    ),
                    'created_at',
                );
                $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider' => $model,
                    'itemsCssClass' => 'table table-bordered',
                    'columns' => $gridColumns
                ));
                ?>
            </div>
        </div>
    </div>
</div>
