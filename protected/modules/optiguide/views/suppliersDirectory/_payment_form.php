<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;

$subprices = SupplierSubscriptionPrice::model()->findByPk(1);
$profile_price = $subprices->profile_price;
$profile_logo_price = $subprices->profile_logo_price;
$tax_price = $subprices->tax;

$user_infos = Yii::app()->user->getState("uattributes");
$logo_name = $user_infos['USR'];
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>

            <?php $this->renderPartial('_menu_steps', array()); ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
                'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            $getallcat = ArchiveFichier::get_allcategory();
            ?>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OGO104', '', 'og'); ?></div>
                <div class="row"> 
                    
                      <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($pmodel, 'subscription_type', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($pmodel, 'subscription_type', array('1' => Myclass::t('OGO110', '', 'og'), '2' => Myclass::t('OGO111', '', 'og')), array('class' => 'selectpicker', "empty" => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($pmodel, 'subscription_type'); ?>
                        </div>
                    </div> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($pmodel, 'payment_type', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($pmodel, 'payment_type', array('1' => 'Paypal', '2' => 'Pay with credit card'), array('class' => 'selectpicker', "empty" => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($pmodel, 'payment_type'); ?>
                        </div>
                    </div>    

                    <div id="catlogo">
                        <?php
                        $pmodel->ID_CATEGORIE = '300';
                        echo $form->hiddenField($pmodel, 'ID_CATEGORIE');
                        $pmodel->TITRE_FICHIER = $logo_name;
                        echo $form->hiddenField($pmodel, 'TITRE_FICHIER');
                        ?>
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($pmodel, 'image', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->fileField($pmodel, 'image'); ?>                         
                                <?php echo $form->error($pmodel, 'image'); ?>
                            </div>
                        </div>
                    </div>  

                    <div id="price" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        
                        <p> <b>Total : </b>
                            <span id="sprice"><?php echo $p_l_price;?></span>
                        </p>               
                        <p> <b><?php echo Myclass::t('OG176'); ?> : </b>
                            <span id="stax"><?php echo $taxval_profile_logo;?></span>
                        </p>
                        <p> <b><?php echo Myclass::t('OG177'); ?>: </b>
                            <span id="stotalprice"><?php echo $grandtotal_profile_logo;?></span>
                        </p>

                    </div>

                    <div class="form-row1" id="paypal" style="display:none;"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                            <div class="card-details-cont"> 
                                <div class="col-xs-12 col-sm-11 col-md-7 col-md-offset-5 col-lg-5 col-lg-offset-7" id="paypal_align">  <h4> &nbsp; The Faster, Safer way to pay </h4> 
                                    <?php
                                    $paypal_buttton = CHtml::image($this->themeUrl . "/images/express-checkout-hero.png", "paypal", array('img-responsive'));
                                    echo CHtml::tag('button', array(
                                        'name' => 'btnSubmit',
                                        'value' => 'Payfee',
                                        'type' => 'submit',
                                        'class' => 'paypal_btn'
                                            ), $paypal_buttton);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="creditcard" style="display:none;"> 
                        <div class="card-details-cont"> 
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h4> Pay with debit card or credit card </h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"> <?php echo $form->labelEx($model_paypaladvance, 'credit_card'); ?>  </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                                    <?php echo $form->textField($model_paypaladvance, 'credit_card', array('class' => "form-txtfield")); ?>
                                    <?php echo $form->error($model_paypaladvance, 'credit_card'); ?>
                                </div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-5 col-md-6 col-lg-4">   </div>
                                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4">  <?php echo CHtml::image($this->themeUrl . '/images/payment-icons.jpg', '', array("class" => 'pay-icon')); ?></div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"><label><span class="required">*</span><?php echo Myclass::t('OR653', '', 'or') ?></label> </div>
                                <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">  <?php echo $form->textField($model_paypaladvance, 'exp_month', array('class' => "form-txtfield", "placeholder" => "MM")); ?> 
                                </div>
                                <span> / </span>
                                <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">  <?php echo $form->textField($model_paypaladvance, 'exp_year', array('class' => "form-txtfield", "placeholder" => "YYYY")); ?> </div>
                               <div class="clearfix"></div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">&nbsp;</div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <?php echo $form->error($model_paypaladvance, 'exp_month'); ?>
                                    <?php echo $form->error($model_paypaladvance, 'exp_year'); ?>
                                </div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-5 col-md-6 col-lg-4"> <?php echo $form->labelEx($model_paypaladvance, 'cvv2'); ?></div>
                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">  
                                    <?php echo $form->textField($model_paypaladvance, 'cvv2', array('class' => "form-txtfield")); ?>                                    
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">&nbsp;</div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <?php echo $form->error($model_paypaladvance, 'cvv2'); ?>
                                </div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                                    <?php
                                    echo CHtml::tag('button', array(
                                        'name' => 'btnSubmit',
                                        'type' => 'submit',
                                        'class' => 'submit-btn'
                                            ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO103', '', 'og'));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div> 
</div>   
<?php
$taxval_profile = $profile_price * ($tax_price / 100);
$taxval_profile_logo = $profile_logo_price * ($tax_price / 100);

$grandtotal_profile = ( $profile_price + $taxval_profile);
$grandtotal_profile_logo = ( $profile_logo_price + $taxval_profile_logo);

$currency = CURRENCY;
$p_price = $profile_price . ' ' . $currency;
$p_l_price = $profile_logo_price . ' ' . $currency;

$js = <<< EOD
$(document).ready(function(){ 
            
    var currency           = '{$currency}';     
    var profile_price      = '{$p_price}';   
    var profile_logo_price = '{$p_l_price}';  
    
    var tax_profile = '{$taxval_profile}';
    var tax_profile_logo = '{$taxval_profile_logo}';
    
    var grandtotal_profile = '{$grandtotal_profile}';
    var grandtotal_profile_logo = '{$grandtotal_profile_logo}';
    
    var paytype_val=$("#SuppliersSubscription_payment_type").val();
    chnagemethod(paytype_val); 
    
    $("#SuppliersSubscription_payment_type").change(function(){
        var paytype_val= $(this).val();
        chnagemethod(paytype_val);
    }); 
    
     function chnagemethod(paytype_val)
    {
        $('#creditcard').hide();
        $('#paypal').hide();
    
        if(paytype_val=="2")
        {
            $('#creditcard').show();
            $('#paypal').hide();
        }else if(paytype_val=="1")
        {
            $('#creditcard').hide();
            $('#paypal').show();
        }
    }
        
    var subval=$("#SuppliersSubscription_subscription_type").val();
    chnagedrop(subval);    
        
    $("#SuppliersSubscription_subscription_type").change(function(){
        var subval = $(this).val();
        chnagedrop(subval);
    }); 
        
        
    function chnagedrop(subval)
    {
        $('#catlogo').hide();
        $('#price').hide();
        
        if(subval==2)
        {
            $('#catlogo').show();
            $('#price').show();
            $('#sprice').html(profile_logo_price);
            $('#stax').html(tax_profile_logo+" "+currency);
            $('#stotalprice').html(grandtotal_profile_logo+" "+currency);
        }else  if(subval==1)
        {
            $('#catlogo').hide();
            $('#price').show();
            $('#sprice').html(profile_price);
            $('#stax').html(tax_profile+" "+currency);
            $('#stotalprice').html(grandtotal_profile+" "+currency);
        }
    }              
});
EOD;
Yii::app()->clientScript->registerScript('_form_payment', $js);
?>
