<?php

$this->renderPartial('_register_steps', array('step' => $step)); 
?>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <div class="form-group"> 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2><i class="fa fa-credit-card"></i> <?php echo Myclass::t('OR550', '', 'or'); ?></h2>

                <div class="register card-details-cont">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        
                        <div style='margin-left:40px; width:492px; height:367px;'>
                            <iframe src='https://payflowlink.paypal.com?SECURETOKEN=<?php echo $securetoken; ?>&SECURETOKENID=<?php echo $securetokenid; ?>&MODE=<?php echo $mode ?>' width='490' height='350' border='0' frameborder='0' scrolling='no' allowtransparency='true'>\n</iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"> </div>