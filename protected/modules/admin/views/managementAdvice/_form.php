<?php
/* @var $this ManagementAdviceController */
/* @var $model ManagementAdvice */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'management-advice-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LANGUE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                      
                        <?php echo $form->dropDownList($model, 'LANGUE', array("FR" => 'Français', "EN" => 'Anglais'),array('class'=>'form-control'));?>
                        <?php echo $form->error($model, 'LANGUE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TITRE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TITRE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'TITRE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'SYNOPSYS', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'SYNOPSYS', array('class' => 'form-control', 'maxlength' => 500, 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'SYNOPSYS'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TEXTE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'TEXTE', array('class' => 'form-control', 'maxlength' => 5000, 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'TEXTE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LIEN_URL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_URL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LIEN_TITRE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_TITRE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_TITRE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'AFFICHER_SITE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                      
                         <?php echo $form->radioButtonList($model, 'AFFICHER_SITE', array('1' => 'Oui', '0' => 'Non'),array('separator'=>' ')); ?> 
                        <?php echo $form->error($model, 'AFFICHER_SITE'); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter ce conseil' : 'Modifier ce conseil', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>