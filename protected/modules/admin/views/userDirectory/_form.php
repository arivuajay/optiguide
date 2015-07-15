<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-directory-form',
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
                        <?php
                        //echo $form->textField($model, 'LANGUE', array('class' => 'form-control', 'size' => 2, 'maxlength' => 2));
                        echo $form->dropDownList($model, 'LANGUE', array("FR" => 'Français', "EN" => 'Anglais'),array('class'=>'form-control'));
                        ?>
                        <?php echo $form->error($model, 'LANGUE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PREFIXE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PREFIXE', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($model, 'PREFIXE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NOM_UTILISATEUR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NOM_UTILISATEUR', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'NOM_UTILISATEUR'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'USR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php
                        if ($model->isNewRecord)
                        {
                        ?>  
                            <?php echo $form->textField($model, 'USR', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                            <?php echo $form->error($model, 'USR'); ?>
                            <?php
                        } else {
                            echo $model->USR;
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PWD', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PWD', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'PWD'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'COURRIEL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'COURRIEL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ABONNE_MAILING', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->radioButtonList($model, 'ABONNE_MAILING', array('1' => 'Oui', '0' => 'Non')); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ABONNE_PROMOTION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                     
                        <?php echo $form->radioButtonList($model, 'ABONNE_PROMOTION', array('1' => 'Oui', '0' => 'Non')); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ABONNE_TRANSITION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">

                        <?php echo $form->radioButtonList($model, 'ABONNE_TRANSITION', array('1' => 'Oui', '0' => 'Non')); ?> 

                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'bSubscription_envision', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->radioButtonList($model, 'bSubscription_envision', array('1' => 'Oui', '0' => 'Non')); ?> 
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'bSubscription_envue', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->radioButtonList($model, 'bSubscription_envue', array('1' => 'Oui', '0' => 'Non')); ?> 

                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'MUST_VALIDATE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo "<p>Cet utilisateur a la responsabilité de valider les données :</p>"; ?>
                        <?php //echo $form->textField($model, 'MUST_VALIDATE', array('class' => 'form-control'));  ?>
                        <?php echo $form->radioButtonList($model, 'MUST_VALIDATE', array('1' => 'Oui', '0' => 'Non')); ?>                      
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NOTE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php
                        echo "<p>Cet utilisateur ne sera pas associé à une compagnie mais le compte sera valide.</p>"
                        . "Pour créer une association de compagnie ou de professionnel, utilisez les interfaces respectifs des modules Associations, Détaillants, Fournisseurs et Professionnels en cliquant sur l'icône 'cadenas'.";
                        ?>

                    </div>
                </div>   



            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add this user' : 'Update', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>