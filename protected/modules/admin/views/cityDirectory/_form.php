<?php
/* @var $this CityDirectoryController */
/* @var $model CityDirectory */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-directory-form',
        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	'enableAjaxValidation'=>true,
));
            

            ?>
            <div class="box-body">
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'country',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'country', $country ,array('class'=>'form-control','empty'=>'Select Country')); ?>                          
                        <?php echo $form->error($model,'country'); ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <?php echo $form->labelEx($model,'REGION',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'REGION', $regions ,array('class'=>'form-control','empty'=>'Select Region')); ?>                          
                        <?php echo $form->error($model,'REGION'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'NOM_VILLE',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'NOM_VILLE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'NOM_VILLE'); ?>
                        </div>
                    </div>

                                </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>