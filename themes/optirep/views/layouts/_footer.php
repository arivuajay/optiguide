<?php
$getallcounts_query = Yii::app()->db->createCommand() //this query contains all the data
        ->select('*')
        ->from(array('user_counts'))
        ->where("id=1")
        ->queryAll();

$total_prof = $getallcounts_query[0]['prof_users'];
$prof_display = Myclass::format_numbers_words($total_prof);

$total_retail = $getallcounts_query[0]['ret_users'];
$retail_display = Myclass::format_numbers_words($total_retail);

$total_supp = $getallcounts_query[0]['supp_users'];
$supp_display = Myclass::format_numbers_words($total_supp);

$total_rep = $getallcounts_query[0]['rep_users'];
$rep_display = Myclass::format_numbers_words($total_rep);
?>
<div class="footer-cont">
    <div class="footer-row"> 
        <div class="container"> 
            <div class="row"> 
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">                     
                    <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon1.jpg", 'Footer Icon1') ?>
                    <h2> <?php echo $prof_display; ?> </h2>   <span>  Professionals </span>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                    <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon2.jpg", 'Footer Icon2') ?>
                    <h2> <?php echo $retail_display; ?> </h2>   <span>  Retailers  </span>
                </div>
                <div class="col-xs-12 col-sm-6 
                     col-md-3 col-lg-3">                     
                     <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon3.jpg", 'Footer Icon3') ?>
                    <h2> <?php echo $supp_display; ?></h2>  <span>  Suppliers </span>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">                    
                    <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon4.jpg", 'Footer Icon4') ?>
                    <h2> <?php echo $rep_display; ?></h2> <span>  Sales representatives </span>
                </div>
            </div>
        </div>
    </div>
    <div class="copy"> Copyright © 2015  opti-rep.com. All rights reserved. </div>
</div>