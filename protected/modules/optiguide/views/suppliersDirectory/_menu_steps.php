<?php
$currenturl = Yii::app()->request->url;

$act_class      = '';

$firststep_url  = Yii::app()->createUrl('/optiguide/suppliersDirectory/create/');
$secondstep_url = Yii::app()->createUrl('/optiguide/suppliersDirectory/addproducts/');
$thirdstep_url  = Yii::app()->createUrl('/optiguide/suppliersDirectory/addmarques/');
$fourthstep_url = Yii::app()->createUrl('/optiguide/suppliersDirectory/payment/');

 $step2 = Yii::app()->user->getState("secondtab");
 $step3 = Yii::app()->user->getState("thirdtab");
 $step4 = Yii::app()->user->getState("fourthtab");
 
 if($step2!=2)
 {
    $secondstep_url = "javascript:void(0);";
 }  
 
 if($step3!=3)
 {
    $thirdstep_url = "javascript:void(0);";
 }  
 
 if($step4!=4)
 {
    $fourthstep_url = "javascript:void(0);";
 }  
 
 
if($currenturl==$firststep_url)
{
    $act_class1 = "active-stpe";
}else if($currenturl==$secondstep_url)
{
   $act_class2 = "active-stpe"; 
}else if($currenturl==$thirdstep_url)
{
   $act_class3 = "active-stpe";
}else if($currenturl==$fourthstep_url)
{
    $act_class4 = "active-stpe";
}    
?>
<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont <?php echo $act_class1;?>">  
    <a href="<?php echo $firststep_url; ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 1 </h4> <span> <?php echo Myclass::t('OG112'); ?>  </span> </a>
</div>

<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont <?php echo $act_class2;?>">  
    <a href="<?php echo $secondstep_url; ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 2 </h4> <span> <?php echo Myclass::t('OG059', '', 'og'); ?></span> </a>
</div>

<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont <?php echo $act_class3;?>">  
    <a href="<?php echo $thirdstep_url; ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 3 </h4> <span> <?php echo Myclass::t('OG135'); ?></span> </a>
</div>

<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont <?php echo $act_class4;?>">  
    <a href="<?php echo $fourthstep_url; ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 4 </h4> <span> <?php echo Myclass::t('OG136'); ?> </span> </a>
</div>
