<?php
/* @var $this PubliciteAdsenseController */
/* @var $model PubliciteAdsense */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            if($model->status==''){$model->status=0;}
            $all_banner_poitions = PublicityPosition::model()->findAll(array('order' => 'iId_position ASC', 'condition' => "iId_position!=0"));
            foreach ($all_banner_poitions as $positions) {
                $position_id = $positions['iId_position'];
                $banner_poitions[$position_id] = $positions['sPosition'] . " " . $positions['sFormat'];
            }


            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'publicite-adsense-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'iId_position', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'iId_position', $banner_poitions, array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'iId_position'); ?>
                    </div>
                </div>     

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'content', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'content', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'content'); ?>
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
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>