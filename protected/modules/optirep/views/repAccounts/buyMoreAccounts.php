<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'buy-more-accounts-form',
        ));
?>
<div class="cate-bg user-right">
    <h2> Buy More Rep Accounts </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">    
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
        </div>

        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">  
            <div class="form-group"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 price-details">
                        <p> <b>Price Per Account : </b> 
                            <?php echo Myclass::currencyFormat(0); ?> 
                        </p>
                        <p> <b>Total : </b> 
                            <?php echo Myclass::currencyFormat(0); ?>
                        </p>
                        <p> <b>Tax : </b> <?php echo Myclass::currencyFormat(0); ?> </p>
                        <p> <b>Grand Total : </b> <?php echo Myclass::currencyFormat(0); ?> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), 'Buy');
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$js = <<<EOD
    $(document).ready(function(){
        $('.no_of_accounts_input').bootstrapNumber();
    });
EOD;

Yii::app()->clientScript->registerScript('_buy_more_accounts', $js);
?>