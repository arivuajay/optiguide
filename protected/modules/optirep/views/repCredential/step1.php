<?php $this->renderPartial('_register_steps', array('step' => $step)); ?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 landing-left">  
    <h2> <?php echo Myclass::t('OR555', '', 'or'); ?>  </h2>
    <div class="row">
        <?php
//        $form = $this->beginWidget('CActiveForm', array(
//            'id' => 'rep-credential-form',
//        ));
//        echo $form->errorSummary($model);
        $repSubscriptionTypes = RepSubscriptionTypes::model()->findAll();
        ?>
        <?php foreach ($repSubscriptionTypes as $repSubsTypeId => $repSubscriptionType) { ?>
            <?php
//            $checked = '';
            $active_class = '';
            if (isset(Yii::app()->session['registration']['step1'])) {
                if ($repSubscriptionType['rep_subscription_type_id'] == Yii::app()->session['registration']['step1']['subscription_type_id']) {
//                    $checked = 'checked';
                    $active_class = '';
                } else {
                    $active_class = 'selected';
                }
            }
            ?>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" class="testcl">
                <a href="<?php echo Yii::app()->createUrl('/optirep/repCredential/step1', array('sid' => $repSubscriptionType['rep_subscription_type_id'])); ?>">
                    <?php // echo $form->radioButton($model, 'subscription_type_id', array('value' => $repSubscriptionType['rep_subscription_type_id'], 'uncheckValue' => null, 'class' => 'subscription_types', 'id' => $repSubsTypeId, 'checked' => $checked)); ?>
                  
                        <div class="subscription-cont <?php echo $active_class; ?>">
                            <div class="subscription-heading subscription-heading<?php echo $repSubsTypeId + 1 ?>">  
                                <?php echo $repSubscriptionType['rep_subscription_name']; ?> 
                            </div>
                            <div class="subscription-txt"> 
                                <p> 
                                    <span> 
                                        <?php echo Myclass::currencyFormat($repSubscriptionType['rep_subscription_price']); ?> 
                                    </span> <br/>
                                    Per month  <br/>
                                    +  <br/>
                                    <?php echo $repSubscriptionType['rep_subscription_description']; ?>
                                </p>
                                <p>
                                    <span class="subscribe-btn"> 
                                        <?php echo Myclass::t('OR556', '', 'or'); ?>
                                    </span>
                                </p>
                            </div>
                        </div>                    
                </a>     
            </div>
        <?php } ?>
        <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 pull-right steps-btn-cont" style="display:none;"> 
            <?php
//            echo CHtml::tag('button', array(
//                'name' => 'btnSubmit',
//                'type' => 'submit',
//                'id'   => 'register-step1', 
//                'class' => 'register-btn'
//                    ), Myclass::t('OR557', '', 'or') . ' <i class="fa fa-angle-double-right"></i>');
            ?>
        </div>
        <?php // $this->endWidget(); ?>
    </div>
</div>
<div class="clearfix"> </div>
<?php
$js = <<< EOD
    $(document).ready(function () {
        
//        $(".subscribe-btn").click(function(){
//           alert($(this).closest('.box').children('.needToFind').val())
//           var result= $(this).attr('id').split('_');         
//           alert(result[1]);
//           return false;
//        });
        
//        $(".subscription_types").click(function(){
//       
////          $('.subscription-cont').addClass("selected");
////          $(this).removeClass( "selected" );   
//            $( "#rep-credential-form" ).submit();
//            return false;
//        });
    }); 
EOD;
Yii::app()->clientScript->registerScript('_step1', $js);
?>