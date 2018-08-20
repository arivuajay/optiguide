<div class="cate-bg user-right">
    <h2> <i class="fa fa-credit-card"></i> <?php echo Myclass::t('OR650', '', 'or') ?> </h2>
    <div class="row"> 

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'renew-form',
//                        'enableAjaxValidation'=>false,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                )); ?>
                <div class="form-group"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <b><?php echo Myclass::t('OR753', '', 'or') ?> :</b>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="no_of_accounts">
                                <?php
                                $no_of_months = Myclass::noOfMonths();
                                $payment_type = Myclass::enablePaymentGateway();
                                if(isset($payment_type[1])){
                                    $model->payment_type = 1;
                                }else if(isset($payment_type[2])){
                                    $model->payment_type = 2;
                                }
//                                echo CHtml::dropDownList($model,'duration', $no_of_months, array('class' => "form-field"));
                                echo $form->dropDownList($model, 'duration', $no_of_months, array('class' => 'form-field'));
                                echo $form->hiddenField($model, 'no_of_accounts_purchase', array('value' => $no_of_accounts_purchase));
                                echo $form->labelEx($model, 'payment_type');
                                echo $form->dropDownList($model, 'payment_type', $payment_type, array('class' => 'form-field', "prompt" => Myclass::t('OG182')));
                                echo $form->error($model, 'payment_type');
                                echo "<br>";
////                                echo CHtml::dropDownList('duration','month_id',array('1'=>'1 Month','6' => '6 months', '12' => '1 year'), array('class' => "form-field"));
//                                echo CHtml::hiddenField('no_of_accounts_purchase',$no_of_accounts_purchase);
                                ?>
                                
                                <?php
                                echo CHtml::tag('button', array(
                                    'name' => 'btnSubmit',
                                    'value' => 'Payfee',
                                    'type' => 'submit',
                                    'class' => 'register-btn'
                                        ), '<i class="fa fa-check-circle"></i>' . ' Renewal');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                <div class="form-group"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buy_more price-details">
                            <table class="table table-bordered">
                                <tr>
                                    <td> <?php echo Myclass::t('OR576', '', 'or') ?> : </td>
                                    <td>
                                        <span class="c_price">
                                            <?php echo Myclass::currencyFormat($price_calculation['total_price']);  ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR540', '', 'or'); ?> : </td>
                                    <td><span class="c_tax"><?php echo Myclass::currencyFormat($price_calculation['tax']); ?></span></td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR541', '', 'or'); ?> : </td>
                                    <td><span class="c_total">
                                        <b> <?php echo Myclass::currencyFormat($price_calculation['grand_total']); ?> </b></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
$js = <<<EOD
        $(document).ready(function () {
            $("#RepCredentials").change(function ()
            { 
                var id=$(this).val();
                var accounts_purchase = $("#no_of_accounts_purchase").val();
                 $.ajax
               ({
                    type: "POST",
                    url: "getPrice",
                    data: "month="+id+"&accounts_purchase="+accounts_purchase,
                   dataType: 'json',
                  cache: false,
                  success: function(data) {
                    $(".c_price").html(data.total_price);
                    $(".c_total").html(data.grand_total);
                    $(".c_tax").html(data.tax);
                  } 
 
               });
            });
        });
EOD;

Yii::app()->clientScript->registerScript('_buy_more_accounts', $js);
?>