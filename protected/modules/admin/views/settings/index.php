<?php
/* @var $this SettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Settings';
$this->breadcrumbs = array(
    'Settings',
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'setting-form',
    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
?>
<div class="box box-primary">
    <div class="col-lg-6 col-xs-12">
        <div class="box-body">

            <div class="box-header">
                <h3 class="box-title">PayPal Advanced</h3>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'payment_mode', array('class' => 'col-sm-4 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->dropDownList($model, 'payment_mode', array("1" => "SandBox Mode", "2" => "Production Mode"), array('class' => 'form-control')); ?>   
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'payment_partner', array('class' => 'col-sm-4 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textField($model, 'payment_partner', array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'payment_vendor_id', array('class' => 'col-sm-4 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textField($model, 'payment_vendor_id', array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'payment_vendor_user', array('class' => 'col-sm-4 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textField($model, 'payment_vendor_user', array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'payment_vendor_pass', array('class' => 'col-sm-4 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->passwordField($model, 'payment_vendor_pass', array('class' => 'form-control')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12">

            <div class="box-body">
                <div class="box-header">
                    <h3 class="box-title">Standard Paypal</h3>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'st_payment_mode', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'st_payment_mode', array("1" => "SandBox Mode", "2" => "Production Mode"), array('class' => 'form-control')); ?>   
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'business_email', array('class' => 'col-sm-4 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'business_email', array('class' => 'form-control')); ?>   
                        <?php echo $form->hiddenField($model, 'currency', array('class' => 'form-control', 'value'=>'CAD')); ?>   
                        
                    </div>
                </div>
            </div><!-- /.box-body -->

        </div><!-- ./col -->
        <div class="col-lg-12 col-xs-12">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Gateway</label>
                    <div class="col-sm-5">
                        <?php echo $form->checkBox($model, 'paypal_advanced_status', array('value' => 2, 'uncheckValue' => 1)); ?>
                        <?php echo $form->labelEx($model, 'paypal_advanced_status'); ?>
                        <?php echo $form->checkBox($model, 'paypal_standard_status', array('value' => 2, 'uncheckValue' => 1)); ?>                        
                        <?php echo $form->labelEx($model, 'paypal_standard_status'); ?>
                        <?php echo $form->error($model, 'option_value') ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
                    </div>
                </div>
            </div> 
        </div>
    </div><!-- ./col -->
</div>
<?php $this->endWidget(); ?>
