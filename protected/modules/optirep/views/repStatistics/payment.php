<div class="cate-bg user-right">
    <h2> Statistics Payment </h2>
    <?php
    $repid = Yii::app()->user->id;
    $criteria1 = new CDbCriteria();
    $criteria1->condition = "user_id=" . $repid;
    $criteria1->order = 'id DESC';
    $criteria1->limit = 1;
    $get_transactions = PaymentTransaction::model()->find($criteria1);
    ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <p>Here the following features are you get after the payment.</p>
            <p>For representative user</p>
            <ul>
                <li>Track your own login statistics.</li>
            </ul>
            <p>For admin user</p>
            <ul>
                <li>Track your own login statistics.</li>
                <li>Track your owned users login statistics.</li>
                <li>Track your owned users viewed the user profiles (professional / retailer).</li>
            </ul>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'htmlOptions' => array('role' => 'form'),
            ));
            ?>            
            <div class="row"> 
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8"><h4>Payment Fee: 2 CAD</h4></div> 
                <?php if (!empty($get_transactions)) { 
                    echo CHtml::hiddenField('subscription_type' , '4');
                   }else{ 
                    echo CHtml::hiddenField('subscription_type' , '3');
                   }?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                    <?php
                    echo CHtml::tag('button', array(
                        'name' => 'btnSubmit',
                        'value' => 'Payfee',
                        'type' => 'submit',
                        'class' => 'register-btn'
                            ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO103', '', 'og'));
                    ?>
                </div>  
            </div>            
            <?php $this->endWidget(); ?>           
        </div>
    </div>
    <?php if (!empty($get_transactions)) { ?>

        <h2> Payment details</h2>
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
                            <th width="10%"><?php echo Myclass::t('OG143'); ?></th>
                            <th width="10%"><?php echo Myclass::t('OGO142', '', 'og'); ?></th>
                        </tr>
                        <?php if (!empty($get_transactions)) { ?>
                            <tr>
                                <td><?php echo $get_transactions->item_name; ?></td>
                                <td><?php echo $get_transactions->total_price; ?></td>
                                <td><?php echo ($get_transactions->pay_type == 1) ? "Paypal" : ""; ?></td>
                                <td><?php echo $get_transactions->payment_status; ?></td>
                                <td><?php echo $get_transactions->txn_id; ?></td>
                                <td><?php echo $get_transactions->expirydate; ?></td>
                                <td><?php echo $get_transactions->created_at; ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7"><?php echo Myclass::t('OGO143', '', 'og'); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>   
    <?php } ?>
</div>
