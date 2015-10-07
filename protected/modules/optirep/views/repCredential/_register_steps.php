<?php
$active_class_step1 = $active_class_step2 = $active_class_step3 = '';
if ($step == 'step1') {
    $active_class_step1 = 'active-stpe';
} elseif ($step == 'step2') {
    $active_class_step2 = 'active-stpe';
} elseif ($step == 'step3') {
    $active_class_step3 = 'active-stpe';
}
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ad1">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 steps-cont <?php echo $active_class_step1 ?>"> 
        <?php if (isset(Yii::app()->session['registration']['step1'])) { ?>
            <?php echo CHtml::link('<h4> Step 1 </h4> <span> Select The Subscription  </span>', '/optirep/repCredential/step1') ?>
        <?php } else { ?>
            <h4> Step 1 </h4> <span> Select The Subscription  </span>
        <?php } ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 steps-cont <?php echo $active_class_step2 ?>"> 
        <?php if (isset(Yii::app()->session['registration']['step2'])) { ?>
            <?php echo CHtml::link('<h4> Step 2 </h4> <span> Basic Information  </span>', '/optirep/repCredential/step2') ?>
        <?php } else { ?>
            <h4> Step 2 </h4> <span> Basic Information  </span>
        <?php } ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 steps-cont <?php echo $active_class_step3 ?>">  
        <?php if (isset(Yii::app()->session['registration']['step3'])) { ?>
            <?php echo CHtml::link('<h4> Step 3 </h4> <span> Payment  </span>', '/optirep/repCredential/step3') ?>
        <?php } else { ?>
            <h4> Step 3 </h4> <span> Payment </span> 
        <?php } ?>
    </div>
</div>