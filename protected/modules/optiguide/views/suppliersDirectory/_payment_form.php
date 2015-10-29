<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;

$subprices     = SupplierSubscriptionPrice::model()->findByPk(1);
$profile_price = $subprices->profile_price;
$profile_logo_price = $subprices->profile_logo_price;
$tax_price = $subprices->tax;
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>

            <?php  $this->renderPartial('_menu_steps', array());?>
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
                            <?php echo $form->labelEx($pmodel, 'payment_type', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($pmodel, 'payment_type', array('1' => 'Paypal'), array('class' => 'selectpicker', "empty" => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($pmodel, 'payment_type'); ?>
                        </div>
                    </div>    

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($pmodel, 'subscription_type', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($pmodel, 'subscription_type', array('1' => Myclass::t('OGO110', '', 'og'), '2' => Myclass::t('OGO111', '', 'og')), array('class' => 'selectpicker', "empty" => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($pmodel, 'subscription_type'); ?>
                        </div>
                    </div> 

                    <div id="catlogo">

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($pmodel, 'ID_CATEGORIE', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">             
                                <?php echo $form->dropDownList($pmodel, 'ID_CATEGORIE', $getallcat, array('class' => 'form-control', 'empty' => Myclass::t('APP60'))); ?>         
                                <?php echo $form->error($pmodel, 'ID_CATEGORIE'); ?>
                            </div>
                        </div>

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($pmodel, 'TITRE_FICHIER', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">            
                                <?php echo $form->textField($pmodel, 'TITRE_FICHIER', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                <?php echo $form->error($pmodel, 'TITRE_FICHIER'); ?>
                            </div>
                        </div>

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

                    <div id="price">
                        
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                 <?php echo $form->labelEx($pmodel, 'amount', array()); ?>  
                            </div>  
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                                 <div id="sprice"> </div>
                            </div>
                        </div>   
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <label>Tax</label> 
                            </div>  
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                                <div id="stax"></div>
                            </div>
                        </div>      
                       <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <label>Grand Total</label>
                            </div>  
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                                <div id="stotalprice"></div> 
                            </div>
                        </div> 
                        
                    </div>

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
            <?php $this->endWidget(); ?>
        </div>
    </div> 
</div>   
<?php
$taxval_profile      = $profile_price*($tax_price/100);
$taxval_profile_logo = $profile_logo_price*($tax_price/100);

$grandtotal_profile = ( $profile_price + $taxval_profile);
$grandtotal_profile_logo = ( $profile_logo_price + $taxval_profile_logo);

$currency  = CURRENCY;
$p_price   = $profile_price.' '.$currency;
$p_l_price = $profile_logo_price.' '.$currency;

$js = <<< EOD
$(document).ready(function(){ 
        
    var currency           = '{$currency}';     
    var profile_price      = '{$p_price}';   
    var profile_logo_price = '{$p_l_price}';  
    
    var tax_profile = '{$taxval_profile}';
    var tax_profile_logo = '{$taxval_profile_logo}';
    
    var grandtotal_profile = '{$grandtotal_profile}';
    var grandtotal_profile_logo = '{$grandtotal_profile_logo}';
        
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
