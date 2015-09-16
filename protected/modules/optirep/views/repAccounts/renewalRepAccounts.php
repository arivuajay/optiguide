<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'renewal-rep-accounts-form',
        ));

$data = Yii::app()->session['renewal'];
?>
<div class="cate-bg user-right">
    <h2> Renewal Rep Accounts </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
            <div class="form-group"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 price-details">
                        <p> 
                            <b> No Of Accounts Renewal: </b> 
                            <?php echo $data['no_of_accounts_renewal']; ?> 
                        </p>
                        <p> 
                            <b>Price Per Account : </b> 
                            <?php echo Myclass::currencyFormat($data['price_list']['per_account_price']); ?> 
                        </p>
                        <p> 
                            <b>Total :</b>  
                            <?php echo Myclass::currencyFormat($data['price_list']['total_price']); ?> 
                        </p>
                        <p> 
                            <b>Tax : </b> 
                            <?php echo Myclass::currencyFormat($data['price_list']['tax']); ?> 
                        </p>
                        <p> 
                            <b>Grand Total : </b> 
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
                    ), 'Renewal');
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>