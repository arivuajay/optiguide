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
            <p><?php echo Myclass::t('OR724', '', 'or') ?></p>
         </div>   
        <?php
        if(Yii::app()->user->rep_role=="single")
        {?>    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stats-tips">          
<!--        <b><?php //echo Myclass::t('OR725', '', 'or') ?></b>-->
            <ul>
                <li><i class="fa fa-check-square-o"></i> <?php echo Myclass::t('OR726', '', 'or') ?></li>
            </ul>
        </div>
        <?php
        }?>
        <?php
        if(Yii::app()->user->rep_role=="admin")
        {?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 stats-tips">
<!--        <b><?php //echo Myclass::t('OR727', '', 'or') ?></b>-->
            <ul>
                <li><i class="fa fa-check-square-o"></i> <?php echo Myclass::t('OR728', '', 'or') ?></li>
                <li><i class="fa fa-check-square-o"></i> <?php echo Myclass::t('OR729', '', 'or') ?></li>
                <li><i class="fa fa-check-square-o"></i> <?php echo Myclass::t('OR730', '', 'or') ?></li>
            </ul>
        </div>
        <?php
        }?>
    </div>            
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4> <?php echo Myclass::t('OR581', '', 'or'); ?>: <?php echo Myclass::currencyFormat($stats_price); ?> </h4>
        </div> 
        <?php
        if (!empty($get_transactions)) {
            $stype = CHtml::hiddenField('subscription_type', '4');
            $btntxt = Myclass::t('OR582', '', 'or');
        } else {
            $stype = CHtml::hiddenField('subscription_type', '3');
            $btntxt = Myclass::t('OR583', '', 'or');
        }
        ?>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'htmlOptions' => array(
                'role' => 'form',
                "autocomplete" => "off"
            ),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'hideErrorMessage' => true,
            ),
        ));
        echo $stype;
        echo $form->hiddenField($model_paypal, 'pay_type', array('value' => 2));
                    ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <?php
             echo CHtml::tag('button', array(
                                'name' => 'btnSubmit',
                               'value' => 'Payfee',
                               'type' => 'submit',
                                'class' => 'register-btn'
                                    ), '<i class="fa fa-check-circle"></i>' . Myclass::t('OR733', '', 'or'));
            ?>
            
        </div>
         <?php $this->endWidget(); ?> 
        
<!--        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="card-details-cont">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                    <?php
//                    $form = $this->beginWidget('CActiveForm', array(
//                        'htmlOptions' => array('role' => 'form'),
//                    ));
//                    echo $form->hiddenField($model_paypal, 'pay_type', array('value' => 1));
//                    echo $stype;
                    ?> 
                    <h4> &nbsp; <?php //echo Myclass::t('OR651', '', 'or') ?> </h4> 
                    <?php
//                    $paypal_buttton = CHtml::image($this->themeUrl . "/images/express-checkout-hero.png", "paypal", array('img-responsive'));
//                    echo CHtml::tag('button', array(
//                        'name' => 'btnSubmit',
//                        'value' => 'Payfee',
//                        'type' => 'submit',
//                        'class' => 'paypal_btn'
//                            ), $paypal_buttton);
//                    ?>
                    <?php //$this->endWidget(); ?>
                </div>
            </div>  
        </div>-->

<!--        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"> 
            <div class="card-details-cont">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php
//                    $form = $this->beginWidget('CActiveForm', array(
//                        'htmlOptions' => array(
//                            'role' => 'form',
//                            "autocomplete" => "off"
//                        ),
//                        'clientOptions' => array(
//                            'validateOnSubmit' => true,
//                            'hideErrorMessage' => true,
//                        ),
//                    ));
//                    echo $stype;
                    ?>
                    <div class="row">
                        <?php
//                        echo $form->errorSummary(array($model_paypaladvance));
//                        echo $form->hiddenField($model_paypaladvance, 'pay_type', array('value' => 2));
                        ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3> <?php //echo Myclass::t('OR652', '', 'or') ?> </h3>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"> 
                            <?php //echo $form->labelEx($model_paypaladvance, 'credit_card'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8"> 
                            <?php //echo $form->textField($model_paypaladvance, 'credit_card', array('class' => "form-field")); ?>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-6 col-lg-4 hidden-sm hidden-md"></div>
                        <div class="col-xs-12 col-sm-7 col-md-6 col-lg-5">
                            <?php //echo CHtml::image($this->themeUrl . '/images/payment-icons.jpg', '', array("class" => 'pay-icon')); ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                            <label><span class="required">*</span><?php echo Myclass::t('OR653', '', 'or') ?></label>
                        </div>
                        <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2"> 
                            <?php //echo $form->textField($model_paypaladvance, 'exp_month', array('class' => "form-field", "placeholder" => "MM")); ?>
                        </div>
                        <span> / </span>
                        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3"> 
                            <?php //echo $form->textField($model_paypaladvance, 'exp_year', array('class' => "form-field", "placeholder" => "YYYY")); ?>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4"> 
                            <?php //echo $form->labelEx($model_paypaladvance, 'cvv2'); ?>
                                                        <br/> 
                                                        <a href="#">What is this ?</a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2"> 
                            <?php //echo $form->textField($model_paypaladvance, 'cvv2', array('class' => "form-field")); ?>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                            <?php
//                            echo CHtml::tag('button', array(
//                                'name' => 'btnSubmit',
//                                'value' => 'Payfee',
//                                'type' => 'submit',
//                                'class' => 'register-btn'
//                                    ), '<i class="fa fa-check-circle"></i>' . Myclass::t('OR733', '', 'or'));
                            ?>
                        </div>
                    </div>
                    <?php //$this->endWidget(); ?> 
                </div>
            </div>
        </div>
        -->
    </div>    
    
     <?php 
            $repid = Yii::app()->user->id;
            $get_statexpirydate = RepCredentials::model()->findByPk($repid);
            $statexpirydate = $get_statexpirydate->stat_expiry_date;
            ?>
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                    <div class="table-responsive">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered stats-table">
                            <tr>
                                <th><?php echo Myclass::t('OR731', '', 'or') ?></th>
                            </tr>
                            <tr>
                                <td><?php echo ($statexpirydate=="0000-00-00 00:00:00")?"-":  Myclass::dateFormat($statexpirydate); ?></td>
                            </tr>                    
                        </table>
                    </div>
                </div>
            </div> 
    
    <?php if (!empty($get_transactions)) { ?>

        <h2> <?php echo Myclass::t('OR584', '', 'or'); ?> </h2>
        <div class="row">    
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                <div class="table-responsive">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered stats-table">
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
                                <td><?php echo ($get_transactions->pay_type == "1") ? "Paypal" : "Credit Card"; ?></td>
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
