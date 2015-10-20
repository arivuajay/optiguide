<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR580', '', 'or') ?> </h2>
    <?php
    $repid = Yii::app()->user->id;
    $criteria1 = new CDbCriteria();
    $criteria1->addCondition("user_id=" . $repid);
    $criteria1->addCondition("NOMTABLE='rep_credentials'");
    $criteria1->addCondition("(subscription_type='3' || subscription_type='4')");
    $criteria1->order = 'id DESC';
    $criteria1->limit = 1;
    $get_transactions = PaymentTransaction::model()->find($criteria1);

    $subprices = SupplierSubscriptionPrice::model()->findByPk(1);
    $stats_price = $subprices->rep_statistics_price;
    ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stats-tips">
            <p>Here the following features are you get after the payment.</p>
            <b>For representative user</b>
            <ul>
                <li><i class="fa fa-check-square-o"></i> Track your own login statistics.</li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stats-tips">
            <b>For admin user</b>
            <ul>
                <li><i class="fa fa-check-square-o"></i> Track your own login statistics.</li>
                <li><i class="fa fa-check-square-o"></i> Track your owned users login statistics.</li>
                <li><i class="fa fa-check-square-o"></i> Track your owned users viewed the user profiles (professional / retailer).</li>
            </ul>
        </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array('role' => 'form'),
    ));
    ?>            
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4> <?php echo Myclass::t('OR581', '', 'or'); ?>: <?php echo Myclass::currencyFormat($stats_price); ?> </h4>
        </div> 
        <?php
        if (!empty($get_transactions)) {
            echo CHtml::hiddenField('subscription_type', '4');
            $btntxt = Myclass::t('OR582', '', 'or');
        } else {
            echo CHtml::hiddenField('subscription_type', '3');
            $btntxt = Myclass::t('OR583', '', 'or');
        }
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'value' => 'Payfee',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), '<i class="fa fa-arrow-circle-right"></i> ' . $btntxt);
            ?>
        </div>  
    </div>            
    <?php $this->endWidget(); ?> 
    <?php if (!empty($get_transactions)) { ?>

        <h2> <?php echo Myclass::t('OR584', '', 'or'); ?> </h2>
        <div class="row">    
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                <div class="table-responsive">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                        <tr>
                            <th width="15%"><?php echo Myclass::t('OGO141', '', 'og'); ?></th>
                            <th width="15%"><?php echo Myclass::t('OG138'); ?></th>
                            <th width="10%"><?php echo Myclass::t('OG142'); ?></th>
                            <th width="10%"><?php echo Myclass::t('OG140'); ?></th>
                            <th width="10%"><?php echo "Txn ID"; ?></th>           
                            <th width="10%"><?php echo Myclass::t('OGO142', '', 'og'); ?></th>
                        </tr>
                        <?php if (!empty($get_transactions)) { ?>
                            <tr>
                                <td><?php echo $get_transactions->item_name; ?></td>
                                <td><?php echo $get_transactions->total_price; ?></td>
                                <td><?php echo ($get_transactions->pay_type == 1) ? "Paypal" : ""; ?></td>
                                <td><?php echo $get_transactions->payment_status; ?></td>
                                <td><?php echo $get_transactions->txn_id; ?></td>                               
                                <td><?php echo $get_transactions->created_at; ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6"><?php echo Myclass::t('OGO143', '', 'og'); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>   
    <?php } ?>
</div>
