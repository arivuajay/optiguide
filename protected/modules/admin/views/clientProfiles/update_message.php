<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
            <div class="box-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'client-message-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    
                ));
                ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'message', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">                       
                        <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>       
                        <?php echo $form->error($model, 'message'); ?>
                    </div>
                </div>
                
                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'afile', array('class' => 'col-sm-3 control-label')); ?>     
                    <div class="col-sm-9">     
                        <?php echo $form->fileField($model, 'afile'); ?>                         
                        <?php echo $form->error($model, 'afile'); ?>
                    </div>
                </div>
                <div class="form-group"> 
                    <?php echo CHtml::submitButton('Update', array('class' => 'btn btn-primary')); ?>
                </div>    
                <?php $this->endWidget(); ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>




