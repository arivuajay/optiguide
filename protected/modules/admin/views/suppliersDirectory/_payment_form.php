<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);

?>
<?php
if (isset($model->ID_FOURNISSEUR)) {
    $actionurl = Yii::app()->createUrl('/admin/suppliersDirectory/renewpayment/'); 
}else
{
    $actionurl = Yii::app()->createUrl('/admin/suppliersDirectory/payment/'); 
}    

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'payment-form',
    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
    'action' => $actionurl,
        ));

$marids = Yii::app()->user->getState("marque_ids");
$proids = Yii::app()->user->getState("product_ids");
//echo "<pre>";
// print_r($proids );
// print_r($marids );
//echo "</pre>"; 
$pmodel->pay_type = isset($pmodel->pay_type) ? $pmodel->pay_type : 1;

$price_infos = SupplierSubscriptionPrice::model()->findByPk(1);
$profileprce = $price_infos->profile_price;
$profile_logoprce = $price_infos->profile_logo_price;
$logo_price = ($profile_logoprce - $profileprce);

$free_expiredays = $price_infos->expire_days;
?> 
<div class="box box-primary">   
    <div class="box-body">
        <div class="row">
        <?php if (isset($model->ID_FOURNISSEUR)) {
            ?>
            <div class="col-md-6">
                
                <div class="box-header">
                    <h3 class="box-title">Current subscription expiry dates </h3>
                </div>


                <div class="box">                   
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>                              
                                <th>Profile expiry date</th>
                                <th>Logo expiry date</th>                                                          
                            </tr>                           
                            <tr>
                                <td><?php echo Myclass::dateFormat($model->profile_expirydate); ?></td>
                                <td><?php echo Myclass::dateFormat($model->logo_expirydate); ?></td>                              
                            </tr>   
                        </table>
                    </div><!-- /.box-body -->                    
                </div><!-- /.box -->
            </div>
           <div class="col-md-6">&nbsp;</div>
        <?php }
        ?>
            <?php if (isset($model->ID_FOURNISSEUR)) {
                $sub_name = "Renew Subscription";
            }else{
                $sub_name = "Subscription";
            }
            ?>
           
        <div class="col-md-12">   
            
            <div class="box-header">
                <h3 class="box-title"><?php echo $sub_name; ?> </h3>
            </div>
           

            <div class="form-group">
                <?php echo $form->labelEx($pmodel, 'subscription_type', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-5">                     
                    <div class="checkbox">
                        <label>
                            <?php echo $form->checkBox($pmodel, 'profile', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($pmodel, 'profile') . " ( " . $profileprce . " CAD )"; ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <?php echo $form->checkBox($pmodel, 'logo', array('value' => 1, 'uncheckValue' => 0)); ?>   
                            <?php echo $form->labelEx($pmodel, 'logo') . " ( " . $logo_price . " CAD )"; ?>
                        </label>
                    </div>                       
                    <?php echo $form->error($pmodel, 'logo'); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($pmodel, 'pay_type', array('class' => 'col-sm-2 control-label')); ?>    
                <div class="col-sm-5">        
                    <?php echo $form->radioButtonList($pmodel, 'pay_type', array('1' => 'Free', '2' => 'By Cheque'), array('separator' => ' ')); ?> 
                </div>     
            </div>
            
             <div id="by_free" class="col-md-12">   
                 <p style="color: red;"><strong>Hint* :</strong> Pay type <strong>"Free"</strong> subscription for profile/logo will active only for<strong> <?php echo $free_expiredays;?> days </strong>.If you want to adjust the days , please <strong><a href="<?php echo Yii::app()->createUrl('/admin/supplierSubscriptionPrice/update/id/1/type/supplier');?>">click here</a></strong>.This expire days will affect only for current subscription.</p>   
            </div> 

            <div id="by_cheque" style="display:none;">
                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'cheque_num', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">    
                        <?php echo $form->textField($pmodel, 'cheque_num', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($pmodel, 'cheque_num'); ?>
                    </div>    
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'cheque_account_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5"> 
                        <?php echo $form->textField($pmodel, 'cheque_account_name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($pmodel, 'cheque_account_name'); ?>
                    </div>    
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'cheque_account_type', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5"> 
                        <?php echo $form->textField($pmodel, 'cheque_account_type', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($pmodel, 'cheque_account_type'); ?>
                    </div>    
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'cheque_bank', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5"> 
                        <?php echo $form->textField($pmodel, 'cheque_bank', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($pmodel, 'cheque_bank'); ?>
                    </div>    
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'cheque_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5"> 
                        <?php echo $form->textField($pmodel, 'cheque_date', array('class' => 'form-control date', 'readonly' => 'true')); ?>
                        <?php echo $form->error($pmodel, 'cheque_date'); ?>
                    </div>    
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'cheque_price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5"> 
                        <?php echo $form->textField($pmodel, 'cheque_price', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($pmodel, 'cheque_price'); ?>
                    </div>    
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'notes', array('class' => 'col-sm-2 control-label')); ?>                                
                    <div class="col-sm-5"> 
                        <?php echo $form->textArea($pmodel, 'notes', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>
                        <?php echo $form->error($pmodel, 'notes'); ?>
                    </div>    
                </div>
            </div>

            <div class="box-footer">
                <div class="form-group">
                    <div class="col-lg-12">
                        <?php echo CHtml::submitButton($pmodel->isNewRecord ? 'Submit' : 'Renew', array('class' => $pmodel->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>  
         
        </div>
        </div>    
    </div>  
</div>
<?php $this->endWidget(); ?>

<?php
$js = <<< EOD
$(document).ready(function(){        
   $('.year').datepicker({ dateFormat: 'yyyy' });
   $('.date').datepicker({ format: 'yyyy-mm-dd' });     
       
});
EOD;
Yii::app()->clientScript->registerScript('_pform', $js);
?>