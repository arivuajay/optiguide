<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR545', '', 'or') ?> </h2>

    <div class="row"> 
        <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 viewall">-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::link('<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OR536', '', 'or'), '/optirep/repSingleSubscriptions/durationRenewal', array('class' => 'pull-left viewall-new'));
            ?>
            
            <?php
            //echo CHtml::link('<i class="fa fa-plus"></i> '. Myclass::t('OR784', '', 'or'), '/optirep/repAccounts/buyMoreAccounts', array('class' => 'pull-left btn btn-success'));
            ?>
        </div>
    </div>            

    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <?php
                $gridColumns = array(
                    array(
                        'header' => '#',
                        'value' => '++$row',
                    ),
                    'purchase_type',
                    array(
                        'header' => Myclass::t('OR576', '', 'or'),
                        'name' => 'rep_single_price',
                        'value' => 'Myclass::currencyFormat($data->rep_single_price)'
                    ),
                    array(
                        'header' => Myclass::t('OR559', '', 'or'),
                        'name' => 'rep_single_no_of_months',
                    ),
//                    array(
//                        'header' => Myclass::t('OR561', '', 'or'),
//                        'name' => 'rep_single_total_month_price',
//                        'value' => 'Myclass::currencyFormat($data->rep_single_total_month_price)'
//                    ),
//                    array(
//                        'header' => Myclass::t('OR562', '', 'or') . ' (%)',
//                        'name' => 'offer_in_percentage',
//                    ),
                    array(
                        'header' => Myclass::t('OR563', '', 'or'),
                        'name' => 'offer_price',
                        'value' => 'Myclass::currencyFormat($data->offer_price)'
                    ),
                    array(
                        'header' => Myclass::t('OR539', '', 'or'),
                        'name' => 'rep_single_total',
                        'value' => 'Myclass::currencyFormat($data->rep_single_total)'
                    ),
                    array(
                        'header' => Myclass::t('OR540', '', 'or'),
                        'name' => 'rep_single_tax',
                        'value' => 'Myclass::currencyFormat($data->rep_single_tax)'
                    ),
                    array(
                        'header' => Myclass::t('OR541', '', 'or'),
                        'name' => 'rep_single_grand_total',
                        'value' => 'Myclass::currencyFormat($data->rep_single_grand_total)'
                    ),
                    array(
                        'header' => Myclass::t('OR577', '', 'or'),
                        'name' => 'rep_single_subscription_start',
                        'value' => 'Myclass::dateFormat($data->rep_single_subscription_start)'
                    ),
                    array(
                        'header' => Myclass::t('OR578', '', 'or'),
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