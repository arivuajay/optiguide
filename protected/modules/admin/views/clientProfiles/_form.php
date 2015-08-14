<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */
/* @var $form CActiveForm */


$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);

?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'client-profiles-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'client', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'client', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'client'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'first_name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'first_name'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'lastname', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'lastname', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'lastname'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'country', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'country'); ?>
                    </div>
                 </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'region', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'region', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'region'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ville', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ville', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'ville'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'address', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'address'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'pincode', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'pincode', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'pincode'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'mail', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'mail', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'mail'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phonenumber', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'phonenumber', array('class' => 'form-control', 'size' => 60, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'phonenumber'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'message', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'message'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'meeting_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'meeting_date', array('class' => 'form-control date', 'readonly' => 'true')); ?>
                        <?php echo $form->error($model, 'meeting_date'); ?>
                    </div>
                </div>


            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter un rappel' : 'Modifier ce rappel', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$js = <<< EOD
$(document).ready(function(){
        
    var date = new Date();
    date.setDate(date.getDate()-1);    
    $('.year').datepicker({ dateFormat: 'yyyy' });
    $('.date').datepicker({ 
        format: 'yyyy-mm-dd',
        startDate: new Date()
     }); 
                
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>