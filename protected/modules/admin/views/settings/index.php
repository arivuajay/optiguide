<?php
/* @var $this SettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Settings';
$this->breadcrumbs = array(
    'Settings',
);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'setting-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            ));
            ?>
            <div class="box-body">

                <div class="box-header">
                    <h3 class="box-title">PayPal Advanced</h3>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_mode', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'payment_mode', array("1" => "SandBox Mode", "2" => "Production Mode"), array('class' => 'form-control')); ?>   
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_partner', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'payment_partner', array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_vendor_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'payment_vendor_id', array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_vendor_user', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'payment_vendor_user', array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_vendor_pass', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->passwordField($model, 'payment_vendor_pass', array('class' => 'form-control')); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>