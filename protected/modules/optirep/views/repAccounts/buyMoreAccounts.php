<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR528', '', 'or'); ?> </h2>
    <div class="row"> 
        <?php
            $form = $this->beginWidget('CActiveForm', array(                    
                    'htmlOptions' => array('role' => 'form'),
                    'id' => 'buy-more-accounts-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'enableAjaxValidation' => true,
                    
                ));
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
//                $form = $this->beginWidget('CActiveForm', array(
//                    'id' => 'buy-more-accounts-form',
//                ));
                ?>
                <div class="form-group"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $form->labelEx($model, 'no_of_accounts_purchase'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="no_of_accounts">
                                <?php echo $form->numberField($model, 'no_of_accounts_purchase', array('class' => 'no_of_accounts_input', "min" => "1", "step" => "1")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                           <b> <?php echo Myclass::t('OR753', '', 'or') ?></b>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="no_of_accounts">
                                
                                <?php 
                                $no_of_months = Myclass::noOfMonths();
                                echo $form->dropDownList($model,'duration',$no_of_months, array('class' => "form-field")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php // $this->endWidget(); ?>
            </div>

<!--            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
//                $form = $this->beginWidget('CActiveForm', array(
//                    'id' => 'buy-more-accounts-form',
//                ));
                ?>
                <div class="card-details-cont">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                        <?php //echo $form->hiddenField($model_paypal, 'pay_type', array('value' => 1)); ?> 
                        <input type="hidden" id="model_paypal_no_of_accounts_purchase" name="RepCredentials[no_of_accounts_purchase]" class="rep_cred_no_of_acc_purchase">
                        <h4> &nbsp; <?php //echo Myclass::t('OR651', '', 'or') ?> </h4> 
                        <?php
//                        $paypal_buttton = CHtml::image($this->themeUrl . "/images/express-checkout-hero.png", "paypal", array('img-responsive'));
//                        echo CHtml::tag('button', array(
//                            'name' => 'btnSubmit',
//                            'value' => 'Payfee',
//                            'type' => 'submit',
//                            'class' => 'paypal_btn'
//                                ), $paypal_buttton);
                        ?>
                    </div>
                </div>  
                <?php //$this->endWidget(); ?>
            </div>-->

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <?php
                $payment_type = Myclass::enablePaymentGateway();
                if(isset($payment_type[1])){
                    $model->payment_type = 1;
                }else if(isset($payment_type[2])){
                    $model->payment_type = 2;
                }
//                $form = $this->beginWidget('CActiveForm', array(
//                    'htmlOptions' => array(
//                        'role' => 'form',
//                        "autocomplete" => "off"
//                    ),
//                    'id' => 'buy-more-accounts-form',
//                    'clientOptions' => array(
//                        'validateOnSubmit' => true,
//                    ),
//                    'enableAjaxValidation' => true,
//                    
//                ));
                ?>
                <div class="card-details-cont1">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            
                            <div class="no_of_accounts">
                            <?php
                            echo $form->errorSummary(array($model_paypaladvance));
                            echo $form->labelEx($model, 'payment_type');
                            echo $form->dropDownList($model, 'payment_type', $payment_type, array('class' => 'form-field', "prompt" => Myclass::t('OG182')));
                            echo $form->error($model, 'payment_type');
//                            echo $form->hiddenField($model_paypaladvance, 'pay_type', array('value' => 2));
                            ?>
                            </div>                                
                            <input type="hidden" id="model_paypaladvance_no_of_accounts_purchase" name="RepCredentials[no_of_accounts_purchase]" class="rep_cred_no_of_acc_purchase">
                            <input type="hidden" id="RepCredentials_duration" name="RepCredentials[duration]" class="rep_duration">
<!--                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h3> <?php echo Myclass::t('OR652', '', 'or') ?> </h3>
                            </div>-->
<!--                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model_paypaladvance, 'credit_card'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8"> 
                                <?php echo $form->textField($model_paypaladvance, 'credit_card', array('class' => "form-field")); ?>
                            </div>
                            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-4 hidden-sm hidden-md"></div>
                            <div class="col-xs-12 col-sm-7 col-md-6 col-lg-8">
                                <?php echo CHtml::image($this->themeUrl . '/images/payment-icons.jpg', '', array("class" => 'pay-icon')); ?>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                <label><span class="required">*</span><?php echo Myclass::t('OR653', '', 'or') ?></label>
                            </div>
                            <div class="col-xs-5 col-sm-4 col-md-2 col-lg-3"> 
                                <?php echo $form->textField($model_paypaladvance, 'exp_month', array('class' => "form-field", "placeholder" => "MM")); ?>
                            </div>
                            <span> / </span>
                            <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3"> 
                                <?php echo $form->textField($model_paypaladvance, 'exp_year', array('class' => "form-field", "placeholder" => "YYYY")); ?>
                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model_paypaladvance, 'cvv2'); ?>
                                                                <br/> 
                                                                <a href="#">What is this ?</a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-3"> 
                                <?php echo $form->textField($model_paypaladvance, 'cvv2', array('class' => "form-field")); ?>
                            </div>-->

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                <?php
                                echo CHtml::tag('button', array(
                                    'name' => 'btnSubmit',
                                    'value' => 'Payfee',
                                    'type' => 'submit',
                                    'class' => 'register-btn'
                                        ), '<i class="fa fa-check-circle"></i>' . ' Pay Now');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php // $this->endWidget(); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                <div class="form-group"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buy_more price-details">
                            <table class="table table-bordered">
                                <tr>
                                    <td> <?php echo Myclass::t('OR538', '', 'or'); ?> : </td>
                                    <td><span id="per_acc_price"></span></td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR539', '', 'or'); ?> : </td>
                                    <td><span id="total_price"></span></td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR540', '', 'or'); ?> : </td>
                                    <td><span id="tax_price"></span></td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR541', '', 'or'); ?> : </td>
                                    <td><span id="grand_total"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <div class="clearfix"> </div>
                 
        <h3><?php echo Myclass::t('OR569', '', 'or');?>:</h3>
        <?php if(Yii::app()->user->rep_role == 'single'){?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <p><?php echo Myclass::t('OR785', '', 'or');?></p>
        </div>
        <?php } ?>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">       
            <div role="alert" class="alert alert-info subscriptionnotify">
            <strong><?php echo Myclass::t('OR769', '', 'or');?></strong>
            <p>1 <?php echo Myclass::t('OR755', '', 'or');?> - 19.95 CAD/<?php echo Myclass::t('OR755', '', 'or');?> </p>
            <p>6 <?php echo Myclass::t('OR755', '', 'or');?> - 18.95 CAD/<?php echo Myclass::t('OR755', '', 'or');?> </p> 
            <p>1 <?php echo Myclass::t('OR765', '', 'or');?>  - 17.95 CAD/<?php echo Myclass::t('OR755', '', 'or');?> </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">  
            <div role="alert" class="alert alert-info subscriptionnotify">
            <strong><?php echo Myclass::t('OR770', '', 'or');?></strong>
            <p>1 <?php echo Myclass::t('OR755', '', 'or');?> - 17.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p>
            <p>6 <?php echo Myclass::t('OR755', '', 'or');?> - 16.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p> 
            <p>1 <?php echo Myclass::t('OR765', '', 'or');?>  - 15.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">   
            <div role="alert" class="alert alert-info subscriptionnotify">
            <strong><?php echo Myclass::t('OR771', '', 'or');?></strong>
            <p>1 <?php echo Myclass::t('OR755', '', 'or');?> - 15.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p>
            <p>6 <?php echo Myclass::t('OR755', '', 'or');?> - 14.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p> 
            <p>1 <?php echo Myclass::t('OR765', '', 'or');?>  - 13.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">  
            <div role="alert" class="alert alert-info subscriptionnotify">
            <strong><?php echo Myclass::t('OR772', '', 'or');?></strong>
            <p>1 <?php echo Myclass::t('OR755', '', 'or');?> - 12.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p>
            <p>6 <?php echo Myclass::t('OR755', '', 'or');?> - 11.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p> 
            <p>1 <?php echo Myclass::t('OR765', '', 'or');?>  - 10.95 CAD/<?php echo Myclass::t('OR773', '', 'or');?> </p>
            </div>
        </div>
    </div>
</div>

<?php
$ajaxPriceListURL = Yii::app()->createUrl('/optirep/repAccounts/buyMoreAccountsPriceList');
$js = <<<EOD
    $(document).ready(function(){
        getAccountPrice();
        
        $("body").on("change", "#RepCredentials_no_of_accounts_purchase", function() {
            getAccountPrice();
        });
        $("body").on("change", "#RepCredentials_duration", function() {
            getAccountPrice();
        });
        
        $("body").on("click", ".input-group-btn", function() {
            getAccountPrice();
        });
        
        $('.no_of_accounts_input').bootstrapNumber();
        
        
    });
        
        
    function getAccountPrice() {
        var no_of_accounts = $("#RepCredentials_no_of_accounts_purchase").val();
        $('input.rep_cred_no_of_acc_purchase').val(no_of_accounts);
        
        var no_of_month = $('#RepCredentials_duration').val();
        $('input.rep_duration').val(no_of_month);
        var dataString = 'no_of_accounts='+ no_of_accounts +'&no_of_month='+ no_of_month;
//        var dataString = 'no_of_accounts='+ no_of_accounts;
        $.ajax({
            type: "POST",
            url: '{$ajaxPriceListURL}',
            data: dataString,
            cache: false,
            success: function(data){   
                var obj = jQuery.parseJSON (data);
                $('#per_acc_price').html(obj.per_account_price);
                $('#total_price').html(obj.total_price);
                $('#tax_price').html(obj.tax);
                $('#grand_total').html(obj.grand_total);
            }
         });
    }
EOD;

Yii::app()->clientScript->registerScript('_buy_more_accounts', $js);
?>