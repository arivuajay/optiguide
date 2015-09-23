<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'payment-transaction-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                      
                        <?php echo $form->dropDownList($model, 'payment_status', array("Pending" => 'Pending', "Completed" => 'Completed'), array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'payment_status'); ?>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Modifier l\'état de paiement', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>