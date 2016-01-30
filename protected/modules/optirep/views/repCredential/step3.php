<?php $this->renderPartial('_register_steps', array('step' => $step)); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <div class="form-group"> 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <h2><i class="fa fa-credit-card"></i> <?php echo Myclass::t('OR550', '', 'or'); ?></h2>

                <!--                <div class="register card-details-cont">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <?php
                //$form = $this->beginWidget('CActiveForm', array(
                //     'htmlOptions' => array('role' => 'form'),
                // ));
                // echo $form->hiddenField($model_paypal, 'pay_type', array('value' => 1));
                ?> 
                                        <h4> &nbsp; <?php //echo Myclass::t('OR651', '', 'or')     ?> </h4> 
                <?php
//                        $paypal_buttton = CHtml::image($this->themeUrl . "/images/express-checkout-hero.png", "paypal", array('img-responsive'));
//                        echo CHtml::tag('button', array(
//                            'name' => 'btnSubmit',
//                            'value' => 'Payfee',
//                            'type' => 'submit',
//                            'class' => 'paypal_btn'
//                                ), $paypal_buttton);
                ?>
                <?php // $this->endWidget(); ?>
                                    </div>
                                </div> -->

                <div class="register card-details-cont">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <!--                        <?php
//                        $form = $this->beginWidget('CActiveForm', array(
//                            'htmlOptions' => array(
//                                'role' => 'form',
//                                "autocomplete" => "off"
//                            ),
//                        ));
                        ?>
                                                <div class="row">
                        <?php
//                            echo $form->errorSummary(array($model_paypaladvance));
//                            echo $form->hiddenField($model_paypaladvance, 'pay_type', array('value' => 2));
                        ?>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <h3> <?php //echo Myclass::t('OR652', '', 'or')     ?> </h3>
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
//                                echo CHtml::tag('button', array(
//                                    'name' => 'btnSubmit',
//                                    'value' => 'Payfee',
//                                    'type' => 'submit',
//                                    'class' => 'register-btn'
//                                        ), '<i class="fa fa-check-circle"></i>' . ' Pay Now');
                        ?>
                                                    </div>
                                                </div>
                        <?php //$this->endWidget(); ?> -->
                        <?php
                        $securetoken = $response['SECURETOKEN'];
                        $securetokenid = $response['SECURETOKENID'];
                        $mode = $response['mode'];
                        ?>
                            <iframe src='https://payflowlink.paypal.com?SECURETOKEN=<?php echo $securetoken; ?>&SECURETOKENID=<?php echo $securetokenid; ?>&MODE=<?php echo $mode ?>' width='490' height='350' border='0' frameborder='0' scrolling='no' allowtransparency='true'>\n</iframe>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 price-details">
                <p> 
                    <?php echo Myclass::t('OR558', '', 'or'); ?> : 
                    <?php echo $price_list['no_of_accounts_purchased']; ?> 
                </p>
                 <?php //if ($price_list['offer_in_percentage'] && $price_list['offer_price']) { 
                if ( $price_list['offer_price']) { ?>
<!--                    <p> 
                        <?php //echo Myclass::t('OR561', '', 'or'); ?> :  
                        <?php //echo Myclass::currencyFormat($price_list['total_month_price']); ?> 
                    </p>
                    <p> 
                        <?php //echo Myclass::t('OR562', '', 'or'); ?> :  
                        <?php// echo $price_list['offer_in_percentage'] . '%'; ?> 
                    </p>-->
                    <p> 
                        <?php echo Myclass::t('OR768', '', 'or'); ?> : 
                        <?php echo Myclass::currencyFormat($price_list['offer_price']); ?> 
                    </p>
                <?php } ?>
                <p> 
                    <?php echo Myclass::t('OR753', '', 'or'); ?> :
                    <?php echo $price_list['no_of_months'].' '.Myclass::t('OR755', '', 'or'); ?> 
                </p>
                <p> 
                    <?php echo Myclass::t('OR560', '', 'or'); ?> :
                    <?php echo Myclass::currencyFormat($price_list['per_account_price']); ?> 
                </p>                
               
                <p> 
                    <b><?php echo Myclass::t('OR756', '', 'or'); ?> : </b> 
                    <?php echo Myclass::currencyFormat($price_list['total_price']); ?>
                </p>
                <p> 
                    <b><?php echo Myclass::t('OR540', '', 'or'); ?> : </b> 
                    <?php echo Myclass::currencyFormat($price_list['tax']); ?> 
                </p>
                <p> 
                    <b><?php echo Myclass::t('OR757', '', 'or'); ?> : </b> 
                    <?php echo Myclass::currencyFormat($price_list['grand_total']); ?> 
                </p>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"> </div>