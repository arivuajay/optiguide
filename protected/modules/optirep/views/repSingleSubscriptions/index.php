<div class="cate-bg user-right">
    <h2> Subscription Details </h2>

    <p>
        Your Expiry Date :
        <b><?php echo date("Y-m-d", strtotime(Yii::app()->user->rep_expiry_date)) ?></b>
    </p>

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