<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR543', '', 'or'); ?> </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'buy-more-accounts-form',
                ));
                ?>
                <div class="card-details-cont">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                        <?php echo $form->hiddenField($model_paypal, 'pay_type', array('value' => 1)); ?> 
                        <h4> &nbsp; <?php echo Myclass::t('OR651', '', 'or') ?> </h4> 
                        <?php
                        $paypal_buttton = CHtml::image($this->themeUrl . "/images/express-checkout-hero.png", "paypal", array('img-responsive'));
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'value' => 'Payfee',
                            'type' => 'submit',
                            'class' => 'paypal_btn'
                                ), $paypal_buttton);
                        ?>
                    </div>
                </div>  
                <?php $this->endWidget(); ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'buy-more-accounts-form',
                ));
                ?>
                <div class="card-details-cont">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <?php
                            echo $form->errorSummary(array($model_paypaladvance));
                            echo $form->hiddenField($model_paypaladvance, 'pay_type', array('value' => 2));
                            ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h3> <?php echo Myclass::t('OR652', '', 'or') ?> </h3>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"> 
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
                            </div>

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
                <?php $this->endWidget(); ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            <?php $data = Yii::app()->session['renewal']; ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                <div class="form-group"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 price-details">
                            <p> 
                                <?php echo Myclass::t('OR544', '', 'or'); ?> :
                                <?php echo $data['no_of_accounts_purchase']; ?> 
                            </p>
                            <p> 
                                <?php echo Myclass::t('OR538', '', 'or'); ?> : 
                                <?php echo Myclass::currencyFormat($data['price_list']['per_account_price']); ?> 
                            </p>
                            <p> 
                                <?php echo Myclass::t('OR539', '', 'or'); ?> :  
                                <?php echo Myclass::currencyFormat($data['price_list']['total_price']); ?> 
                            </p>
                            <p> 
                                <?php echo Myclass::t('OR540', '', 'or'); ?> : 
                                <?php echo Myclass::currencyFormat($data['price_list']['tax']); ?> 
                            </p>
                            <p> 
                                <b> <?php echo Myclass::t('OR541', '', 'or'); ?> : </b> 
                                <?php echo Myclass::currencyFormat($data['price_list']['grand_total']); ?> 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>