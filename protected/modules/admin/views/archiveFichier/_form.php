<?php
/* @var $this ArchiveFichierController */
/* @var $model ArchiveFichier */
/* @var $form CActiveForm */


$drp_val_cat['class'] = 'form-control';
$drp_val_cat['empty'] = Myclass::t('APP60');
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'archive-fichier-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),               
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_CATEGORIE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_CATEGORIE', $getallcat, $drp_val_cat); ?>         
                        <?php echo $form->error($model, 'ID_CATEGORIE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TITRE_FICHIER_FR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TITRE_FICHIER_FR', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'TITRE_FICHIER_FR'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TITRE_FICHIER_EN', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TITRE_FICHIER_EN', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'TITRE_FICHIER_EN'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'MOTS_CLE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                      
                        <?php echo $form->textArea($model, 'MOTS_CLE', array('class' => 'form-control', 'maxlength' => 500, 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'MOTS_CLE'); ?>
                    </div>
                </div>
               
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'DISPONIBLE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                        
                        <?php echo $form->radioButtonList($model, 'DISPONIBLE', array('1' => 'Oui', '0' => 'Non'),array('separator'=>' ')); ?> 
                        <?php echo $form->error($model, 'DISPONIBLE'); ?>
                    </div>
                </div>
                
                     
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'image', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">      
                        <?php echo $form->fileField($model, 'image');?>                         
                        <?php echo $form->error($model, 'image'); ?>
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