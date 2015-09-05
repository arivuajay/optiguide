<?php $this->renderPartial('_register_steps', array('step' => $step)); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <h2> price & subscription  </h2>
    <div class="row">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'rep-credential-form',
        ));
        $repSubscriptionTypes = RepSubscriptionTypes::model()->findAll();
        echo $form->errorSummary($model);
        ?>
        <?php foreach ($repSubscriptionTypes as $repSubsTypeId => $repSubscriptionType) { ?>
            <?php
            $checked = '';
            $active_class = '';
            if (isset(Yii::app()->session['registration']['step1'])) {
                if ($repSubscriptionType['rep_subscription_type_id'] == Yii::app()->session['registration']['step1']['subscription_type_id']) {
                    $checked = 'checked';
                    $active_class = '';
                } else {
                    $active_class = 'selected';
                }
            }
            ?>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->radioButton($model, 'subscription_type_id', array('value' => $repSubscriptionType['rep_subscription_type_id'], 'uncheckValue' => null, 'class' => 'subscription_types', 'id' => $repSubsTypeId, 'checked' => $checked)); ?>
                <label for="<?php echo $repSubsTypeId; ?>">
                    <div class="subscription-cont <?php echo $active_class ?>">
                        <div class="subscription-heading">  <?php echo $repSubscriptionType['rep_subscription_name']; ?> </div>
                        <div class="subscription-txt"> 
                            <p> 
                                <span> 
                                    <?php echo Myclass::currencyFormat($repSubscriptionType['rep_subscription_price']); ?> 
                                </span> <br/>
                                Per month  <br/>
                                +  <br/>
                                <?php echo $repSubscriptionType['rep_subscription_description']; ?>
                            </p>
                            <p><a href="javascript:void()" class="subscribe-btn"> Subscribe </a></p>
                        </div>
                    </div>
                </label>
            </div>
        <?php } ?>
        <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 pull-right steps-btn-cont"> 
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), ' Next <i class="fa fa-angle-double-right"></i>');
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="clearfix"> </div>
<?php
$js = <<< EOD
    $(document).ready(function () {
        $('.subscription-cont').click(function(){
            $('.subscription-cont').addClass("selected");
            $(this).removeClass( "selected" );    
        });
    }); 
EOD;
Yii::app()->clientScript->registerScript('_step1', $js);
?>