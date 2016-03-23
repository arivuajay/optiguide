<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;

$relid = Yii::app()->user->relationid;
$get_expirydate = SuppliersDirectory::model()->findByPk($relid);

$profile_expirydate = $get_expirydate['profile_expirydate'];
$logo_expirydate = $get_expirydate['logo_expirydate'];

$subprices = SupplierSubscriptionPrice::model()->findByPk(1);
//$tax_price = $subprices->tax;
$tax_price = $tax_price;
$profile_price = $subprices->profile_price;
$profile_logo_price = $subprices->profile_logo_price;
$logo_price = $profile_logo_price - $profile_price;

$currency = CURRENCY;
// Subscription Price
$p_price   = $profile_price . ' ' . $currency;
$l_price   = $logo_price . ' ' . $currency;
$p_l_price = $profile_logo_price . ' ' . $currency;

$taxval_profile = $profile_price * ($tax_price / 100) . $currency;
$taxval_logo    = $logo_price * ($tax_price / 100) . $currency;
$taxval_profile_logo = $profile_logo_price * ($tax_price / 100) . $currency;

$grandtotal_profile = ( $profile_price + $taxval_profile) . $currency;
$grandtotal_logo    = ( $logo_price + $taxval_logo) . $currency;
$grandtotal_profile_logo = ( $profile_logo_price + $taxval_profile_logo) . $currency;
?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO201','','og');?></h2>     

            <div class="row"> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered" id="bckrnd">
                        <tr>  
                            <th><?php echo Myclass::t('OGO190','','og');?></th>
                            <th><?php echo Myclass::t('OGO191','','og');?></th>                        
                        </tr>                             
                        <tr>                              
                            <td><?php echo ($profile_expirydate=="0000-00-00 00:00:00")?Myclass::t('OGO200','','og'):date("d-m-Y", strtotime($profile_expirydate)); ?></td>
                            <td><?php echo ($logo_expirydate=="0000-00-00 00:00:00")?Myclass::t('OGO200','','og'):date("d-m-Y", strtotime($logo_expirydate)); ?></td>
                        </tr>
                    </table>                    
                </div>                  
            </div>
            
            <p><?php echo Myclass::t('OGO193','','og');?></p>

            <h4><?php echo Myclass::t('OGO194','','og');?></h4>
            <ul class="renewal">
                <li><?php echo Myclass::t('OGO195','','og');?></li>
                <li><?php echo Myclass::t('OGO196','','og');?></li>
                <li><?php echo Myclass::t('OGO197','','og');?></li>
            </ul>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
                'htmlOptions' => array('role' => 'form'),
                 'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            
            ?>    
            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-thumb-tack"></i> <?php echo Myclass::t('OGO198','','og');?></div>
                <div class="row"> 
                    
                     <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($pmodel, 'payment_type', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php 
                            if(!isset($pmodel->payment_type)){$pmodel->payment_type="2";}
                            //echo $form->dropDownList($pmodel, 'payment_type', array('1' => 'Paypal', '2' => 'Pay with credit card'), array('class' => 'selectpicker'));                           
                              echo $form->hiddenField($pmodel, 'payment_type',array('value'=>'2'));?>   
                            <?php //echo $form->error($pmodel, 'payment_type'); ?>
                            
                            <?php echo $form->hiddenField($pmodel, 'subscription_type'); ?>
                        </div>
                    </div>    
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 creditcardtbl">
                        <table class="table table-bordered" id="bckrnd">
                            <tr>   
                                <th><?php echo Myclass::t('OGO202', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('OGO141', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('OG138'); ?></th>                        
                            </tr>                             
                            <tr>
                                <td><input type="checkbox" id="profile" name="subvals[]" <?php if(isset($sub_types)){ if(in_array('1', $sub_types)){ echo "checked=checked"; } }?> value="1" ></td>
                                <td>Profile</td>
                                <td><?php echo $profile_price; ?> CAD</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="logo" name="subvals[]" <?php if(isset($sub_types)){ if(in_array('3', $sub_types)){ echo "checked=checked"; } }?> value="3" ></td>
                                <td>Logo</td>
                                <td><?php echo $logo_price; ?> CAD</td>
                            </tr>
                        </table>
                        <div id="errormsg" class="errorMessage" style="display:none;"><?php echo Myclass::t('OGO192','','og');?></div>
                    </div> 
                    
                    <div id="price" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display:none;">   
                        <p> <b><?php echo Myclass::t('OG138'); ?> : </b>
                            <span id="sprice_profile" style="display:none;"><?php echo number_format($p_price, 2, '.', '');?></span>
                            <span id="sprice_logo" style="display:none;"><?php echo number_format($l_price, 2, '.', '');?></span>
                            <span id="sprice_profile_logo" style="display:none;"><?php echo number_format($p_l_price, 2, '.', '');?></span>
                        </p>               
                        <p> <b><?php echo Myclass::t('OG176'); ?> : </b>
                            <span id="stax_profile" style="display:none;"><?php echo number_format($taxval_profile, 2, '.', '');?></span>
                            <span id="stax_logo" style="display:none;"><?php echo number_format($taxval_logo, 2, '.', '');?></span>
                            <span id="stax_profile_logo" style="display:none;"><?php echo number_format($taxval_profile_logo, 2, '.', '');?></span>
                        </p>
                        <p> <b><?php echo Myclass::t('OG177'); ?>: </b>
                            <span id="stotalprice_profile" style="display:none;"><?php echo number_format($grandtotal_profile, 2, '.', '');?></span>
                            <span id="stotalprice_logo" style="display:none;"><?php echo number_format($grandtotal_logo, 2, '.', '');?></span>
                            <span id="stotalprice_profile_logo" style="display:none;"><?php echo number_format($grandtotal_profile_logo, 2, '.', '');?></span>
                        </p>
                    </div>
                    
                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                            <?php
                            echo CHtml::tag('button', array(
                                'name' => 'btnSubmit',
                                'type' => 'submit',
                                'value' => 'Payfee',
                                'class' => 'submit-btn'
                                    ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO199', '', 'og'));
                            ?>
                        </div>
                    </div>
                    
<!--                <div class="form-row1" id="paypal"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                            <div class="card-details-cont"> 
                                <div class="col-xs-12 col-sm-11 col-md-7 col-md-offset-5 col-lg-5 col-lg-offset-7" id="paypal_align">  <h4> &nbsp; The Faster, Safer way to pay </h4> 
                                    <?php
//                                    $paypal_buttton = CHtml::image($this->themeUrl . "/images/express-checkout-hero.png", "paypal", array('img-responsive'));
//                                    echo CHtml::tag('button', array(
//                                        'name' => 'btnSubmit',
//                                        'value' => 'Payfee',
//                                        'type' => 'submit',
//                                        'class' => 'paypal_btn'
//                                            ), $paypal_buttton);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div> -->

<!--                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="creditcard" style="display:none;"> 
                        <div class="card-details-cont"> 
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h4> Pay with debit card or credit card </h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"> <?php //echo $form->labelEx($model_paypaladvance, 'credit_card'); ?>  </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                                    <?php //echo $form->textField($model_paypaladvance, 'credit_card', array('class' => "form-txtfield")); ?>
                                    <?php //echo $form->error($model_paypaladvance, 'credit_card'); ?>
                                </div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-5 col-md-6 col-lg-4">   </div>
                                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4">  <?php //echo CHtml::image($this->themeUrl . '/images/payment-icons.jpg', '', array("class" => 'pay-icon')); ?></div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"><label><?php //echo Myclass::t('OR653', '', 'or') ?>&nbsp;<span class="required">*</span></label> </div>
                                <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">  <?php //echo $form->textField($model_paypaladvance, 'exp_month', array('class' => "form-txtfield", "placeholder" => "MM")); ?> 
                                </div>
                                <span> / </span>
                                <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">  <?php //echo $form->textField($model_paypaladvance, 'exp_year', array('class' => "form-txtfield", "placeholder" => "YYYY")); ?> </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">&nbsp;</div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <?php //echo $form->error($model_paypaladvance, 'exp_month'); ?>
                                    <?php //echo $form->error($model_paypaladvance, 'exp_year'); ?>
                                </div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4"> <?php //echo $form->labelEx($model_paypaladvance, 'cvv2'); ?></div>
                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">  
                                    <?php //echo $form->textField($model_paypaladvance, 'cvv2', array('class' => "form-txtfield")); ?>                                    
                                </div>                                
                                <div class="clearfix"></div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">&nbsp;</div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <?php //echo $form->error($model_paypaladvance, 'cvv2'); ?>
                                </div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                                    <?php
//                                    echo CHtml::tag('button', array(
//                                        'name' => 'btnSubmit',
//                                        'type' => 'submit',
//                                        'value' => 'Payfee',
//                                        'class' => 'submit-btn'
//                                            ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO199', '', 'og'));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    
                </div>              
            </div>
            <?php $this->endWidget(); ?>          
        </div>       
    </div>
</div>
<?php
$selectedvals = '';
if(isset($sub_types)){ 
    $profile_flag = 0;
    $logo_flag    = 0;
    $profile_logo_flag = 0;    
    
    if(in_array('1', $sub_types)){
       $profile_flag = 1;
       $selectedvals = "profile";
    }
    if(in_array('3', $sub_types)){
       $logo_flag = 1;
       $selectedvals = "logo";
    }
    if($profile_flag==1 && $logo_flag==1)
    {
        $selectedvals = "profile,logo";
    }    
}

$js = <<< EOD
$(document).ready(function(){        
    
   $("#suppliers-directory-form").submit(function() {
        $("#errormsg").hide();   
        var checked = $(this).find("input[name='subvals[]']:checked").length;   
        if ( checked == 0 )     {
            $("#errormsg").show();
            return false;
        }           
    }); 
   
   //Check the payment method 
    var paytype_val=$("#SuppliersSubscription_payment_type").val();
   // chnagemethod(paytype_val); 
    
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
     
   //Check the subscriptions  method      
    var selectvals  = '{$selectedvals}';
    dispvals(selectvals);
       
   $('input').on('ifChanged', function(event){        
        
        $("#sprice_profile").hide();
        $("#stax_profile").hide();
        $("#stotalprice_profile").hide();
        $("#sprice_logo").hide();
        $("#stax_logo").hide();
        $("#stotalprice_logo").hide();
        $("#sprice_profile_logo").hide();
        $("#stax_profile_logo").hide();
        $("#stotalprice_profile_logo").hide();
        
        var someObj = {};
        someObj.subtypes = [];

        $("input:checkbox").each(function() {
            if ($(this).is(":checked")) {               
                      someObj.subtypes.push($(this).attr("id"));               
            } 
        });
        
       var selectedvals = someObj.subtypes;
       dispvals(selectedvals);
        
    });
        
    function dispvals(selectedvals)
    {
         if(selectedvals=="")
        {
            $("#price").hide();
        }else
        {
            $("#price").show();
        }
        
        if(selectedvals=="profile")
        {            
            $("#sprice_profile").show();
            $("#stax_profile").show();
            $("#stotalprice_profile").show();
            $("#SuppliersSubscription_subscription_type").val("1");
        }
        
        if(selectedvals=="logo")
        {
            $("#sprice_logo").show();
            $("#stax_logo").show();
            $("#stotalprice_logo").show();
            $("#SuppliersSubscription_subscription_type").val("3");
        }
        
        if(selectedvals=="profile,logo")
        {
            $("#sprice_profile_logo").show();
            $("#stax_profile_logo").show();
            $("#stotalprice_profile_logo").show();
            $("#SuppliersSubscription_subscription_type").val("2");
        }
    }    
        
 });
EOD;
Yii::app()->clientScript->registerScript('_form_payment', $js);
?>
