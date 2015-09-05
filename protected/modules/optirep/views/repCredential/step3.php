<?php $this->renderPartial('_register_steps', array('step' => $step)); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <h2>Payment</h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rep-credential-form',
    ));
    ?>
    <div class="form-group"> 
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 price-details">
                <p> <b>Price Per Account : </b> 
                    <?php echo Myclass::currencyFormat($price_list['per_account_price']); ?> 
                </p>
                <p> <b>Total : </b> 
                    <?php echo Myclass::currencyFormat($price_list['total_price']); ?>
                </p>
                <p> <b>Tax : </b> <?php echo Myclass::currencyFormat($price_list['tax']); ?> </p>
                <p> <b>Grand Total : </b> <?php echo Myclass::currencyFormat($price_list['grand_total']); ?> </p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 pull-right steps-btn-cont">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), ' Make a payment <i class="fa fa-usd"></i>');
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div class="clearfix"> </div>