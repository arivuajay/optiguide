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
    <?php
    $step1_name = "<h4>" . Myclass::t('OR547', '', 'or') . " 1 </h4> <span> " . Myclass::t('OR548', '', 'or') . " </span>";
    $step2_name = "<h4>" . Myclass::t('OR547', '', 'or') . " 2 </h4> <span> " . Myclass::t('OR549', '', 'or') . " </span>";
    $step3_name = "<h4>" . Myclass::t('OR547', '', 'or') . " 3 </h4> <span> " . Myclass::t('OR550', '', 'or') . " </span>";
    ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 steps-cont <?php echo $active_class_step1 ?>"> 
        <?php if (isset(Yii::app()->session['registration']['step1'])) { ?>
            <?php echo CHtml::link($step1_name, '/optirep/repCredential/step1') ?>
        <?php } else { ?>
            <?php echo $step1_name; ?>
        <?php } ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 steps-cont <?php echo $active_class_step2 ?>"> 
        <?php if (isset(Yii::app()->session['registration']['step2'])) { ?>
            <?php echo CHtml::link($step2_name, '/optirep/repCredential/step2') ?>
        <?php } else { ?>
            <?php echo $step2_name; ?>
        <?php } ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 steps-cont <?php echo $active_class_step3 ?>">  
        <?php if (isset(Yii::app()->session['registration']['step3'])) { ?>
            <?php echo CHtml::link($step3_name, '/optirep/repCredential/step3') ?>
        <?php } else { ?>
            <?php echo $step3_name; ?>
        <?php } ?>
    </div>
</div>