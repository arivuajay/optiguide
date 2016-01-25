<?php
/* @var $this SupplierSubscriptionPriceController */
/* @var $model SupplierSubscriptionPrice */
/* @var $form CActiveForm */
$no_of_months = Myclass::noOfMonths_sales_rep();
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'supplier-subscription-price-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            $disptype = Yii::app()->request->getParam('type');
            
            ?>
            <div class="box-body">
                <?php
                if($disptype=="stats")
                {?>    
                 
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'rep_statistics_price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'rep_statistics_price', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'rep_statistics_price'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'rep_expire_days', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'rep_expire_days', $no_of_months, array('class' => 'form-control')); ?>  
                        <?php // echo $form->textField($model, 'rep_expire_days', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'rep_expire_days'); ?>
                    </div>
                </div>
                <?php }else{?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'profile_price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'profile_price', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'profile_price'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'profile_logo_price', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'profile_logo_price', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'profile_logo_price'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'expire_days', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'expire_days', array('class' => 'form-control')); ?> 
                        <?php echo $form->error($model, 'expire_days'); ?>
                    </div>
                     <div class="col-sm-5">
                         (in days)
                     </div>     
                </div>
                
<!--                <div class="form-group">
                    <?php //echo $form->labelEx($model, 'tax', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php //echo $form->textField($model, 'tax', array('class' => 'form-control')); ?> 
                        <?php //echo $form->error($model, 'tax'); ?>
                    </div>
                     <div class="col-sm-5">
                        % (in Percentage)
                     </div>     
                </div>-->
                <?php }
                  echo CHtml::hiddenField('disp_type' , $disptype);
                ?>
               

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Modifier le prix de subscrption', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>