<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */
/* @var $form CActiveForm */
?>
<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->title='Modifier les informations';
$this->breadcrumbs=array(
	'Fournisseurs transactions de paiement'=>array('index'),
	'Modifier les informations',
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);

?>

<div class="user-create">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="box box-primary">
                <?php
                $actionurl = Yii::app()->createUrl('/admin/paymentTransaction/modifypayment/',array("id"=>$pmodel->payment_transaction_id)); 
                $form = $this->beginWidget('CActiveForm', array(
                'id' => 'payment-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'action' => $actionurl,
                    ));
                ?>
                <div class="box-body">
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
                    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-0 col-sm-offset-2">
                            <?php echo CHtml::submitButton('Modifier l\'état de paiement', array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div><!-- ./col -->
    </div>
</div>
<?php
$js = <<< EOD
$(document).ready(function(){        
   $('.year').datepicker({ dateFormat: 'yyyy' });
   $('.date').datepicker({ format: 'yyyy-mm-dd' });     
       
});
EOD;
Yii::app()->clientScript->registerScript('_pform', $js);
?>