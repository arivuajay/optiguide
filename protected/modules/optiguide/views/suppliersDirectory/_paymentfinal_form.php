<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OGO104', '', 'og'); ?></div>
                <div class="row"> 
                   <?php
                    echo " <div style='margin-left:40px; width:492px; height:567px;'>
                    <iframe src='https://payflowlink.paypal.com?SECURETOKEN=".$securetoken."&SECURETOKENID=".$securetokenid."&MODE=".$mode."' width='490' height='565' border='0' frameborder='0' scrolling='no' allowtransparency='true'>\n</iframe>
                </div>";
                   ?>

                </div>
            </div>
            
        </div>
    </div> 
</div>  
