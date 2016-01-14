<div class="cate-bg user-right">
  <h2> <?php echo Myclass::t('OR580', '', 'or') ?> </h2>
    <div class="row">    
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                 <?php
                    echo " <div style='margin-left:40px; width:492px; height:567px;'>
                    <iframe src='https://payflowlink.paypal.com?SECURETOKEN=".$securetoken."&SECURETOKENID=".$securetokenid."&MODE=".$mode."' width='490' height='565' border='0' frameborder='0' scrolling='no' allowtransparency='true'>\n</iframe>
                </div>";
                   ?>     
            </div>
    </div>
</div>    