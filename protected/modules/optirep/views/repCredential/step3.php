<?php $this->renderPartial('_register_steps', array('step' => $step)); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <h2><?php echo Myclass::t('OR550', '', 'or'); ?></h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rep-credential-form',
    ));
    ?>
    <div class="form-group"> 
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 price-details">
                <p> 
                    <b><?php echo Myclass::t('OR558', '', 'or'); ?> : </b> 
                    <?php echo $price_list['no_of_accounts_purchased']; ?> 
                </p>
                <p> 
                    <b><?php echo Myclass::t('OR559', '', 'or'); ?> : </b> 
                    <?php echo $price_list['no_of_months']; ?> 
                </p>
                <p> 
                    <b><?php echo Myclass::t('OR560', '', 'or'); ?> : </b> 
                    <?php echo Myclass::currencyFormat($price_list['per_account_price']); ?> 
                </p>
                <?php if ($price_list['offer_in_percentage'] && $price_list['offer_price']) { ?>
                    <p> 
                        <b><?php echo Myclass::t('OR561', '', 'or'); ?> : </b> 
                        <?php echo Myclass::currencyFormat($price_list['total_month_price']); ?> 
                    </p>
                    <p> 
                        <b><?php echo Myclass::t('OR562', '', 'or'); ?> : </b> 
                        <?php echo $price_list['offer_in_percentage'] . '%'; ?> 
                    </p>
                    <p> 
                        <b><?php echo Myclass::t('OR563', '', 'or'); ?> : </b> 
                        <?php echo Myclass::currencyFormat($price_list['offer_price']); ?> 
                    </p>
                <?php } ?>
                <p> 
                    <b><?php echo Myclass::t('OR539', '', 'or'); ?> : </b> 
                    <?php echo Myclass::currencyFormat($price_list['total_price']); ?>
                </p>
                <p> 
                    <b><?php echo Myclass::t('OR540', '', 'or'); ?> : </b> 
                    <?php echo Myclass::currencyFormat($price_list['tax']); ?> 
                </p>
                <p> 
                    <b><?php echo Myclass::t('OR541', '', 'or'); ?> : </b> 
                    <?php echo Myclass::currencyFormat($price_list['grand_total']); ?> 
                </p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 pull-right steps-btn-cont">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), Myclass::t('OR564', '', 'or') . ' <i class="fa fa-usd"></i>');
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div class="clearfix"> </div>