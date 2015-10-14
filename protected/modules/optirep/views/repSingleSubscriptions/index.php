<div class="cate-bg user-right">
    <h2> Subscription Details </h2>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array('role' => 'form'),
    ));
    ?>            
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
            <h4> Price:  <?php echo Myclass::currencyFormat($price_calculation['total_price']); ?></h4>
            <h4> Tax:  <?php echo Myclass::currencyFormat($price_calculation['tax']); ?></h4>
            <h4> Grand Total:  <?php echo Myclass::currencyFormat($price_calculation['grand_total']); ?></h4>
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'value' => 'Payfee',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), '<i class="fa fa-arrow-circle-right"></i> Renewal');
            ?>
        </div>  
    </div>            
    <?php $this->endWidget(); ?> 

    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <?php
                $gridColumns = array(
                    array(
                        'header' => 'S.No',
                        'value' => '++$row',
                    ),
                    'purchase_type',
                    array(
                        'header' => 'Price',
                        'name' => 'rep_single_price',
                        'value' => 'Myclass::currencyFormat($data->rep_single_price)'
                    ),
                    array(
                        'header' => 'No Of Months',
                        'name' => 'rep_single_no_of_months',
                    ),
                    array(
                        'header' => 'Total Month Price',
                        'name' => 'rep_single_total_month_price',
                        'value' => 'Myclass::currencyFormat($data->rep_single_total_month_price)'
                    ),
                    array(
                        'header' => 'Offer (%)',
                        'name' => 'offer_in_percentage',
                    ),
                    array(
                        'header' => 'Offer Price',
                        'name' => 'offer_price',
                        'value' => 'Myclass::currencyFormat($data->offer_price)'
                    ),
                    array(
                        'header' => 'Total',
                        'name' => 'rep_single_total',
                        'value' => 'Myclass::currencyFormat($data->rep_single_total)'
                    ),
                    array(
                        'header' => 'Tax',
                        'name' => 'rep_single_tax',
                        'value' => 'Myclass::currencyFormat($data->rep_single_tax)'
                    ),
                    array(
                        'header' => 'Grand Total',
                        'name' => 'rep_single_grand_total',
                        'value' => 'Myclass::currencyFormat($data->rep_single_grand_total)'
                    ),
                    array(
                        'header' => 'Subscription Start',
                        'name' => 'rep_single_subscription_start',
                        'value' => 'Myclass::dateFormat($data->rep_single_subscription_start)'
                    ),
                    array(
                        'header' => 'Subscription End',
                        'name' => 'rep_single_subscription_end',
                        'value' => 'Myclass::dateFormat($data->rep_single_subscription_end)'
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