<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'renewal-rep-accounts-form',
        ));

$data = Yii::app()->session['renewal'];
?>
<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR543', '', 'or'); ?> </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
            <div class="form-group"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 price-details">
                        <p> 
                            <b> <?php echo Myclass::t('OR544', '', 'or'); ?> : </b> 
                            <?php echo $data['no_of_accounts_purchase']; ?> 
                        </p>
                        <p> 
                            <b> <?php echo Myclass::t('OR538', '', 'or'); ?> : </b> 
                            <?php echo Myclass::currencyFormat($data['price_list']['per_account_price']); ?> 
                        </p>
                        <p> 
                            <b> <?php echo Myclass::t('OR539', '', 'or'); ?> :</b>  
                            <?php echo Myclass::currencyFormat($data['price_list']['total_price']); ?> 
                        </p>
                        <p> 
                            <b> <?php echo Myclass::t('OR540', '', 'or'); ?> : </b> 
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

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), Myclass::t('OR536', '', 'or'));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>