<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'buy-more-accounts-form',
        ));
?>
<div class="cate-bg user-right">
    <h2> Buy More Rep Accounts </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">    
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

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
            <div class="form-group"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 price-details">
                        <table class="table table-bordered">
                            <tr>
                                <td>Price Per Account : </td>
                                <td><span id="per_acc_price"></span></td>
                            </tr>
                            <tr>
                                <td>Total : </td>
                                <td><span id="total_price"></span></td>
                            </tr>
                            <tr>
                                <td>Tax : </td>
                                <td><span id="tax_price"></span></td>
                            </tr>
                            <tr>
                                <td>Grand Total : </td>
                                <td><span id="grand_total"></span></td>
                            </tr>
                        </table>
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
$ajaxPriceListURL = Yii::app()->createUrl('/optirep/repAccounts/buyMoreAccountsPriceList');
$js = <<<EOD
    $(document).ready(function(){
        getAccountPrice();
        
        $("body").on("change", "#RepCredentials_no_of_accounts_purchase", function() {
            getAccountPrice();
        });
        
        $("body").on("click", ".input-group-btn", function() {
            getAccountPrice();
        });
        
        $('.no_of_accounts_input').bootstrapNumber();
    });
        
        
    function getAccountPrice() {
        var no_of_accounts = $("#RepCredentials_no_of_accounts_purchase").val();
        var dataString = 'no_of_accounts='+ no_of_accounts;
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