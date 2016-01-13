<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR528', '', 'or'); ?> </h2>
    <div class="row"> 

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <?php
                $securetoken = $response['SECURETOKEN'];
                $securetokenid = $response['SECURETOKENID'];
                $mode = $response['mode'];
                ?>
                <iframe src='https://payflowlink.paypal.com?SECURETOKEN=<?php echo $securetoken; ?>&SECURETOKENID=<?php echo $securetokenid; ?>&MODE=<?php echo $mode ?>' width='490' height='350' border='0' frameborder='0' scrolling='no' allowtransparency='true'>\n</iframe>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                <div class="form-group"> 
                    <div class="row">
                        <?php
                        $new_subscription = Yii::app()->session['buy_more_accounts'];
                        $price_list = $new_subscription['price_list'];
                        ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buy_more price-details">
                            <table class="table table-bordered">
                                <tr>
                                    <td> <?php echo Myclass::t('OR538', '', 'or'); ?> : </td>
                                    <td><?php echo Myclass::currencyFormat($price_list['per_account_price']); ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR539', '', 'or'); ?> : </td>
                                    <td><?php echo Myclass::currencyFormat($price_list['total_price']); ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR540', '', 'or'); ?> : </td>
                                    <td><?php echo Myclass::currencyFormat($price_list['tax']); ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo Myclass::t('OR541', '', 'or'); ?> : </td>
                                    <td><?php echo Myclass::currencyFormat($price_list['grand_total']); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
