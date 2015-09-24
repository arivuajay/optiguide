<?php
/* @var $this ClientMessagesController */
/* @var $model ClientMessages */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);

$date_remember = $model->date_remember;

if(!$model->status){ $model->status=0;}
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $clients   = CHtml::listData(ClientProfiles::model()->findall(array("order"=>"name asc")), 'client_id', 'name');           
            $employees = CHtml::listData(EmployeeProfiles::model()->findall(array("order"=>"employee_name asc")), 'employee_id', 'employee_name');
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'client-messages-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'client_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'client_id', $clients, array('class' => 'form-control',"empty"=>"Select Client")); ?> 
                        <?php echo $form->error($model, 'client_id'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'employee_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'employee_id', $employees, array('class' => 'form-control',"empty"=>"Select employee")); ?> 
                        <?php echo $form->error($model, 'employee_id'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'date_remember', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'date_remember', array('class' => 'form-control date')); ?>
                        <?php echo $form->error($model, 'date_remember'); ?>
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
                    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($model, 'status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'créer' : 'modifier', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
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
        
   $('.year').datepicker({ dateFormat: 'yyyy' });
   $('.date').datepicker({ format: 'dd-mm-yyyy', startDate: '+0d',});   
  
        
    var date_remember = '{$date_remember}';
    if(date_remember=='')
    {
       $( "#ClientMessages_date_remember" ).datepicker( "setDate" , new Date())     
    }
    
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>