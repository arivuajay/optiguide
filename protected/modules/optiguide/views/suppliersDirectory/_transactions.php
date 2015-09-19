<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;

$relid     = Yii::app()->user->relationid; 
$criteria1 = new CDbCriteria();
$criteria1->addCondition("user_id=".$relid);
$criteria1->addCondition("NOMTABLE='suppliers'");
$criteria1->addCondition("(subscription_type='1' || subscription_type='2')");
$criteria1->order = 'id DESC';
$criteria1->limit = 1;

$get_transactions = PaymentTransaction::model()->find($criteria1);
 

?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO139', '', 'og'); ?> </h2>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-thumb-tack"></i> <?php echo Myclass::t('OGO140', '', 'og'); ?></div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd">
                            <tr>   
                                <th><?php echo Myclass::t('OGO141', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('OG138'); ?></th>
                                <th><?php echo Myclass::t('OG142'); ?></th>
                                <th><?php echo Myclass::t('OG140'); ?></th>
                                <th><?php echo "Txn ID"; ?></th>                                
                                <th><?php echo Myclass::t('OG143'); ?></th>
                                <th><?php echo Myclass::t('OGO142', '', 'og'); ?></th>
                            </tr> 
                            <?php if(!empty($get_transactions)){?>
                            <tr>
                                <td><?php echo $get_transactions->item_name; ?></td>
                                <td><?php echo $get_transactions->total_price; ?></td>
                                <td><?php echo ($get_transactions->pay_type==1)?"Paypal":""; ?></td>
                                <td><?php echo $get_transactions->payment_status; ?></td>
                                <td><?php echo $get_transactions->txn_id; ?></td>
                                <td><?php echo $get_transactions->expirydate; ?></td>
                                <td><?php echo $get_transactions->created_at; ?></td>
                            </tr>
                            <?php }else{?>
                            <tr>
                                 <td colspan="7"><?php echo Myclass::t('OGO143', '', 'og'); ?></td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>   
                </div>
            </div>

        </div>
    </div>
</div>
